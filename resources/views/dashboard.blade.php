@extends('frontend.main_master')
@section('content')
    <div class="body-content">
        <div class="container">
            <div class="row">
                @include('frontend.profile.widget_linkprofile')

                <div class="col-md-2">

                </div>

                <div class="col-md-8">
                    <div class="card">
                        <h3 class='text-left'>
                            <span class='text-danger'>Hi....</span>
                            <strong>{{ Auth::user()->name }}</strong>
                            Welcome To diberlin app
                        </h3>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
