@extends('layout.master')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="row">
            <div class="col-md-12">

                <div class="card mb-4">
                    <h5 class="card-header">Profile Details</h5>
                    <!-- Account -->
                    <div class="card-body">
                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                            @if (auth()->user()->avatar)
                                <img src="{{ URL::asset('assets/uploads/admins/profiles/' . auth()->user()->avatar) }}"
                                    alt="user-avatar" class="d-block rounded border" height="100" width="100"
                                    id="uploadedAvatar" />
                            @else
                                <img src="{{ URL::asset('assets/img/avatars/1.png') }}" alt="user-avatar"
                                    class="d-block rounded border" height="100" width="100" id="uploadedAvatar" />
                            @endif

                        </div>
                    </div>
                    <hr class="my-0" />
                    <div class="card-body">
                        <form id="" method="POST" action="{{ route('admin.dashboard.profile.post') }}"
                            enctype="multipart/form-data">
                            <input type="hidden" name="id" value="{{ auth()->user()->id }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="firstName" class="form-label">Avatar</label>
                                    <input type="file" id="upload" name="avatar"
                                        class="account-file-input form-control" accept="image/png, image/jpeg" />
                                </div>


                                <div class="mb-3 col-md-6">
                                    <label for="firstName" class="form-label">First Name</label>
                                    <input class="form-control" type="text" id="firstname" name="firstname"
                                        value="{{ auth()->user()->firstname }}" autofocus />
                                    <span class="text-danger danger">
                                        @error('firstname')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="lastName" class="form-label">Last Name</label>
                                    <input class="form-control" type="text" name="lastname" id="lastName"
                                        value="{{ auth()->user()->lastname }}" />
                                    <span class="text-danger danger">
                                        @error('lastname')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="email" class="form-label">E-mail</label>
                                    <input class="form-control" type="text" id="email" name="email"
                                        value="{{ auth()->user()->email }}" placeholder="john.doe@example.com" readonly />
                                    <span class="text-danger danger">
                                        @error('email')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="username" class="form-label">Username</label>
                                    <input class="form-control" type="text" id="username" name="username"
                                        value="{{ auth()->user()->username }}" placeholder="john.doe@example.com"
                                        readonly />
                                    <span class="text-danger danger">
                                        @error('username')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="contact_no">Phone Number</label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" id="contact_no" name="contact_no" class="form-control"
                                            placeholder="91210981523" value="{{ auth()->user()->contact_no }}" />
                                        <span class="text-danger danger">
                                            @error('contact_no')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text" class="form-control" id="address" name="address"
                                        placeholder="Address" value="{{ auth()->user()->address }}" />
                                    <span class="text-danger danger">
                                        @error('address')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select id="gender" class="select2 form-select" name="gender">
                                        <option value="">Select Gender</option>
                                        <option {{ auth()->user()->gender == 'Male' ? 'selected' : null }} value="Male">
                                            Male</option>
                                        <option {{ auth()->user()->gender == 'Female' ? 'selected' : null }}
                                            value="Female">
                                            Female</option>

                                    </select>
                                    <span class="text-danger danger">
                                        @error('gender')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary me-2">Save changes</button>
                            </div>
                        </form>
                    </div>
                    <!-- /Account -->
                </div>
                <div class="card">
                    <h5 class="card-header">Change Password</h5>
                    <div class="card-body">
                        <form action="{{ route('admin.dashboard.profile.change-password') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="mb-3 form-password-toggle">
                                        <label for="old_password" class="form-label">Old Password</label>
                                        <div class="input-group input-group-merge">
                                            <input type="password" id="old_password" class="form-control"
                                                name="old_password" placeholder="***********"
                                                aria-describedby="password" />
                                            <span class="input-group-text cursor-pointer"><i
                                                    class="bx bx-hide"></i></span>
                                        </div>
                                        <span class="text-danger danger">
                                            @error('old_password')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3 form-password-toggle">
                                        <label for="new_password" class="form-label">New Password</label>
                                        <div class="input-group input-group-merge">
                                            <input type="password" id="new_password" class="form-control"
                                                name="new_password" placeholder="***********"
                                                aria-describedby="password" />
                                            <span class="input-group-text cursor-pointer"><i
                                                    class="bx bx-hide"></i></span>
                                        </div>
                                        <span class="text-danger danger">
                                            @error('new_password')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3 form-password-toggle">
                                        <label for="confirm_password" class="form-label">Password Confirmation</label>
                                        <div class="input-group input-group-merge">
                                            <input type="password" id="confirm_password" class="form-control"
                                                name="confirm_password" placeholder="***********"
                                                aria-describedby="password" />
                                            <span class="input-group-text cursor-pointer"><i
                                                    class="bx bx-hide"></i></span>
                                        </div>
                                        <span class="text-danger danger">
                                            @error('confirm_password')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary">Save New Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
