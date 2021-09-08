@extends('frontend.main_master')
@section('content')
    <div class="body-content">
        <div class="container">
            <div class="row">
                @include('frontend.profile.widget_linkprofile')
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            {{ implode('', $errors->all(':message')) }}
                        </div>

                    @endif
                    <div class="card">
                        <h3 class='text-center'>
                            <span class='text-danger'>Hi....</span>
                            <strong>{{ Auth::user()->name }}</strong>
                            Change Your Password
                        </h3>
                        <div class="card-body">
                            <form method="post" action="{{ route('update.password') }}" class="register-form outer-top-xs"
                                style="margin-bottom:20px">
                                @csrf

                                <div class="form-group">
                                    <label class="info-title" for="name">Current Password </label>
                                    <input type="password" name="oldpassword"
                                        class="form-control unicase-form-control text-input" id="oldpassword">
                                </div>
                                <div class="form-group">
                                    <label class="info-title" for="email">New Password </label>
                                    <input type="password" name="password"
                                        class="form-control unicase-form-control text-input" id="password">
                                </div>
                                <div class="form-group">
                                    <label class="info-title" for="nohp">Confirmation Password</label>
                                    <input type="password" class="form-control unicase-form-control text-input"
                                        id="password_confirmation" name="password_confirmation">

                                </div>

                                <button type="submit" class="btn-upper btn btn-info checkout-page-button">Change
                                    Password</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
