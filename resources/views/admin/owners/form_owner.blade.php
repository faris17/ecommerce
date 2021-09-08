@extends('admin.admin_master')
@section('admin')
    <div class="container-full">
        <!-- form started -->
        <section class="content">
            <div class="box">
                <!-- FORM START -->
                <div class="row mb-15">
                    <div class="col-md-6">

                        <form class='form-group' method="post" action="{{ route('admin.owner.store') }}"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="box-body">

                                <h4 class="box-title text-info"><i class="ti-save mr-15"></i> Tambah Owner</h4>
                                <hr class="my-15">
                                <div class="form-group">
                                    <label>Nama Email</label>
                                    <input type="text" id="email" required class="form-control" placeholder="Email User"
                                        name="email">
                                </div>
                                <div class="form-group">
                                    <label>Nama Usaha</label>
                                    <input type="text" id="namausaha" required class="form-control" placeholder="Nama Usaha"
                                        name="namausaha" value="{{ isset($edit) ? $edit->namausaha : '' }}">
                                </div>
                                <div class="form-group">
                                    <label>No HP</label>
                                    <input type="text" id="nohpusaha" required class="form-control"
                                        placeholder="No HP Untuk Business" name="nohpusaha"
                                        value="{{ isset($edit) ? $edit->nohpusaha : '' }}">
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Type Owner</label>
                                            <select class="form-control" name="typeowner_id">
                                                @foreach ($typeowners as $typeowner)
                                                    <option value='{{ $typeowner->id }}'>{{ $typeowner->nametypeowner }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control" name="status">
                                                <option value='waiting'>Waiting</option>
                                                <option value='enable'>Enable</option>
                                                <option value='disable'>Disable</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Keterangan</label>
                                    <textarea rows="5" class="form-control" placeholder="Keterangan" name="deskripsiowner"
                                        required>{{ isset($editcategory) ? $editcategory->keterangan : '' }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Cover Image/Brosur</label><br>
                                    <input type='file' name='coverimage' id="image" />
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <a href="{{ route('admin.owner') }}">
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

                    <div class='col-md-6'>
                        <hr>
                        <span class='text-white'>Your Image Cover Display Here</span>
                        <br>
                        <img id="showImage" style="height: 50%; width:80%"
                            src="{{ !empty($editData->profile_photo_path) ? url('upload/admin_images/' . $editData->profile_photo_path) : url('upload/no_image.jpg') }}"
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
