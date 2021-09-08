<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Controller User&Auth
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\BankController;
use App\Http\Controllers\api\CarController;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\API\MidtransController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\ProductController;

//OwnerController
use App\Http\Controllers\api\OwnerController;
use App\Http\Controllers\api\PayOwnerController;
use App\Http\Controllers\api\TypeOwnerContrller;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

//lihat category
Route::get('allcategory', [CategoryController::class, 'index']);
//lihat type-type Owner
Route::get('typeowner', [TypeOwnerContrller::class, 'index']);

//lihat Owner berdasarkan UserIdnya
Route::get('ownerbyuser/{id}', [OwnerController::class, 'show']);
//Get Data Mobil
Route::get('car', [CarController::class, 'index']);

//Get Data Produk
Route::post('allproduct', [ProductController::class, 'index']);

//Get Data produk by Category
Route::get('findproductcateg/{id}', [CategoryController::class, 'findproductByCateg']);

//Get Midtrans
Route::post('midtrans/callback', [MidtransController::class, 'callback']);

Route::group(['prefix' => 'admin', 'middleware' => ['admin:admin']], function () {
    Route::get('/login', [AdminController::class, 'loginForm']);
    Route::post('/login', [AdminController::class, 'store'])->name('admin.login');

    //For User
    Route::get('users', [UserController::class, 'index']);
    Route::post('login', [AuthController::class, 'login']);

    //change level
    Route::post("changelevel", [UserController::class, 'changelevel']);

    //delete akun
    Route::get('destroy/{id}', [UserController::class, 'destroy']);

    //Add Category
    Route::post('add-category', [CategoryController::class, 'store']);
    //Edit category
    Route::get('edit-category/{id}', [CategoryController::class, 'show']);
    //Update Category
    Route::post('update-category/{id}', [CategoryController::class, 'update']);
    //delete Category
    Route::get('deletecategory/{id}', [CategoryController::class, 'destroy']);

    //TypeOwner
    Route::post('add-typeowner', [TypeOwnerContrller::class, 'store']);
    //edit type Owner
    Route::get('edit-typeowner/{id}', [TypeOwnerContrller::class, 'show']);
    //update type owner
    Route::post('update-typeowner/{id}', [TypeOwnerContrller::class, 'update']);
    Route::get('delete-typeowner/{id}', [TypeOwnerContrller::class, 'destroy']);

    //BANK
    Route::post('add-bank', [BankController::class, 'store']);
    Route::get('edit-bank/{id}', [BankController::class, 'show']);
    Route::post('update-bank', [BankController::class, 'update']);
    Route::get('delete-bank/{id}', [BankController::class, 'destroy']);

    //PayOwner
    Route::get('payowner', [PayOwnerController::class, 'index']);
    Route::post('update-payowner/{id}', [PayOwnerController::class, 'update']);
});
Route::middleware('auth:sanctum')->group(function () {
    //Update User
    Route::post('updateUser/{id}', [UserController::class, 'update']);

    //Update Password
    Route::post('change-password', [UserController::class, 'changePassword']);
    //upload foto profile
    Route::post('uploadprofile', [UserController::class, 'uploadPhoto']);

    //Link User see owner
    Route::get('owner', [OwnerController::class, 'index']);

    //Logout
    Route::get('logout', [AuthController::class, 'logout']);

    //BANK
    Route::get('bank', [BankController::class, 'index']);
    //add rek
    Route::post('adduserbank', [BankController::class, 'addUserBank']);

    //get UserBank
    Route::get('getrekuser/{id}', [BankController::class, 'getRekUser']);
    //update rekening
    Route::post('updaterek/{id}', [BankController::class, 'updaterek']);
    //delete rekening
    Route::get('deleterek/{id}', [BankController::class, 'deleteRek']);

    //User make Owner
    Route::post('owner', [OwnerController::class, 'store']);
    //Owner
    Route::post('allowner', [OwnerController::class, 'index']);
    //Update Owner
    Route::post('update-owner/{id}', [OwnerController::class, 'update']);

    //Car
    Route::post('car', [CarController::class, 'store']);
    //delete car
    Route::get('delete-car/{id}', [CarController::class, 'destroy']);
    //update car
    Route::post('update-car/{id}', [CarController::class, 'update']);

    //Product
    Route::post('product', [ProductController::class, 'store']);
    //delete product
    Route::get('delete-product/{id}', [ProductController::class, 'destroy']);
    //Update Product
    Route::post('update-product/{id}', [ProductController::class, 'update']);
});

// Route::prefix('admin')
//     ->middleware(['auth:sanctum', 'admin'])
//     ->group(function () {


//     });
