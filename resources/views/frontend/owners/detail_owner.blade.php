@extends('frontend.main_master')
@section('content')
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li class='active'>Detail usaha</li>
                </ul>
            </div><!-- /.breadcrumb-inner -->
        </div><!-- /.container -->
    </div><!-- /.breadcrumb -->
    <div class="body-content">
        <div class="container">
            <div class="row" style="background-color: white; padding:20px">
                <div style="display:flex;justify-content: space-between">
                    <span style="margin-left:25px;font-size:30px; display:inline">{{ $owner->namausaha }}</span>
                </div>
                <hr>

                <div class="col-md-12">
                    <div class="col-md-4">
                        <img class="card-img-top img-thumbnail" src="{{ asset('upload/owner/' . $owner->coverimage) }}"
                            alt="Card image cap" style="height:250px; width:100%">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title font-weight-400"><strong>{{ $owner->namausaha }}</strong></h5>

                            <p class="card-text">{!! $owner->deskripsiowner !!}</p>

                            <hr>
                        </div>
                    </div>
                    <div class="col-sm-7">
                        @php
                            //get message
                            $message = 'Halo kak. Mau tanya-tanya nih kak?';

                        @endphp
                        <a title="Belum Aktif"
                            href="https://api.whatsapp.com/send?phone=+{{ $owner->nohpusaha }}&text={{ $message }}"
                            class="btn btn-success"><i class="fa fa-whatsapp inner-right-vs"></i>
                            Whatsapp</a>
                    </div>
                    <hr>
                </div>
                <div class="col-md-12">
                    <div style="font-style:bold;margin:30px 0px 0px 30px; font-size:20px;">Tersedia Product</div>
                    @include('frontend.products.list_product')
                </div>
            </div>

        </div>
    </div>

@endsection
