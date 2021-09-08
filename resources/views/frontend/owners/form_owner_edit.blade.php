@extends('frontend.main_master')
@section('content')
    <div class="body-content">
        <div class="container">
            <div class="row" style="background-color: white; padding:20px">
                <h3 style="margin-left:25px">Edit {{ $data->namausaha }}</h3>

                <hr>
                <div class="row mb-15">
                    <?php if($data != null) { ?>
                    <div class="col-md-6">
                        <form method="POST" action="{{ route('user.updateowner', $data->id) }}" class='form-group'
                            enctype="multipart/form-data">
                            @csrf

                            <div class="box-body">

                                <hr class="my-15">

                                <div class="form-group">
                                    <label>Nama Usaha</label>
                                    <input type="text" id="namausaha" required class="form-control" placeholder="Nama Usaha"
                                        name="namausaha" value="{{ $data->namausaha }}">
                                </div>
                                <div class="form-group">
                                    <label>No HP</label>
                                    <input type="text" id="nohpusaha" required class="form-control"
                                        placeholder="No HP For Business" name="nohpusaha" value="{{ $data->nohpusaha }}">
                                </div>

                                <div class="form-group">
                                    <label>Keterangan</label>
                                    <textarea rows="5" class="ckeditor form-control" placeholder="Keterangan"
                                        name="deskripsiowner" required>{{ $data->deskripsiowner }}</textarea>
                                </div>
                                <div class="form-group">

                                    <label>Cover Image/Brosur</label><br>
                                    <input type='file' name='coverimage' id="image" />


                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <a href="{{ route('user.owners') }}">
                                    <button type="button" class="btn btn-rounded btn-warning btn-outline mr-1">
                                        <i class="ti-trash"></i> Cancel
                                    </button>
                                </a>


                                <button type="submit" class="btn btn-rounded btn-primary btn-outline">
                                    <i class="ti-save-alt"></i> Update
                                </button>

                            </div>
                        </form>
                    </div>

                    <div class='col-md-6'>
                        <hr>
                        <span style="color:rgb(150, 146, 146)">Your Image Cover Display Here</span>
                        <br>
                        <img id="showImage" style="height: 50%; width:60%"
                            src="{{ !empty($data->coverimage) ? url('upload/owner/' . $data->coverimage) : url('upload/no_image.jpg') }}"
                            alt="User Avatar" style="height: 100px; width:100px">
                        <div style="margin-top:20px"><span style="color:rgb(150, 146, 146)">Bila membutuhkan jasa design
                                untuk usaha
                                anda, dapat
                                menghubungi kami, <br>harga terjangkau.</span></div>
                    </div>
                    <?php } else { ?>
                    <div class="col-md-12 text-center">
                        No Data Owner
                    </div>
                    <?php } ?>

                </div>
            </div>

        </div>
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
