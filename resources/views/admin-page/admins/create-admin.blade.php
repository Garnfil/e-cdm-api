@extends('layout.master')

@section('content')
    <div class="container-xxl my-4">
        <section class="section-header d-flex justify-content-between align-items-center">
            <div class="title-section">
                <h4 class="fw-medium mb-2">Add Admin</h4>
                <h6 class="fw-medium text-primary"><a href="#" class="text-muted fw-light">Dashboard /</a> Add Admin
                </h6>
            </div>
            <div class="action-section btn-group">
                <a href="{{ route('admin.admins.index') }}" class="btn btn-primary"><i class="bx bx-undo"></i> Back to
                    List</a>
            </div>
        </section>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.admins.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-xl-4">
                            <div class="mb-3">
                                <label for="firstname-field" class="form-label">Firstname</label>
                                <input type="text" class="form-control" name="firstname" id="firstname"
                                    value="{{ old('firstname') }}">
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="mb-3">
                                <label for="lastname-field" class="form-label">Lastname</label>
                                <input type="text" class="form-control" name="lastname" id="lastname"
                                    value="{{ old('lastname') }}">
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="mb-3">
                                <label for="middlename-field" class="form-label">Middlename</label>
                                <input type="text" class="form-control" name="middlename" id="middlename"
                                    value="{{ old('middlename') }}">
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="mb-3">
                                <label for="email-field" class="form-label">email</label>
                                <input type="email" class="form-control" name="email" id="email"
                                    value="{{ old('email') }}">
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="mb-3">
                                <label for="username-field" class="form-label">username</label>
                                <input type="text" class="form-control" name="username" id="username"
                                    value="{{ old('username') }}">
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="mb-3">
                                <label for="password-field" class="form-label">password</label>
                                <input type="password" class="form-control" name="password" id="password" value="">
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="mb-3">
                                <label for="middlename-field" class="form-label">Phone Number</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="phone-number-field">+63</span>
                                    <input type="text" class="form-control" id="basic-phone-number"
                                        aria-describedby="phone-number-field" name="contact_no"
                                        value="{{ old('contact_no') }}" />
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="mb-3">
                                <label for="gender-select-field" class="form-label">Gender</label>
                                <select name="gender" id="gender-select-field" class="form-select">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="mb-3">
                                <label for="address-field" class="form-label">Address</label>
                                <input type="text" class="form-control" name="address" id="address-field">
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="mb-3">
                                <label for="admin-role-select-field" class="form-label">Admin Role</label>
                                <select name="admin_role" id="admin-role-select-field" class="form-select">
                                    <option value="super_admin">Super Admin</option>
                                    <option value="admin">Admin</option>
                                    <option value="user_manager">User Manager</option>
                                    <option value="dean">Dean</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="mb-3">
                                <label for="status-field" class="form-label">status</label>
                                <div class="form-check">
                                    <input name="status" class="form-check-input" type="radio" value="active"
                                        id="status-active-checkbox" checked />
                                    <label class="form-check-label" for="status-active-checkbox"> Active </label>
                                </div>
                                <div class="form-check">
                                    <input name="status" class="form-check-input" type="radio" value="inactive"
                                        id="status-inactive-checkbox" />
                                    <label class="form-check-label" for="status-inactive-checkbox"> Inactive
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="btn btn-primary">Save Admin</div>
                </form>
            </div>
        </div>
    </div>
@endsection
