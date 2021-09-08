<?php

namespace App\Http\Controllers\api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Owner;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $id = $request->input('id');
            $limit = $request->input('limit', 15);
            $name = $request->input('name');

            $price_from = $request->input('price_from');
            $price_to = $request->input('price_to');

            if ($id) {
                $product = Product::findOrFail($id);

                if ($product)
                    return ResponseFormatter::success(
                        $product,
                        'Data produk berhasil diambil'
                    );
                else
                    return ResponseFormatter::error(
                        null,
                        'Data produk tidak ada',
                        404
                    );
            }

            $product = Product::query()->with(['categories']);

            if ($name)
                $product->where('name', 'like', '%' . $name . '%');

            if ($price_from)
                $product->where('hargasatuan', '>=', $price_from);

            if ($price_to)
                $product->where('hargasatuan', '<=', $price_to);

            return ResponseFormatter::success(
                $product->orderBy('created_at', 'desc')->paginate($limit),
                'Data list produk berhasil diambil'
            );
        } catch (Exception $error) {
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
            'namaproduk' => 'required|min:3',
            'hargasatuan' => 'required',
        ]);

        $produk = Product::create(
            [
                'namaproduk' => $request->namaproduk,
                'hargasatuan' => $request->hargasatuan,
                'diskon' => $request->diskon,
                'satuan' => $request->satuan,
                'stock' => $request->stock,
                'ukuran' => $request->ukuran,
                'pilihanwarna' => $request->pilihanwarna,
                'deskripsi' => $request->deskripsi,
                'ongkir' => $request->ongkir,
                'owner_id'  => $request->owner_id,
                'jenispembayaran' => $request->jenispembayaran
            ]
        );

        //insert category
        $produk->categories()->attach([1, 2]);

        return ResponseFormatter::success(
            $produk,
            'Data Produk berhasil dibuat'
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
        //edit category
        try {
            $produk = Product::findOrFail($id);
            return ResponseFormatter::success($produk, 'Berhasil');
        } catch (Exception $error) {
            return ResponseFormatter::error(
                [
                    'message' => 'Get Product Failed',
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
        $request->validate([
            'namaproduk' => 'required|min:3',
            'hargasatuan' => 'required',
        ]);

        $inputan = $request->input();
        $dataproduct = Product::findOrFail($id);

        $hasil = $dataproduct->update($inputan);

        //insert category
        $dataproduct->categories()->update([2, 3]);


        return ResponseFormatter::success(
            '',
            'Data Produk berhasil diperbaharui'
        );
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
            $product = Product::findOrFail($id);
            if (Auth::user()->level == 'admin') {
                $product->delete();
            } else {
                $data = Owner::findOrFail($product->owner_id)->where('users_id', Auth::user()->id)->count();
                if ($data == 1) {
                    $product->delete();
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


            return ResponseFormatter::success($product, 'Delete successfull');
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
