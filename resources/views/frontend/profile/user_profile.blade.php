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
                        <h3 class='text-center'>
                            <span class='text-danger'>Hi....</span>
                            <strong>{{ Auth::user()->name }}</strong>
                            update Your Profile
                        </h3>
                        <div class="card-body">
                            <form method="post" action="{{ route('user.profile.store') }}" enctype="multipart/form-data"
                                class="register-form outer-top-xs" style="margin-bottom:20px">
                                @csrf

                                <div class="form-group">
                                    <label class="info-title" for="name">Name </label>
                                    <input type="text" name="name" class="form-control unicase-form-control text-input"
                                        id="name" value="{{ $user->name }}">
                                </div>
                                <div class="form-group">
                                    <label class="info-title" for="email">Email Address </label>
                                    <input type="text" name="email" class="form-control unicase-form-control text-input"
                                        id="email" value="{{ $user->email }}">
                                </div>
                                <div class="form-group">
                                    <label class="info-title" for="nohp">Phone Number</label>
                                    <input type="text" class="form-control unicase-form-control text-input" id="nohp"
                                        name="nohp" value="{{ $user->nohp }}">

                                </div>
                                <div class="form-group">
                                    <label class="info-title" for="address">Address </label>
                                    <input type="text" name="alamat" class="form-control unicase-form-control text-input"
                                        id="alamat" value="{{ $user->alamat }}">
                                </div>
                                <div class="form-group">
                                    <h5>File Input Field <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                        <input type="file" name="profile_photo_path" class="form-control" id="image">
                                    </div>
                                </div>
                                <button type="submit" class="btn-upper btn btn-primary checkout-page-button">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
