<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use Illuminate\Http\Request;

class AdminBankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pagination = 20;
        $bank =  Bank::when($request->keyword, function ($query) use ($request) {
            $query
                ->where('namabank', 'like', "%{$request->keyword}%");
        })->orderBy('created_at', 'desc')->paginate($pagination);

        $bank->appends($request->only('keyword'));

        return view('admin.banks.listbanks', [
            'bank' => $bank,
        ])->with('i', ($request->input('page', 1) - 1) * $pagination);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


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
            'namabank' => 'required',
        ]);
        $input = $request->all();

        $post = Bank::create($input);

        if ($post) {
            $notification = array(
                'message' => 'Added Bank Successfully',
                'alert-type' => 'success'
            );
            //redirect dengan pesan sukses
            return redirect()->back()->with($notification);
        } else {
            $notification = array(
                'message' => 'Added Bank failed',
                'alert-type' => 'error'
            );
            //redirect dengan pesan error
            return redirect()->back()->with($notification);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $pagination = 20;
        $bank =  Bank::orderByDesc('id', 'desc')->paginate($pagination);
        $edit = Bank::findOrFail($id);
        return view('admin.banks.listbanks', [
            'edit' => $edit,
            'bank' => $bank
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

        $update = Bank::findOrFail($id)->update($input);

        if ($update) {
            $notification = array(
                'message' => 'Update Bank Successfully',
                'alert-type' => 'success'
            );
            //redirect dengan pesan sukses
            return redirect()->back()->with($notification);
        } else {
            $notification = array(
                'message' => 'Update Bank failed',
                'alert-type' => 'error'
            );
            //redirect dengan pesan error
            return redirect()->back()->with($notification);
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
        $bank = Bank::findOrFail($id);
        $bank->delete();
        $notification = array(
            'message' => 'Bank Deleted Successfully',
            'alert-type' => 'info'
        );
        //redirect dengan pesan sukses
        return redirect()->route('admin.bank')->with($notification);
    }
}
