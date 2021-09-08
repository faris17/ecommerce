<?php

namespace App\Http\Controllers\api;

use App\Models\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use Exception;


class CategoryController extends Controller
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
            $categ =  Category::paginate($pagination);
            return ResponseFormatter::success(
                $categ,
                'Data list category berhasil diambil'
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
            'namacategory' => 'required|unique:categories,namacategory|min:3',
        ]);

        $categ = Category::create(['namacategory' => $request->namacategory]);

        return ResponseFormatter::success(
            $categ,
            'Data Category berhasil dibuat'
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
            $categ = Category::findOrFail($id);
            return ResponseFormatter::success($categ, 'Berhasil');
        } catch (Exception $error) {
            return ResponseFormatter::error(
                [
                    'message' => 'Get Category Failed',
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
                'namacategory' => 'required|unique:categories,namacategory|min:3',
            ]);
            $categ = Category::findOrFail($id);
            $categ->namacategory = $request->namacategory;
            $categ->update();

            return ResponseFormatter::success($categ, 'Berhasil Update');
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
            $categ = Category::findOrFail($id);
            $categ->delete();
            return ResponseFormatter::success($categ, 'Delete successfull');
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

    public function findproductByCateg($id)
    {
        try {

            $categ = Category::with(['products'])->where('id', $id)->get();
            return ResponseFormatter::success(
                $categ,
                'Data list produk berhasil diambil'
            );
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
