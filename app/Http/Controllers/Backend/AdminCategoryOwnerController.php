<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Typeowner;

class AdminCategoryOwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pagination = 20;
        $categ =  Typeowner::orderByDesc('id', 'desc')->paginate($pagination);
        return view('admin.categoryowner.listcategoryowner', compact('categ'));
    }


    public function create()
    {
        return view('admin.categoryowner.form_category_owner');
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

        $post = Typeowner::create($input);

        if ($post) {
            $notification = array(
                'message' => 'Added Typeowner Successfully',
                'alert-type' => 'success'
            );
            //redirect dengan pesan sukses
            return redirect()->route('admin.categoryowner')->with($notification);
        } else {
            $notification = array(
                'message' => 'Added Typeowner failed',
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
        $categ =  Typeowner::orderByDesc('id', 'desc')->paginate($pagination);
        $edit = Typeowner::findOrFail($id);
        return view('admin.categoryowner.form_category_owner', [
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

        $update = Typeowner::findOrFail($id)->update($input);

        if ($update) {
            $notification = array(
                'message' => 'Update Typeowner Successfully',
                'alert-type' => 'success'
            );
            //redirect dengan pesan sukses
            return redirect()->route('admin.categoryowner')->with($notification);
        } else {
            $notification = array(
                'message' => 'Update Typeowner failed',
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
        $category = Typeowner::findOrFail($id);
        $category->delete();
        $notification = array(
            'message' => 'Typeowner Deleted Successfully',
            'alert-type' => 'info'
        );
        //redirect dengan pesan sukses
        return redirect()->back()->with($notification);
    }
}
