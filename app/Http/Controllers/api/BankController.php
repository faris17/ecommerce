<?php

namespace App\Http\Controllers\api;

use App\Helpers\ResponseFormatter;
use App\Models\Bank;
use App\Http\Controllers\Controller;
use App\Models\BankHasUser;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $pagination = 30;
            $categ =  Bank::paginate($pagination);
            return ResponseFormatter::success(
                $categ,
                'Data Bank berhasil diambil'
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
            'kode' => 'required|unique:banks,kode|min:3',
            'namabank' => 'required|min:3',
        ]);

        $bank = Bank::create([
            'kode' => $request->kode,
            'namabank' => $request->namabank,
        ]);

        return ResponseFormatter::success(
            $bank,
            'Data Bank berhasil dibuat'
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
            $bank = Bank::findOrFail($id);
            return ResponseFormatter::success($bank, 'Berhasil');
        } catch (Exception $error) {
            return ResponseFormatter::error(
                [
                    'message' => 'Get Bank Failed',
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
                'kode' => 'required|unique:banks,kode|min:3',
                'namabank' => 'required|min:3',
            ]);

            $input = $request->all();
            $update = Bank::findOrFail($id)->update($input);
            if ($update) {
                $bank = Bank::findOrFail($id);
                return ResponseFormatter::success($bank, 'Berhasil Update');
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
        try {
            $bank = Bank::findOrFail($id);
            $bank->delete();
            return ResponseFormatter::success($bank, 'Delete successfull');
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

    public function addUserBank(Request $request)
    {
        $iduser = Auth::user()->id;
        $bank_id = $request->idbank;
        $norek = $request->norek;

        $bank = BankHasUser::create([
            'bank_id' => $bank_id,
            'user_id' => $iduser,
            'nomorrekening' => $norek
        ]);
        if ($bank) {
            return ResponseFormatter::success(null, 'Berhasil ditambah');
        } else {
            return ResponseFormatter::error(
                [
                    'message' => 'Add Failed',
                ],
                'Error Failed',
                204
            );
        }
    }

    public function getRekUser($id)
    {
        $data = BankHasUser::with(['user', 'bank'])->where('user_id', $id)->get();
        if ($data) {
            return ResponseFormatter::success($data, 'Berhasil ambil');
        } else {
            return ResponseFormatter::error(
                [
                    'message' => 'Add Failed',
                ],
                'Error Failed',
                204
            );
        }
    }

    public function updaterek(Request $request, $id)
    {
        $bank_id = $request->idbank;
        $norek = $request->norek;

        $data = BankHasUser::findOrFail($id);
        $data->bank_id = $bank_id;
        $data->nomorrekening = $norek;

        if ($data->update()) {
            return ResponseFormatter::success(null, 'Berhasil diupdate');
        } else {
            return ResponseFormatter::error(
                [
                    'message' => 'Add Failed',
                ],
                'Error Failed',
                204
            );
        }
    }

    public function deleteRek($id)
    {
        $hasil = BankHasUser::where('id', $id)->where('user_id', Auth::user()->id)->delete();
        if ($hasil) {
            return ResponseFormatter::success(null, 'Berhasil didelete');
        } else {
            return ResponseFormatter::error(
                [
                    'message' => 'Delete Failed',
                ],
                'Error Failed',
                204
            );
        }
    }
}
