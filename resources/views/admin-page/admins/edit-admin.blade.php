@extends('layout.master')

@section('content')

<link rel="stylesheet" href="{{ URL::asset('assets/fingerprint/css/custom.css') }}">

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

    <ul class="nav nav-pills my-3" role="tablist">
        <li class="nav-item">
            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                data-bs-target="#navs-tabs-edit-admin" aria-controls="navs-tabs-edit-admin" aria-selected="true">
                Info
            </button>
        </li>
        <li class="nav-item">
            <button type="button" class="nav-link " role="tab" data-bs-toggle="tab"
                data-bs-target="#navs-tabs-fingerprint" aria-controls="navs-tabs-fingerprint" aria-selected="true">
                Fingerprint
            </button>
        </li>
    </ul>

    <div class="tab-content p-0">
        <div class="tab-pane fade show active" id="navs-tabs-edit-admin" role="tabpanel">
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
                                            value="super_admin">
                                            Super Admin</option>
                                        <option {{ $admin->admin_role == 'admin' ? 'selected' : null }} value="admin">
                                            Admin
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
                                            id="status-inactive-checkbox" {{ $admin->status == 'inactive' ? 'checked' : null }} />
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
        <div class="tab-pane fade" id="navs-tabs-fingerprint" role="tabpanel">
            <div class="card">
                <div class="container">
                    <div id="controls" class="row justify-content-center mx-5 mx-sm-0 mx-lg-5 py-3">
                        <div class="col-sm mb-2 ml-sm-5">
                            <button id="createEnrollmentButton" type="button" class="btn btn-primary btn-block"
                                data-toggle="modal" data-target="#createEnrollment" onclick="beginEnrollment()">Create
                                Enrollment</button>
                        </div>
                        <!-- <div class="col-sm mb-2 mr-sm-5">
                            <button id="verifyIdentityButton" type="button" class="btn btn-primary btn-block"
                                data-toggle="modal" data-target="#verifyIdentity" onclick="beginIdentification()">Verify
                                Identity</button>
                        </div> -->
                    </div>
                </div>

                <section>
                    <div class="modal fade" id="createEnrollment" data-backdrop="static" tabindex="-1"
                        aria-labelledby="createEnrollmentTitle" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title my-text my-pri-color" id="createEnrollmentTitle">Create
                                        Enrollment</h3>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                        onclick="clearCapture()">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="#" onsubmit="return false">
                                        <div id="enrollmentStatusField" class="text-center">
                                            <!--Enrollment Status will be displayed Here-->
                                        </div>
                                        <div class="form-row mt-3">
                                            <div class="col mb-3 mb-md-0 text-center">
                                                <label for="enrollReaderSelect" class="my-text7 my-pri-color">Choose
                                                    Fingerprint Reader</label>
                                                <select name="readerSelect" id="enrollReaderSelect" class="form-control"
                                                    onclick="beginEnrollment()">
                                                    <option selected>Select Fingerprint Reader</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-row mt-2">
                                            <div class="col mb-3 mb-md-0 text-center">
                                                <label for="userID" class="my-text7 my-pri-color">Specify UserID</label>
                                                <input id="userID" type="text" class="form-control" required
                                                    value="{{ $admin->id }}" readonly>
                                                <input id="userIDVerify" type="text" class="form-control" required
                                                    value="{{ $admin->id }}" readonly hidden>
                                            </div>
                                        </div>
                                        <div class="form-row mt-1">
                                            <div class="col text-center">
                                                <p class="my-text7 my-pri-color mt-3">Capture Index Finger</p>
                                            </div>
                                        </div>
                                        <div id="indexFingers" class="row justify-content-center">
                                            <div id="indexfinger1" class="col mb-3 mb-md-0 text-center">
                                                <span class="icon icon-indexfinger-not-enrolled"
                                                    title="not_enrolled"></span>
                                            </div>
                                            <div id="indexfinger2" class="col mb-3 mb-md-0 text-center">
                                                <span class="icon icon-indexfinger-not-enrolled"
                                                    title="not_enrolled"></span>
                                            </div>
                                            <div id="indexfinger3" class="col mb-3 mb-md-0 text-center">
                                                <span class="icon icon-indexfinger-not-enrolled"
                                                    title="not_enrolled"></span>
                                            </div>
                                            <div id="indexfinger4" class="col mb-3 mb-md-0 text-center">
                                                <span class="icon icon-indexfinger-not-enrolled"
                                                    title="not_enrolled"></span>
                                            </div>
                                        </div>
                                        <div class="form-row mt-1">
                                            <div class="col text-center">
                                                <p class="my-text7 my-pri-color mt-5">Capture Middle Finger</p>
                                            </div>
                                        </div>
                                        <div id="middleFingers" class="row justify-content-center">
                                            <div id="middleFinger1" class="col mb-3 mb-md-0 text-center">
                                                <span class="icon icon-middlefinger-not-enrolled"
                                                    title="not_enrolled"></span>
                                            </div>
                                            <div id="middleFinger2" class="col mb-3 mb-md-0 text-center">
                                                <span class="icon icon-middlefinger-not-enrolled"
                                                    title="not_enrolled"></span>
                                            </div>
                                            <div id="middleFinger3" class="col mb-3 mb-md-0 text-center">
                                                <span class="icon icon-middlefinger-not-enrolled"
                                                    title="not_enrolled"></span>
                                            </div>
                                            <div id="middleFinger4" class="col mb-3 mb-md-0 text-center" value="true">
                                                <span class="icon icon-middlefinger-not-enrolled"
                                                    title="not_enrolled"></span>
                                            </div>
                                        </div>
                                        <div class="row m-3 mt-md-5 justify-content-center">
                                            <div class="col-4">
                                                <button class="btn btn-primary btn-block my-sec-bg my-text-button py-1"
                                                    type="submit" onclick="beginCapture()">Start Capture</button>
                                            </div>
                                            <div class="col-4">
                                                <button class="btn btn-primary btn-block my-sec-bg my-text-button py-1"
                                                    type="submit" onclick="serverEnroll()">Enroll</button>
                                            </div>
                                            <!-- <div class="col-4">
                                                <button
                                                    class="btn btn-secondary btn-outline-warning btn-block my-text-button py-1 border-0"
                                                    type="button" onclick="clearCapture()">Clear</button>
                                            </div> -->
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <div class="form-row">
                                        <div class="col">
                                            <button class="btn btn-secondary my-text8 btn-outline-danger border-0"
                                                type="button" data-dismiss="modal"
                                                onclick="clearCapture()">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

</div>

<script src="{{ asset('assets/fingerprint/js/jquery-3.5.0.min.js') }}"></script>
<script src="{{ asset('assets/fingerprint/js/bootstrap.bundle.js') }}"></script>
<script src="{{ asset('assets/fingerprint/js/es6-shim.js') }}"></script>
<script src="{{ asset('assets/fingerprint/js/websdk.client.bundle.min.js') }}"></script>
<script src="{{ asset('assets/fingerprint/js/fingerprint.sdk.min.js') }}"></script>
<script src="{{ asset('assets/fingerprint/js/custom.js') }}"></script>

<script>
    beginEnrollment();
</script>
@endsection