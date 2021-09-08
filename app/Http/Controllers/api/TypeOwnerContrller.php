<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use Exception;

use App\Models\Typeowner;

class TypeOwnerContrller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $pagination = 10;
            $categ =  Typeowner::paginate($pagination);
            return ResponseFormatter::success(
                $categ,
                'Data Type owner berhasil diambil'
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
        $request->validate([
            'nametypeowner' => 'required|unique:typeowners,nametypeowner|min:3',
        ]);

        $typeowner = Typeowner::create([
            'nametypeowner' => $request->nametypeowner,
            'harga' => $request->harga,
            'perpanjang' => $request->perpanjang,
            'keterangan' => $request->keterangan
        ]);

        return ResponseFormatter::success(
            $typeowner,
            'Data Type Owner berhasil dibuat'
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
        try {
            $typeowner = Typeowner::findOrFail($id);
            return ResponseFormatter::success($typeowner, 'Berhasil');
        } catch (Exception $error) {
            return ResponseFormatter::error(
                [
                    'message' => 'Get TypeOwner Failed',
                    'error' => $error
                ],
                'Error Failed',
                204
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
        //edit category
        try {
            $request->validate([
                'nametypeowner' => 'required|unique:typeowners,nametypeowner|min:3',
            ]);
            $input = $request->all();
            $update = Typeowner::findOrFail($id)->update($input);
            if ($update) {
                $typeowner = Typeowner::findOrFail($id);
                return ResponseFormatter::success($typeowner, 'Berhasil Update');
            } else {
                return ResponseFormatter::error(
                    [
                        'message' => 'Update Failed',
                    ],
                    'Error Failed',
                    204
                );
            }
        } catch (Exception $error) {
            return ResponseFormatter::error(
                [
                    'message' => 'Update Failed',
                    'error' => $error
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
        try {
            $typeowner = Typeowner::findOrFail($id);
            $typeowner->delete();
            return ResponseFormatter::success($typeowner, 'Delete successfull');
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
