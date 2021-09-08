@extends('admin.admin_master')
@section('admin')
    <div class="container-full">
        <!-- form started -->
        <section class="content">
            <div class="box">
                <!-- FORM START -->
                <div class="row mb-15">
                    <div class="col-md-6">
                        @if (isset($editcategory))
                            <form method="post" action="{{ route('admin.categoryowner.update', $editcategory->id) }}"
                                class='form-group'>

                            @else
                                <form class='form-group' method="post" action="{{ route('admin.categoryowner.store') }}">
                        @endif
                        @csrf

                        <div class="box-body">

                            <h4 class="box-title text-info"><i class="ti-save mr-15"></i> Tambah Type Category</h4>
                            <hr class="my-15">
                            <div class="form-group">
                                <label>Type Owner</label>
                                <input type="text" id="nametypeowner" required class="form-control"
                                    placeholder="Typeowner Name" name="nametypeowner"
                                    value="{{ isset($editcategory) ? $editcategory->nametypeowner : '' }}">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Harga</label>
                                        <input type="text" class="form-control" placeholder="Harga" name="harga" required
                                            value="{{ isset($editcategory) ? $editcategory->harga : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Budget</label>
                                        <input type="number" min='1'
                                            value="{{ isset($editcategory) ? $editcategory->perpanjang : '1' }}"
                                            class="form-control" name="perpanjang">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Keterangan</label>
                                <textarea rows="5" class="form-control" placeholder="Keterangan" name="keterangan"
                                    required>{{ isset($editcategory) ? $editcategory->keterangan : '' }}</textarea>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <a href="{{ route('admin.categoryowner') }}">
                                <button type="button" class="btn btn-rounded btn-warning btn-outline mr-1">
                                    <i class="ti-trash"></i> Cancel
                                </button>
                            </a>

                            @if (isset($editcategory))
                                <button type="submit" class="btn btn-rounded btn-info btn-outline">
                                    <i class="ti-save-alt"></i> Update
                                </button>

                            @else
                                <button type="submit" class="btn btn-rounded btn-primary btn-outline">
                                    <i class="ti-save-alt"></i> Save
                                </button>
                            @endif

                        </div>
                        </form>
                    </div>

                </div>
                <!-- FORM -->
            </div>
        </section>
    </div>
@endsection
