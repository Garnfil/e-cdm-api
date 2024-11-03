@extends('layout.master')

@section('content')
    <div class="container-xxl my-4">
        <section class="section-header d-flex justify-content-between align-items-center">
            <div class="title-section">
                <h4 class="fw-medium mb-2">Edit Admin</h4>
                <h6 class="fw-medium text-primary"><a href="#" class="text-muted fw-light">Dashboard /</a> Edit Admin
                </h6>
            </div>
            <div class="action-section btn-group">
                <a href="{{ route('admin.admins.index') }}" class="btn btn-primary"><i class="bx bx-undo"></i> Back to
                    List</a>
            </div>
        </section>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.admins.update', $admin->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-xl-4">
                            <div class="mb-3">
                                <label for="firstname-field" class="form-label">Firstname</label>
                                <input type="text" class="form-control" name="firstname" id="firstname"
                                    value="{{ $admin->firstname }}">
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="mb-3">
                                <label for="lastname-field" class="form-label">Lastname</label>
                                <input type="text" class="form-control" name="lastname" id="lastname"
                                    value="{{ $admin->lastname }}">
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="mb-3">
                                <label for="middlename-field" class="form-label">Middlename</label>
                                <input type="text" class="form-control" name="middlename" id="middlename"
                                    value="{{ $admin->middlename }}">
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="mb-3">
                                <label for="email-field" class="form-label">email</label>
                                <input type="email" class="form-control" name="email" id="email"
                                    value="{{ $admin->email }}">
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="mb-3">
                                <label for="username-field" class="form-label">username</label>
                                <input type="text" class="form-control" name="username" id="username"
                                    value="{{ $admin->username }}">
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="mb-3">
                                <label for="middlename-field" class="form-label">Phone Number</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="phone-number-field">+63</span>
                                    <input type="text" class="form-control" id="basic-phone-number"
                                        aria-describedby="phone-number-field" name="contact_no"
                                        value="{{ $admin->contact_no }}" />
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="mb-3">
                                <label for="gender-select-field" class="form-label">Gender</label>
                                <select name="gender" id="gender-select-field" class="form-select">
                                    <option {{ $admin->gender == 'Male' ? 'selected' : null }} value="Male">
                                        Male</option>
                                    <option {{ $admin->gender == 'Female' ? 'selected' : null }} value="Female">
                                        Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="mb-3">
                                <label for="address-field" class="form-label">Address</label>
                                <input type="text" class="form-control" name="address" id="address-field"
                                    value="{{ $admin->address }}">
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="mb-3">
                                <label for="admin-role-select-field" class="form-label">Admin Role</label>
                                <select name="admin_role" id="admin-role-select-field" class="form-select">
                                    <option {{ $admin->admin_role == 'super_admin' ? 'selected' : null }}
                                        value="super_admin">Super Admin</option>
                                    <option {{ $admin->admin_role == 'admin' ? 'selected' : null }} value="admin">Admin
                                    </option>
                                    <option {{ $admin->admin_role == 'user_manager' ? 'selected' : null }}
                                        value="user_manager">User Manager</option>
                                    <option {{ $admin->admin_role == 'dean' ? 'selected' : null }} value="dean">Dean
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="mb-3">
                                <label for="status-field" class="form-label">status</label>
                                <div class="form-check">
                                    <input name="status" class="form-check-input" type="radio" value="active"
                                        id="status-active-checkbox" {{ $admin->status == 'active' ? 'checked' : null }} />
                                    <label class="form-check-label" for="status-active-checkbox"> Active </label>
                                </div>
                                <div class="form-check">
                                    <input name="status" class="form-check-input" type="radio" value="inactive"
                                        id="status-inactive-checkbox"
                                        {{ $admin->status == 'inactive' ? 'checked' : null }} />
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
