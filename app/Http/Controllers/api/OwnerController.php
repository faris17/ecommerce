<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Helpers\ResponseFormatter;
use Exception;

use App\Models\Owner;
use App\Models\PayOwner;
use Illuminate\Support\Facades\Auth;

class OwnerController extends Controller
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
            $owner =  Owner::with(['typeowner', 'user']);
            //jika admin
            if (Auth::user()->level == 'admin') {
                if ($status) {
                    $owner->where('status', $status);
                }
            }
            //jika user, hanya status enable saja yang tampil
            else {
                $owner->where('status', 'enabled');
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
        try {
            $request->validate([
                'namausaha' => 'required|unique:owners,namausaha|min:3',
                'deskripsiowner' => 'required|min:10',
            ]);
            $file = '';

            if ($request->file('coverimage')) {
                $request->validate([
                    'coverimage' => 'required|mimes:png,jpg,jpeg',
                ]);

                $file = $request->file('coverimage')->store('coverowner', 'public');
            }
            $owner_id = Owner::create([
                'namausaha' => $request->namausaha,
                'user_id' => Auth::user()->id,
                'deskripsiowner' => $request->deskripsiowner,
                'coverimage' => $file,
                'status' => 'waiting'
            ])->id;

            //insert into pay_owners table
            $payowner = PayOwner::create([
                'owner_id' => $owner_id,
                'typeowner_id' => $request->typeowner,
                'harga' => $request->harga
            ]);

            return ResponseFormatter::success(
                $payowner,
                'Data Owner berhasil dibuat'
            );
        } catch (Exception $error) {
            return ResponseFormatter::error(
                [
                    'message' => 'File Required',
                ],
                'Error Failed',
                204
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $owner =  Owner::with(['typeowner'])->where('id', $id)->get();
            return ResponseFormatter::success(
                $owner,
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'namausaha' => 'required|unique:owners,namausaha|min:3',
                'deskripsiowner' => 'required|min:10',
            ]);
            $file = '';

            $data = Owner::findOrFail($id);

            if ($request->file('coverimage')) {

                $request->validate([
                    'coverimage' => 'required|mimes:png,jpg,jpeg',
                ]);
                //hapus file sebelumnya
                if ($data->coverimage && file_exists(storage_path('app/public/coverowner/' . $data->coverimage))) {
                    Storage::delete('public/coverowner/' . $data->coverimage);
                }
                $file = $request->file('coverimage')->store('coverowner', 'public');
                $data->coverimage = $file;
            }
            //set data
            $data->namausaha = $request->namausaha;
            $data->deskripsiowner = $request->deskripsiowner;
            $data->user_id = Auth::user()->id;
            $data->update();

            return ResponseFormatter::success(
                null,
                'Data Owner berhasil dirubah'
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
