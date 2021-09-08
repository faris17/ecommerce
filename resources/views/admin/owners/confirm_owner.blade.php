@extends('admin.admin_master')
@section('admin')
    <div class="container-full">
        <!-- form started -->
        <section class="content">
            <div class="box">
                <!-- FORM START -->
                <div class="row mb-15">
                    <div class='col-md-6'>
                        <div class='box-body'>

                            <span class='text-white'>Detail Information</span>
                            <br>
                            <table class='table'>

                                <tr>
                                    <th>Nama Usaha:</th>
                                    <td> {{ $data->owner->namausaha }}</td>
                                </tr>
                                <tr>
                                    <th>Type:</th>
                                    <td>{{ $data->typeowner->nametypeowner }}</td>
                                </tr>
                                <tr>
                                    <th>Deskripsi:</th>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>{{ $data->owner->status }}</td>
                                </tr>
                                <tr>
                                    <th>Cover:</th>
                                    <td>
                                        <img class="rounded-circle" style="width:100px; height:100px;margin-bottom:10px"
                                            src="{{ !empty($data->owner->coverimage) ? url('upload/owner/' . $data->owner->coverimage) : url('upload/no_image.jpg') }}"
                                            alt="User Avatar">
                                    </td>
                                </tr>

                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">

                        <form method="post" action="{{ route('admin.payowner.update', $data->id) }}" class='form-group'
                            enctype="multipart/form-data">
                            @csrf
                            <div class="box-body">
                                <h4 class="box-title text-info"><i class="ti-save mr-15"></i> Confirm Pembayaran</h4>
                                <hr class="my-15">
                                <div class="form-group">
                                    <label>Tanggal Bayar</label>
                                    <input type="date" id="tanggalbayar" required class="form-control" name="tanggalbayar">
                                </div>

                                <div class="form-group">
                                    <label>Status Pembayaran</label>
                                    <select class="form-control" name="status">
                                        <option value='waiting'>Waiting</option>
                                        <option value='SUCCESS'>SUCCESS</option>
                                        <option value='PENDING'>PENDING</option>
                                        <option value='EXPIRE'>EXPIRE</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Harga Bayar</label><br>
                                    <input type='text' class='form-control' name='harga' id="harga"
                                        value='{{ $data->harga }}' />
                                </div>
                                <div class="form-group">
                                    <label>Link Bayar</label>
                                    <?php if (isset($data->payment_url)) {
                                        echo '<a target="_blank" href="' . $data->payment_url . '"><button type="button" class="btn btn-warning btn-sm">Lihat</button></a>';
                                    } ?>
                                </div>
                                <div class="form-group">
                                    <label>Nota Bayar</label><br>
                                    <input type='file' name='notabayar' id="image" />
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <a href="{{ route('admin.categoryowner') }}">
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
