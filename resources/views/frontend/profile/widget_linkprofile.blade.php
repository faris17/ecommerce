<div class="col-md-2"><br>
    <img class="card-img-top" style="border-radius:50%"
        src="{{ !empty($user->profile_photo_path) ? url('upload/user_images/' . $user->profile_photo_path) : url('upload/no_image.jpg') }}"
        height="150px" width='150px' /> <br><br>

    <ul class="list-group list-group-flush">
        <a href="{{ route('home') }}" class="btn btn-primary btn-sm btn-block">Home</a>
        <a href="{{ route('user.profile') }}" class="btn btn-primary btn-sm btn-block">Profile Update</a>
        <a href="{{ route('change.password') }}" class="btn btn-primary btn-sm btn-block">Change Password</a>
        <a href="{{ route('user.logout') }}" class="btn btn-danger btn-sm btn-block">Logout</a>
    </ul>
</div>
