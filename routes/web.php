<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\PayOwnerController;
use App\Http\Controllers\Backend\AdminBankController;
use App\Http\Controllers\Backend\AdminOwnerController;
use App\Http\Controllers\Backend\AdminCategoryController;
use App\Http\Controllers\Backend\AdminCategoryOwnerController;
use App\Http\Controllers\Backend\AdminProfileController;
use App\Http\Controllers\Frontend\IndexController;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

//USER
use App\Http\Controllers\Frontend\OwnerUserController;
use App\Http\Controllers\Frontend\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::group(['prefix' => 'admin', 'middleware' => ['admin:admin']], function () {
    Route::get('/login', [AdminController::class, 'loginForm']);
    Route::post('/login', [AdminController::class, 'store'])->name('admin.login');
});

//category owner/toko
Route::get('/categoryowner', [AdminCategoryOwnerController::class, 'index'])->name('admin.categoryowner');
Route::get('/categoryowner/create', [AdminCategoryOwnerController::class, 'create'])->name('admin.categoryowner.create');
Route::get('/categoryowner/edit/{id}', [AdminCategoryOwnerController::class, 'edit'])->name('admin.categoryowner.edit');
Route::post('/categoryowner/update/{id}', [AdminCategoryOwnerController::class, 'update'])->name('admin.categoryowner.update');
Route::post('/categoryowner/store/', [AdminCategoryOwnerController::class, 'store'])->name('admin.categoryowner.store');
Route::get('/categoryowner/delete/{id}', [AdminCategoryOwnerController::class, 'destroy'])->name('admin.categoryowner.delete');

//admin category product
Route::get('/category', [AdminCategoryController::class, 'index'])->name('admin.category');
Route::get('/category/edit/{id}', [AdminCategoryController::class, 'edit'])->name('admin.category.edit');
Route::post('/category/update/{id}', [AdminCategoryController::class, 'update'])->name('admin.category.update');
Route::post('/category/store/', [AdminCategoryController::class, 'store'])->name('admin.category.store');
Route::get('/category/delete/{id}', [AdminCategoryController::class, 'destroy'])->name('admin.category.delete');

//admin bank
Route::get('/bank', [AdminBankController::class, 'index'])->name('admin.bank');
Route::get('/bank/edit/{id}', [AdminBankController::class, 'edit'])->name('admin.bank.edit');
Route::post('/bank/update/{id}', [AdminBankController::class, 'update'])->name('admin.bank.update');
Route::post('/bank/store/', [AdminBankController::class, 'store'])->name('admin.bank.store');
Route::get('/bank/delete/{id}', [AdminBankController::class, 'destroy'])->name('admin.bank.delete');


Route::middleware(['auth:sanctum,admin', 'verified'])->get('/admin/dashboard', function () {
    return view('admin.index');
})->name('dashboard');

Route::get('/test', function () {
    return view('test');
})->name('test');

//Admin all route
Route::get('/admin/logout', [AdminController::class, 'destroy'])->name('admin.logout');
Route::get('/admin/profile', [AdminProfileController::class, 'AdminProfile'])->name('admin.profile');
Route::get('/admin/profile/edit', [AdminProfileController::class, 'AdminProfileEdit'])->name('admin.profile.edit');

Route::post('/admin/profile/store/{id}', [AdminProfileController::class, 'AdminProfileStore'])->name('admin.profile.store');

Route::get('/admin/change/password', [AdminProfileController::class, 'AdminChangePassword'])->name('admin.change.password');

Route::post('/update/change/password', [AdminProfileController::class, 'AdminUpdateChangePassword'])->name('update.change.password');


//Admin all Owner
Route::get('/owner', [AdminOwnerController::class, 'index'])->name('admin.owner');
Route::get('/owner/edit/{id}', [AdminOwnerController::class, 'edit'])->name('admin.owner.edit');
Route::get('/owner/create', [AdminOwnerController::class, 'create'])->name('admin.owner.create');
Route::post('/owner/update/{id}', [AdminOwnerController::class, 'update'])->name('admin.owner.update');
Route::post('/owner/store/', [AdminOwnerController::class, 'store'])->name('admin.owner.store');
Route::get('/owner/delete/{id}', [AdminOwnerController::class, 'destroy'])->name('admin.owner.delete');
// confirm owner
Route::get('/owner/confirm/{id}', [AdminOwnerController::class, 'confirmOwner'])->name('admin.owner.confirm');

//ALL PAYOWNER
Route::get('payowner/index', [PayOwnerController::class, 'index'])->name('admin.payowner.index');
//Tambah payowner
Route::get('payowner/create/{id}', [PayOwnerController::class, 'create'])->name('admin.payowner.create');
//proses simpan payowner
Route::post('payowner/store', [PayOwnerController::class, 'store'])->name('admin.payowner.store');
//update payowner
Route::post('payowner/confirm/{id}', [PayOwnerController::class, 'update'])->name('admin.payowner.update');
Route::get('payowner/edit/{id}', [PayOwnerController::class, 'edit'])->name('admin.payowner.edit');

Route::middleware(['auth:sanctum,web', 'verified'])->get('/dashboard', function () {
    $id = Auth::user()->id;
    $user = User::find($id);
    return view('dashboard', compact('user'));
})->name('home');


Route::get('/', [IndexController::class, 'index']);
Route::get('/user/logout', [IndexController::class, 'UserLogout'])->name('user.logout');
Route::get('/user/profile', [IndexController::class, 'UserProfile'])->name('user.profile');
Route::post('/user/profile/store', [IndexController::class, 'UserProfileStore'])->name('user.profile.store');
Route::get('/user/change/password', [IndexController::class, 'UserChangePassword'])->name('change.password');
Route::post('/user/update/password', [IndexController::class, 'UserPasswordUpdate'])->name('update.password');



// All User Login
Route::middleware(['auth:sanctum', 'web'])
    ->group(function () {

        //All UserOwner
        Route::get('myowner', [OwnerUserController::class, 'index'])
            ->name('user.owners');
        //create
        Route::get('myowner/create/', [OwnerUserController::class, 'create'])->name('user.owner.create');
        //store
        Route::post('myowner/store', [OwnerUserController::class, 'store'])->name('user.owner.store');
        //confirm owner
        Route::get('myonwer/confirm/{id}', [OwnerUserController::class, 'confirm'])->name('user.owner.confirm');
        //Get activate
        Route::get('myonwer/getActivate/{id}', [OwnerUserController::class, 'getActivate'])->name('user.owner.activate');
        Route::get('myowner/payment/{id}', [OwnerUserController::class, 'payment'])->name('user.owner.payment');
        //edit Userowner
        Route::get('myowner/edit/{id}', [OwnerUserController::class, 'edit'])->name('user.editowner');
        //update UserOwner
        Route::post('myowner/update/{id}', [OwnerUserController::class, 'update'])->name('user.updateowner');
        //delete UserOwner
        Route::get('myowner/delete/{id}', [OwnerUserController::class, 'destroy'])->name('user.deleteowner');
    });

//Activity User tanpa Login
//lihat Detail usaha
Route::get('usaha/detail/{id}', [OwnerUserController::class, 'detail'])->name('usaha.detail');

//product detail
Route::get('product/detail/{id}', [ProductController::class, 'detail'])->name('product.detail');
