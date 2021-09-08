<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\PayOwner;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Models\Owner;
use Exception;

class PayOwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $status = $request->status;

            $pagination = 10;
            $owner =  PayOwner::with(['owner', 'typeowner']);

            if ($status) {
                $owner->where('status', $status);
            }

            return ResponseFormatter::success(
                $owner->paginate($pagination),
                'Data Owner berhasil diambil'
            );
        } catch (Exception $error) {
            return ResponseFormatter::error(
                [
                    'message' => 'Something went wrong',
                    'error' => $error
                ],
                'Authentication Failed',
                500
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {

            $data = PayOwner::findOrFail($id);
            //set data
            $data->statusconfirm = $request->statusconfirm;
            $data->tanggalbayar = $request->tanggalbayar;

            if ($request->file('notabayar')) {

                $request->validate([
                    'notabayar' => 'mimes:png,jpg,jpeg|max:10048'
                ]);
                $file = $request->file('notabayar');
                $filename = hexdec(uniqid()) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('upload/notabayar/'), $filename);
                $data->notabayar = $filename;
            }

            $hasil = $data->update();
            //jika update berhasil, update status owner
            if ($hasil) {
                $dataowner = Owner::findOrFail($data->owner_id);
                if ($request->statusconfirm == 'enable')
                    $dataowner->status = 'enabled';
                if ($request->statusconfirm == 'disable')
                    $dataowner->status = 'disabled';
                $dataowner->update();
            }

            $datapayowner = PayOwner::findOrFail($id);
            return ResponseFormatter::success(
                $datapayowner,
                'Data PayOwner berhasil dirubah'
            );
        } catch (Exception $error) {
            return ResponseFormatter::error(
                [
                    'message' => 'Update Error Required',
                ],
                'Error Failed',
                204
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
        //
    }
}
