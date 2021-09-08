<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Owner;
use App\Models\PayOwner;
use App\Models\Typeowner;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Helpers\RandomDigit;
use App\Models\Product;
use Illuminate\Support\Facades\Crypt;
use Exception;

use Midtrans\Config;
use Midtrans\Snap;

class OwnerUserController extends Controller
{
    //index
    public function index()
    {

        $userId = Auth::user()->id;
        //get Owner by idUser
        $myowner = Owner::where('user_id', $userId)->get();

        return view('frontend.owners.index_owner', [
            'myowners' => $myowner
        ]);
    }

    public function create()
    {
        $typeowners = Typeowner::select('id', 'nametypeowner', 'harga', 'keterangan')->get();
        return view('frontend.owners.form_owner', [
            'typeowners' => $typeowners
        ]);
    }

    public function store(Request $request)
    {
        $userId = Auth::user()->id;
        $coverimage = '';

        if ($request->file('coverimage')) {

            $request->validate([
                'coverimage' => 'required|mimes:png,jpg,jpeg|max:10048'
            ]);
            $file = $request->file('coverimage');
            $filename = hexdec(uniqid()) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload/owner/'), $filename);
            $coverimage = $filename;
        }

        $owner = Owner::create([
            'namausaha' => $request->namausaha,
            'deskripsiowner' => $request->deskripsiowner,
            'coverimage' => $coverimage,
            'status' => 'waiting',
            'user_id' => $userId
        ]);

        //ambil data typeowner
        $typeowner = Typeowner::find($request->typeowner_id);

        //make transaction digit
        $transaction_number = RandomDigit::getRandom('own');

        //insert Payowner
        $pay_owner = PayOwner::create([
            'transactionid' => $transaction_number,
            'owner_id'      =>  $owner->id,
            'typeowner_id'  =>  $typeowner->id,
            'tanggalbayar' => null,
            'harga' => $typeowner->harga,
            'notabayar' => null,
            'status' => 'PENDING',
            'payment_url' => null,

        ]);

        $notification = array(
            'message' => 'Owner Created Successfully',
            'alert-type' => 'success'
        );

        $parameter = Crypt::encrypt($pay_owner->id);

        return redirect()->route('user.owner.confirm', $parameter)->with(
            $notification
        );
    }

    public function confirm($id)
    {
        $id = Crypt::decrypt($id);

        $data = PayOwner::with(['owner', 'typeowner'])->whereHas('owner', function ($query) {
            $userId = Auth::user()->id;
            $query->where('user_id', '=', $userId);
        })->find($id);
        return view('frontend.owners.confirm_owner', compact('data'));
        // return $data;
    }

    public function getActivate($id)
    {
        $id = Crypt::decrypt($id);

        $data = PayOwner::with(['owner', 'typeowner'])->whereHas('owner', function ($query) {
            $userId = Auth::user()->id;
            $query->where('user_id', '=', $userId);
        })->where('status', '!=', 'SUCCESS')->where('owner_id', $id)->first();
        return view('frontend.owners.confirm_owner', compact('data'));
    }

    public function payment($id)
    {
        $id = Crypt::decrypt($id);

        //get Payowner
        $pay_owner = PayOwner::with(['owner'])->findOrFail($id);

        //make a payment url
        // Konfigurasi midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        //make transaction digit
        $transaction_number = RandomDigit::getRandom('own');

        $midtrans = array(
            'transaction_details' => array(
                'order_id' => $transaction_number,
                'gross_amount' => (int) $pay_owner->harga,
            ),
            'customer_details' => array(
                'first_name'    => $pay_owner->owner->namausaha,
                'email' => Auth::user()->email
            ),
            'enabled_payments' => array('gopay', 'bank_transfer'),
            'vtweb' => array()
        );

        try {
            // Ambil halaman payment midtrans
            $paymentUrl = Snap::createTransaction($midtrans)->redirect_url;

            $pay_owner->payment_url = $paymentUrl;
            $pay_owner->transactionid = $transaction_number;
            $pay_owner->save();


            return response()->json(['success' => $paymentUrl]);;
        } catch (Exception $e) {
            return $e;
        }
    }

    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        // $data = Owner::find($id)->with(['typeowner'])->get();
        //ambil data typeowner
        $typeowner = Typeowner::all();
        $data = Owner::findOrFail($id);
        return view('frontend.owners.form_owner_edit', with([
            'data' => $data,
            'typeowners' => $typeowner

        ]));
        // return $data;
    }

    public function update(Request $request, $id)
    {
        $data = Owner::findOrFail($id);
        $data->namausaha = $request->namausaha;
        $data->deskripsiowner = $request->deskripsiowner;

        if ($request->file('coverimage')) {
            $request->validate([
                'coverimage' => 'required|mimes:png,jpg,jpeg|max:10048'
            ]);
            if ($data->coverimage != null) {
                @unlink(public_path('upload/owner/' . $data->coverimage));
            }
            $file = $request->file('coverimage');
            $filename = hexdec(uniqid()) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload/owner/'), $filename);
            $data->coverimage = $filename;
        }
        $data->update();

        $notification = array(
            'message' => 'Update Owner Successfully',
            'alert-type' => 'success'
        );
        //redirect dengan pesan sukses
        return redirect()->route('user.owners')->with($notification);
    }

    public function destroy($id)
    {
        $id = Crypt::decrypt($id);

        $owner = Owner::findOrFail($id);
        $owner->delete();
        $notification = array(
            'message' => 'Owner Deleted Successfully',
            'alert-type' => 'success'
        );
        //redirect dengan pesan sukses
        return redirect()->route('user.owners')->with($notification);
    }

    public function detail($id)
    {
        $id = Crypt::decrypt($id);

        $owner = Owner::findOrFail($id);

        $products = Product::with(['images'])->where('owner_id', '=', $owner->id)->paginate(15);

        return view('frontend.owners.detail_owner', compact(
            'owner',
            'products'
        ));
        // return $products;
    }
}
