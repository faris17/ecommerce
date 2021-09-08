<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ProductController extends Controller
{
    public function index()
    {
    }

    public function detail($id)
    {

        $id = Crypt::decrypt($id);

        $detailproduct = Product::with(['images'])->findOrFail($id);
        $ownerproduct = Product::with(['owner'])->findOrFail($id);
        $products = Product::with(['images'])->where('owner_id', '=', $detailproduct->owner_id)->limit(10)->get();

        return view('frontend.products.detail_product', compact(
            'detailproduct',
            'products',
            'ownerproduct'
        ));
        // return $detailproduct;
    }
}
