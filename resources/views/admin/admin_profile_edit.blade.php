@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <div class="container-full">
        <!-- form started -->
        <section class="content">

            <!-- Basic Forms -->
            <div class="box">
                <div class="box-header with-border">
                    <h4 class="box-title">Admin Profile Edit</h4>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col">
                            <form method="post" action="{{ route('admin.profile.store', $editData->id) }}"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="col-12">

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <h5>Admin Name <span class="text-danger">*</span></h5>
                                                    <div class="controls">
                                                        <input type="text" id="name" name="name"
                                                            value="{{ $editData->name }}" class="form-control" required=""
                                                            data-validation-required-message="This field is required">
                                                        <div class="help-block"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <h5>Email Name <span class="text-danger">*</span></h5>
                                                    <div class="controls">
                                                        <input type="email" id="email" name="email"
                                                            value="{{ $editData->email }}" class=" form-control"
                                                            required=""
                                                            data-validation-required-message="This field is required">
                                                        <div class="help-block"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <h5>File Input Field <span class="text-danger">*</span></h5>
                                                    <div class="controls">
                                                        <input type="file" name="profile_photo_path" class="form-control"
                                                            id="image">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <img id="showImage" class="rounded-circle"
                                                    src="{{ !empty($editData->profile_photo_path) ? url('upload/admin_images/' . $editData->profile_photo_path) : url('upload/no_image.jpg') }}"
                                                    alt="User Avatar" style="height: 100px; width:100px">
                                            </div>
                                        </div>




                                    </div>
                                </div>
                                <div class="text-xs-right">
                                    <button type="submit" class="btn btn-rounded btn-primary">Submit</button>
                                </div>
                            </form>

                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

        </section>
        <!--end form-->
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
