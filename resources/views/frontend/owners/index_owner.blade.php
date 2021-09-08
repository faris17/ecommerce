@extends('frontend.main_master')
@section('content')
    <div class="body-content">
        <div class="container">
            <div class="row" style="background-color: white; padding:20px">
                <div style="display:flex;justify-content: space-between">
                    <span style="margin-left:25px;font-size:30px; display:inline">Usaha Anda</span>
                    <a href="{{ route('user.owner.create') }}"><button class="btn btn-info"><i class="fa fa-plus"></i>
                            Tambah</button></a>
                </div>
                <hr>
                @foreach ($myowners as $row)
                    <div class="col-md-12">
                        <div class="col-md-4">
                            <img class="card-img-top img-thumbnail" src="{{ asset('upload/owner/' . $row->coverimage) }}"
                                alt="Card image cap" style="height:250px; width:100%">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title font-weight-400"><strong>{{ $row->namausaha }}</strong></h5>
                                <small style="color:gray">
                                    @php
                                        $tanggal = \Carbon\Carbon::parse($row->created_at)->format('d, M Y');

                                        echo 'Join at: ' . $tanggal . ' / ';
                                        $join = \Carbon\Carbon::parse($row->created_at)->diffForHumans();
                                        echo $join;
                                    @endphp
                                </small>
                                <p class="card-text">{!! $row->deskripsiowner !!}</p>

                                <div style="display:flex;justify-content: space-between">
                                    <div>
                                        @if ($row->status == 'enabled')
                                            <a href="#" class="btn btn-primary">Lihat Produk</a>
                                        @else
                                            <p style="color:gray; font-size:14px">
                                                Usaha anda akan aktif, setelah melakukan pembayaran.<br>

                                            </p>
                                        @endif

                                    </div>
                                    <div>
                                        @php
                                            $parameter = Crypt::encrypt($row->id);
                                        @endphp
                                        @if ($row->status == 'enabled')
                                            <a href="{{ route('user.editowner', $parameter) }}"
                                                class="btn btn-warning">Edit</a>
                                            <a href="{{ route('user.deleteowner', $parameter) }}" id="delete"
                                                class="btn btn-danger">Delete</a>
                                        @else
                                            <a href="{{ route('user.owner.activate', $parameter) }}"
                                                class='btn btn-default'>
                                                Click to Activate
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                <hr>


                            </div>

                        </div>
                        <hr>
                    </div>
                @endforeach
            </div>

        </div>
    </div>

@endsection
