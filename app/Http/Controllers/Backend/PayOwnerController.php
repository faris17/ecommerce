<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\RandomDigit;
use App\Http\Controllers\Controller;
use App\Models\Owner;
use App\Models\PayOwner;
use Illuminate\Http\Request;

class PayOwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $pagination = 20;

        $data = Payowner::whereHas('owner', function ($query) use ($request) {
            $query->where('namausaha', 'like', "%{$request->namausaha}%");
            if ($request->tahun != null) {
                $query->whereYear('tanggalbayar', '=', $request->tahun);
            }
        })->with(['owner', 'typeowner'])
            ->orderBy('created_at', 'desc')->paginate($pagination);

        return view('admin.payowner.index_payowner', [
            'data' => $data,
        ])->with('i', ($request->input('page', 1) - 1) * $pagination);
        // return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $data = PayOwner::findOrFail($id);

        return view('admin.payowner.form_payowner', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = new PayOwner();
        //set data
        $data->owner_id = $request->owner_id;
        $data->typeowner_id = $request->typeowner_id;
        $data->status = $request->status;
        $data->tanggalbayar = $request->tanggalbayar;
        $data->harga = $request->harga;

        //make transaction digit
        $transaction_number = RandomDigit::getRandom('own');

        $data->transactionid = $transaction_number;

        if ($request->file('notabayar')) {

            $request->validate([
                'notabayar' => 'mimes:png,jpg,jpeg|max:10048'
            ]);

            $file = $request->file('notabayar');
            $filename = hexdec(uniqid()) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload/notabayar/'), $filename);
            $data->notabayar = $filename;
        }

        $hasil = $data->save();
        //jika update berhasil, update status owner
        if ($hasil) {
            $dataowner = Owner::findOrFail($request->owner_id);
            if ($request->status == 'SUCCESS')
                $dataowner->status = 'enabled';
            else {
                $dataowner->status = 'disabled';
            }
            $dataowner->update();
        }

        $notification = array(
            'message' => 'Added Pay Owner Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('admin.payowner.index')->with(
            $notification
        );
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
        $data = PayOwner::with(['owner'])->findOrFail($id);
        return view('admin.payowner.form_edit_payowner', compact('data'));
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
        $data = PayOwner::findOrFail($id);
        //set data
        $data->status = $request->status;
        $data->tanggalbayar = $request->tanggalbayar;
        $data->harga = $request->harga;

        if ($request->file('notabayar')) {

            $request->validate([
                'notabayar' => 'mimes:png,jpg,jpeg|max:10048'
            ]);
            if ($request->file('notabayar') != null) {
                @unlink(public_path('upload/notabayar/' . $data->coverimage));
            }
            $file = $request->file('notabayar');
            $filename = hexdec(uniqid()) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload/notabayar/'), $filename);
            $data->notabayar = $filename;
        }

        $hasil = $data->update();
        //jika update berhasil, update status owner
        if ($hasil) {
            $dataowner = Owner::findOrFail($data->owner_id);
            if ($request->status == 'SUCCESS')
                $dataowner->status = 'enabled';
            else {
                $dataowner->status = 'disabled';
            }
            $dataowner->update();
        }



        if ($request->editpayowner == 'editpayowner') {
            $notification = array(
                'message' => 'Update Pay Owner Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('admin.payowner.index')->with(
                $notification
            );
        } else {
            $notification = array(
                'message' => 'Confirm Payment Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('admin.owner')->with(
                $notification
            );
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
        $payowner = PayOwner::findOrFail($id);
        $payowner->delete();
        $notification = array(
            'message' => 'Delete Payment Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with(
            $notification
        );
    }
}
