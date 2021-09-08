<?php

namespace App\Http\Controllers\api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Car;
use App\Models\Owner;
use Exception;
use Illuminate\Support\Facades\Auth;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $value = 'enabled';
            $pagination = 20;
            $car =  Car::with(['owner'])->whereHas('owner', function ($q) use ($value) {
                $q->where('status', '=', $value);
            })->paginate($pagination);
            return ResponseFormatter::success(
                $car,
                'Data Mobil berhasil diambil'
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
                'platnomor' => 'required|unique:cars,platnomor|min:3',
            ]);
            $file = '';

            if ($request->file('gambarmobil')) {
                $request->validate([
                    'gambarmobil' => 'required|mimes:png,jpg,jpeg',
                ]);

                $file = $request->file('gambarmobil')->store('gambarmobil', 'public');
            }
            $car = Car::create([
                'platnomor' => $request->platnomor,
                'harga' => $request->harga,
                'jenismobil' => $request->jenismobil,
                'keterangan' => $request->keterangan,
                'gambarmobil' => $file,
                'owner_id' => $request->owner_id,
            ]);

            return ResponseFormatter::success(
                $car,
                'Data Car berhasil dibuat'
            );
        } catch (Exception $error) {
            return ResponseFormatter::error(
                [
                    'message' => 'Process Add error',
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
            $request->validate([
                'platnomor' => 'required|min:3|unique:cars,platnomor,' . $id,
            ]);

            $data = Car::findOrFail($id);

            if ($request->file('gambarmobil')) {
                $request->validate([
                    'gambarmobil' => 'required|mimes:png,jpg,jpeg',
                ]);
                //hapus file sebelumnya
                if ($data->gambarmobil && file_exists(storage_path('app/public/gambarmobil/' . $data->gambarmobil))) {
                    Storage::delete('public/gambarmobil/' . $data->gambarmobil);
                }

                $file = $request->file('gambarmobil')->store('gambarmobil', 'public');
                $data->gambarmobil = $file;
            }
            $data->platnomor = $request->platnomor;
            $data->harga = $request->harga;
            $data->jenismobil = $request->jenismobil;
            $data->keterangan = $request->keterangan;
            $data->update();

            return ResponseFormatter::success(
                $data,
                'Data Car berhasil dibuat'
            );
        } catch (Exception $error) {
            return ResponseFormatter::error(
                [
                    'message' => 'Process Add error',
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
        //before delete, cek akun owner dan usernya
        //jika admin, langsung delete, jika owner, cek kesesuaian data
        try {
            $car = Car::findOrFail($id);
            if (Auth::user()->level == 'admin') {
                $car->delete();
            } else {
                $data = Owner::findOrFail($car->owner_id)->where('users_id', Auth::user()->id)->count();
                if ($data == 1) {
                    $car->delete();
                } else {
                    return ResponseFormatter::error(
                        [
                            'message' => 'Deleted Failed',
                        ],
                        'Error Failed',
                        204
                    );
                }
            }
            return ResponseFormatter::success($car, 'Delete successfull');
        } catch (Exception $error) {
            return ResponseFormatter::error(
                [
                    'message' => 'Deleted Failed',
                    'error' => $error
                ],
                'Error Failed',
                204
            );
        }
    }
}
