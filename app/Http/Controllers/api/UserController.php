<?php

namespace App\Http\Controllers\api;


use App\Models\User;
use App\Rules\MatchOldPassword;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Exception;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $pagination = 10;
            $users =  User::paginate($pagination);
            return ResponseFormatter::success(
                $users,
                'Data Users berhasil diambil'
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

    //Menambah User
    public function store(Request $request)
    {
        //
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
            if (Auth::user()->level == 'admin') {
                $user = User::find($id);
            } else {
                $user = Auth::user();
            }

            //update field user
            $user->name = $request->name;
            $user->email = $request->email;
            $user->nohp = $request->nohp;
            $user->alamat = $request->alamat;
            $user->kota = $request->kota;

            //update
            $update = $user->update();
            if ($update) {
                return ResponseFormatter::success($user, 'Profile Updated');
            }
        } catch (Exception $error) {
            return ResponseFormatter::error(
                [
                    'message' => 'No Data',
                    'error' => true
                ],
                'Error Failed',
                204
            );
        }
    }

    //Change Password
    public function changePassword(Request $request)
    {
        try {
            $request->validate([
                'current_password' => ['required', new MatchOldPassword],
                'new_password' => ['required'],
                'new_confirm_password' => ['same:new_password'],
            ]);

            $hasil = User::find(Auth::user()->id)->update(['password' => Hash::make($request->new_password)]);

            if ($hasil) {
                return ResponseFormatter::success('null', 'Password Changed');
            } else {
                return ResponseFormatter::error(
                    [
                        'message' => 'Error Changed Failed',
                    ],
                    'Change Password Failed',
                    203
                );
            }
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return ResponseFormatter::success($user, 'Delete successfull');
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

    //Admin mengubah level user
    public function changelevel(Request $request)
    {

        $user = User::findOrFail($request->id);

        $user->level = $request->level;
        $user->update();
        return ResponseFormatter::success($user, 'Update successfull');
    }

    public function uploadPhoto(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);

        if ($request->file('profile')) {
            $request->validate([
                'profile' => 'required|mimes:png,jpg,jpeg',
            ]);
            if ($user->profile_photo_path && file_exists(storage_path('app/public/profile' . $user->profile_photo_path))) {
                Storage::delete('public/profile' . $user->profile_photo_path);
            }
            $file = $request->file('profile')->store('profiles', 'public');
            $user->profile_photo_path = $file;
            $user->update();
            return ResponseFormatter::success($user->profile_photo_path, 'Update successfull');
        } else {
            return ResponseFormatter::error(
                [
                    'message' => 'File Required',
                ],
                'Error Failed',
                204
            );
        }
    }

    // //get data bank berdasarkan user
    // public function getBankByUser($id = null)
    // {
    //     if ($id == null) {
    //         $id = Auth::user()->id;
    //     }
    //     $user = User::find($id);
    //     $data = $user->banks;

    //     return ResponseFormatter::success($data, 'Get successfull');
    // }
}
