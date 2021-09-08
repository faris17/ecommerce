@extends('frontend.main_master')
@section('content')
    <div class="body-content">
        <div class="container">
            <div class='row' style="background-color: white; padding:20px">
                <div class="col-md-4">
                    <strong>Biaya Kategori Usaha</strong>
                    <table id="table" style="width:100%;">
                        <thead>
                            <th>No</th>
                            <th>Type Usaha</th>
                            <th>Biaya /Tahun</th>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($typeowners as $typeowner)
                                <tr style='border:solid 1px gray;' value="<?php echo "<strong>$typeowner->nametypeowner</strong><br>$typeowner->keterangan"; ?>">
                                    <td style='padding:2px; width:40px'>{{ $no++ }}.</td>
                                    <td style='padding:2px'>{{ $typeowner->nametypeowner }}</td>
                                    <td style='padding:2px'>@currency($typeowner->harga)</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <p style="margin-top:20px" id="displayKeterangan"> </p>
                </div>
                <div class="col-md-5">
                    <h4>Isi Data Usaha</h4>
                    <form method="POST" action="{{ route('user.owner.store') }}" class='form-group'
                        enctype="multipart/form-data">
                        @csrf

                        <div class="box-body">

                            <hr class="my-15">

                            <div class="form-group">
                                <label>Nama Usaha</label>
                                <input type="text" id="namausaha" required class="form-control" placeholder="Nama Usaha"
                                    name="namausaha">
                            </div>
                            <div class="form-group">
                                <label>No HP</label>
                                <input type="text" id="nohpusaha" required class="form-control" placeholder="No HP"
                                    name="nohpusaha" value="+62">
                            </div>

                            <div class="form-group">
                                <label>Type Usaha</label>
                                <select class="form-control" name="typeowner_id">
                                    @foreach ($typeowners as $typeowner)
                                        <option value='{{ $typeowner->id }}'>{{ $typeowner->nametypeowner }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Keterangan</label>
                                <textarea rows="5" class="ckeditor form-control" placeholder="Keterangan"
                                    name="deskripsiowner" required></textarea>
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
                                <i class="ti-save-alt"></i> Save
                            </button>

                        </div>
                    </form>
                </div>
                <div class="col-md-3">

                    <hr>
                    <span style="color:rgb(150, 146, 146)">Your Image Cover Display Here</span>
                    <br>
                    <img id="showImage" style="height: 50%; width:60%"
                        src="{{ !empty($data->coverimage) ? url('upload/owner/' . $data->coverimage) : url('upload/no_image.jpg') }}"
                        alt="User Avatar" style="height: 100px; width:100px">
                    <div style="margin-top:20px"><span style="color:rgb(150, 146, 146)">Bila membutuhkan jasa design untuk
                            cover usaha anda, dapat menghubungi kami, harga terjangkau.</span></div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#table").delegate("tr", "click", function() {
                $('tr').css('background-color', 'white');
                var keterangan = $(this).attr('value');
                $('#displayKeterangan').html(keterangan);
                $(this).css('background-color', 'yellow');
            });
            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);

            });
        })
    </script>
    <style>
        thead {
            border: 2px solid rgb(23, 22, 97);
        }

        th {
            padding: 10px;
            border: 2px solid rgb(23, 22, 97);
        }

        tr:hover {
            background-color: rgb(190, 187, 187);
            cursor: pointer;
        }

    </style>
@endsection
