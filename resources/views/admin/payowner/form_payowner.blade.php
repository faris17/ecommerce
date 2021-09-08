@extends('admin.admin_master')
@section('admin')
    <div class="container-full">
        <!-- form started -->
        <section class="content">
            <div class="box">
                <!-- FORM START -->
                <div class="row mb-15">

                    <div class="col-md-6">
                        <form method="post" action="{{ route('admin.payowner.store') }}" class='form-group'
                            enctype="multipart/form-data">
                            @csrf

                            <div class="box-body">

                                <h4 class="box-title text-info"><i class="ti-save mr-15"></i> Tambah Transaksi PayOwner</h4>
                                <hr class="my-15">

                                <div class="form-group">
                                    <label>Nama Usaha</label>
                                    <h3>{{ $data->owner->namausaha }}</h3>
                                </div>
                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Tanggal Bayar</label>
                                            <input type="date" id="tanggalbayar" required class="form-control"
                                                name="tanggalbayar" value="{{ $data->tanggalbayar }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select style="color:white" class="form-control" name="status">
                                                <option value='waiting'
                                                    {{ $data->status == 'waiting' ? 'selected' : '' }}>
                                                    Waiting
                                                </option>
                                                <option value='SUCCESS'
                                                    {{ $data->status == 'SUCCESS' ? 'selected' : '' }}>SUCCESS
                                                </option>
                                                <option value='PENDING'
                                                    {{ $data->status == 'PENDING' ? 'selected' : '' }}>PENDING
                                                </option>
                                                <option value='EXPIRE' {{ $data->status == 'EXPIRE' ? 'selected' : '' }}>
                                                    EXPIRE
                                                </option>
                                                <option value='disable'
                                                    {{ $data->status == 'disable' ? 'selected' : '' }}>
                                                    Disable
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Harga Bayar</label><br>
                                    <input type='text' class='form-control' name='harga' id="harga"
                                        value='{{ $data->harga }}' />
                                </div>

                                <div class="form-group">
                                    <label>Nota Bayar</label><br>
                                    <input type='file' name='notabayar' id="image" />
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <a href="{{ route('admin.payowner.index') }}">
                                    <button type="button" class="btn btn-rounded btn-warning btn-outline mr-1">
                                        <i class="ti-trash"></i> Cancel
                                    </button>
                                </a>

                                <input type="hidden" name="owner_id" value="{{ $data->owner_id }}" />
                                <input type="hidden" name="typeowner_id" value="{{ $data->typeowner_id }}" />

                                <button type="submit" class="btn btn-rounded btn-primary btn-outline">
                                    <i class="ti-save-alt"></i> Save
                                </button>

                            </div>
                        </form>
                    </div>

                    <div class='col-md-6'>
                        <hr>
                        <span class='text-white'>Your Image Cover Display Here</span>
                        <br>
                        <img id="showImage" style="height: 50%; width:80%"
                            src="{{ !empty($data->notabayar) ? url('upload/notabayar/' . $data->notabayar) : url('upload/no_image.jpg') }}"
                            alt="User Avatar" style="height: 100px; width:100px">
                    </div>


                </div>
                <!-- FORM -->
            </div>
        </section>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);

            })
        })
    </script>
@endsection
