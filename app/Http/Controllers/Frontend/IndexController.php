<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Owner;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class IndexController extends Controller
{
    public function index()
    {

        $user = '';
        $activeHome = 'active';
        if (Auth::user() != null) {
            $id = Auth::user()->id;
            $user = User::find($id);
        }

        //get Data Category
        $categories = Category::limit(10)->get();

        //get Data Owner
        $owners = Owner::where('status', 'enabled')->inRandomOrder()->limit(6)->get();
        //get Data Product
        $products = Product::with(['categories', 'owner'])->whereHas('owner', function ($query) {
            $query->where('status', '=', 'enabled');
        })->inRandomOrder()->limit(6)->get();

        return view('frontend.index', compact(
            'user',
            'products',
            'categories',
            'owners',
            'activeHome'
        ));
        // return $owners;
    }

    public function UserLogout()
    {
        Auth::logout();
        return Redirect()->route('login');
    }

    public function UserProfile()
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        return view('frontend.profile.user_profile', compact('user'));
    }

    public function UserProfileStore(Request $request)
    {
        $data = User::find(Auth::user()->id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->nohp = $request->nohp;
        $data->alamat = $request->alamat;

        if ($request->file('profile_photo_path')) {
            if ($data->profile_photo_path != null) {
                @unlink(public_path('upload/admin_images/' . $data->profile_photo_path));
            }
            $request->validate([
                'profile_photo_path' => 'required|mimes:png,jpg,jpeg|max:10048'
            ]);
            $file = $request->file('profile_photo_path');
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('upload/user_images'), $filename);
            $data->profile_photo_path = $filename;
        }

        $data->save();
        $notification = array(
            'message' => 'User Profile Updated Successfully',
            'alert-type' => 'success'
        );


        return redirect()->route('home')->with(
            $notification
        );
    }

    public function UserChangePassword()
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        return view('frontend.profile.change_password', compact('user'));
    }

    public function UserPasswordUpdate(Request $request)
    {
        $validateData = $request->validate([
            'oldpassword' => 'required',
            'password' => 'required|confirmed',
        ]);

        $hashedPassword = Auth::user()->password;
        if (Hash::check($request->oldpassword, $hashedPassword)) {
            $user = User::find(Auth::user()->id);
            $user->password = Hash::make($request->password);
            $user->save();
            Auth::logout();
            return redirect()->route('user.logout');
        } else {
            return redirect() . back();
        }
    }
}
