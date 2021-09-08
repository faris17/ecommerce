<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Contracts\Auth\StatefulGuard;

class AdminCategoryController extends Controller
{

    public function __construct(StatefulGuard $guard)
    {
        $this->guard = $guard;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pagination = 20;
        $categ =  Category::orderByDesc('id', 'desc')->paginate($pagination);
        return view('admin.category.listcategory', compact('categ'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $post = Category::create($input);

        if ($post) {
            $notification = array(
                'message' => 'Added Category Successfully',
                'alert-type' => 'success'
            );
            //redirect dengan pesan sukses
            return redirect()->route('admin.category')->with($notification);
        } else {
            $notification = array(
                'message' => 'Added Category failed',
                'alert-type' => 'error'
            );
            //redirect dengan pesan error
            return redirect()->back()->with($notification);
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

    public function edit($id)
    {
        $pagination = 20;
        $categ =  Category::orderByDesc('id', 'desc')->paginate($pagination);
        $edit = Category::findOrFail($id);
        return view('admin.category.listcategory', [
            'editcategory' => $edit,
            'categ' => $categ
        ]);
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

        $input = $request->all();

        $update = Category::findOrFail($id)->update($input);

        if ($update) {
            $notification = array(
                'message' => 'Update Category Successfully',
                'alert-type' => 'success'
            );
            //redirect dengan pesan sukses
            return redirect()->route('admin.category')->with($notification);
        } else {
            $notification = array(
                'message' => 'Update Category failed',
                'alert-type' => 'error'
            );
            //redirect dengan pesan error
            return redirect()->route('admin.category')->with($notification);
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
        $category = Category::findOrFail($id);
        $category->delete();
        $notification = array(
            'message' => 'Category Deleted Successfully',
            'alert-type' => 'info'
        );
        //redirect dengan pesan sukses
        return redirect()->route('admin.category')->with($notification);
    }
}
