@extends('admin.admin_master')
@section('admin')
    <div class="container-full">
        <!-- form started -->
        <section class="content">
            <div class="box">
                <!-- FORM START -->
                <div class="row mb-15">
                    <?php if(is_array($data)) { ?>
                    <div class="col-md-6">
                        <form method="post" action="{{ route('admin.owner.update', $data[0]['owner_id']) }}"
                            class='form-group' enctype="multipart/form-data">
                            @csrf

                            <div class="box-body">

                                <h4 class="box-title text-info"><i class="ti-save mr-15"></i> Edit Owner</h4>
                                <hr class="my-15">
                                <div class="form-group">
                                    <input style="color:white" type="text" id="owner_id" required class="form-control"
                                        placeholder="Email User" name="owner_id" value="{{ $data[0]['owner_id'] }}">
                                </div>
                                <div class="form-group">
                                    <label>Nama Usaha</label>
                                    <input style="color:white" type="text" id="namausaha" required class="form-control"
                                        placeholder="Nama Usaha" name="namausaha"
                                        value="{{ $data[0]['owner']['namausaha'] }}">
                                </div>
                                <div class="form-group">
                                    <label>No HP</label>
                                    <input type="text" id="nohpusaha" required class="form-control"
                                        placeholder="No HP Untuk Business" name="nohpusaha"
                                        value="{{ $data[0]['owner']['nohpusaha'] }}">
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Type Owner</label>
                                            <select style="color:white" class="form-control" name="typeowner_id">
                                                @foreach ($typeowners as $typeowner)
                                                    <option value='{{ $typeowner->id }}'
                                                        {{ $data[0]['typeowner_id'] == $typeowner->id ? 'selected' : '' }}>
                                                        {{ $typeowner->nametypeowner }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select style="color:white" class="form-control" name="status">
                                                <option value='waiting'
                                                    {{ $data[0]['owner']['status'] == 'waiting' ? 'selected' : '' }}>
                                                    Waiting
                                                </option>
                                                <option value='enable'
                                                    {{ $data[0]['owner']['status'] == 'enable' ? 'selected' : '' }}>Enable
                                                </option>
                                                <option value='disable'
                                                    {{ $data[0]['owner']['status'] == 'disable' ? 'selected' : '' }}>
                                                    Disable
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Keterangan</label>
                                    <textarea style="color:white" rows="5" class="form-control" placeholder="Keterangan"
                                        name="deskripsiowner"
                                        required>{{ $data[0]['owner']['deskripsiowner'] }}</textarea>
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


                                <button type="submit" class="btn btn-rounded btn-primary btn-outline">
                                    <i class="ti-save-alt"></i> Update
                                </button>

                            </div>
                        </form>
                    </div>

                    <div class='col-md-6'>
                        <hr>
                        <span class='text-white'>Your Image Cover Display Here</span>
                        <br>
                        <img id="showImage" style="height: 50%; width:60%"
                            src="{{ !empty($data[0]['owner']['coverimage']) ? url('upload/owner/' . $data[0]['owner']['coverimage']) : url('upload/no_image.jpg') }}"
                            alt="User Avatar" style="height: 100px; width:100px">
                    </div>
                    <?php } else { ?>
                    <div class="col-md-12 text-center">
                        No Data Pay Owner
                    </div>
                    <?php } ?>

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
