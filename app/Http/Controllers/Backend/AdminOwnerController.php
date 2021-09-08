<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\RandomDigit;
use App\Http\Controllers\Controller;
use App\Models\Owner;
use App\Models\PayOwner;
use App\Models\Typeowner;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;

use Midtrans\Config;
use Midtrans\Snap;

class AdminOwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pagination = 20;
        $owner =  Owner::when($request->keyword, function ($query) use ($request) {
            $query
                ->where('namausaha', 'like', "%{$request->keyword}%");
        })->orderBy('created_at', 'desc')->paginate($pagination);

        $owner->appends($request->only('keyword'));

        return view('admin.owners.listowners', [
            'owners' => $owner,
        ])->with('i', ($request->input('page', 1) - 1) * $pagination);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $typeowners = Typeowner::select('id', 'nametypeowner')->get();
        return view('admin.owners.form_owner', compact('typeowners'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $user = User::select('id')->where('email', $request->email)->get();
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
            'nohpusaha' => $request->nohpusaha,
            'deskripsiowner' => $request->deskripsiowner,
            'coverimage' => $coverimage,
            'status' => $request->status,
            'user_id' => $user[0]['id']
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
            'payment_url' => null,
        ]);

        // Konfigurasi midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        $midtrans = array(
            'transaction_details' => array(
                'order_id' => $pay_owner->transactionid,
                'gross_amount' => (int) $pay_owner->harga,
            ),
            'customer_details' => array(
                'first_name'    => $owner->namausaha,
                'email' => $request->email
            ),
            'enabled_payments' => array('gopay', 'bank_transfer'),
            'vtweb' => array()
        );

        try {
            // Ambil halaman payment midtrans
            $paymentUrl = Snap::createTransaction($midtrans)->redirect_url;

            $pay_owner->payment_url = $paymentUrl;
            $pay_owner->save();

            $notification = array(
                'message' => 'Owner Updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('admin.owner.confirm', $pay_owner->id)->with(
                $notification
            );
        } catch (Exception $e) {
            return $e;
            $notification = array(
                'message' => 'Error failed',
                'alert-type' => 'error'
            );
            //redirect dengan pesan error
            return redirect()->route('admin.owner.confirm', $pay_owner->id)->with(
                $notification
            );
        }
    }

    public function confirmOwner($id)
    {
        $data = PayOwner::with(['owner', 'typeowner'])->find($id);

        return view('admin.owners.confirm_owner', compact('data'));

        // return $data;
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $data = Owner::find($id)->with(['typeowner'])->get();
        //ambil data typeowner
        $typeowner = Typeowner::all();
        $data = PayOwner::where('owner_id', $id)->with(['owner', 'typeowner'])->first();
        return view('frontend.owners.form_owner_edit', with([
            'data' => $data,
            'typeowners' => $typeowner

        ]));
        // return $typeowners;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $data = Owner::findOrFail($id);
        $data->namausaha = $request->namausaha;
        $data->nohpusaha =  $request->nohpusaha;
        $data->deskripsiowner = $request->deskripsiowner;
        $data->status = $request->status;

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
        if ($data->update()) {
            //update payowner
            $data_payowner = PayOwner::where('owner_id', $id)->firstOrFail();
            $data_payowner->typeowner_id = $request->typeowner_id;

            $data_payowner->update();

            $notification = array(
                'message' => 'Update Owner Successfully',
                'alert-type' => 'success'
            );
            //redirect dengan pesan sukses
            return redirect()->back()->with($notification);
        } else {
            $notification = array(
                'message' => 'Update Owner failed',
                'alert-type' => 'error'
            );
            //redirect dengan pesan error
            return redirect()->back()->with($notification);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $owner = Owner::findOrFail($id);
        $owner->delete();
        $notification = array(
            'message' => 'Owner Deleted Successfully',
            'alert-type' => 'info'
        );
        //redirect dengan pesan sukses
        return redirect()->route('admin.owner')->with($notification);
    }
}
