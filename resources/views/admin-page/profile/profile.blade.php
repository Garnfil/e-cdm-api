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
                            <img src="../assets/img/avatars/1.png" alt="user-avatar" class="d-block rounded" height="100"
                                width="100" id="uploadedAvatar" />
                            <div class="button-wrapper">
                                <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                    <span class="d-none d-sm-block">Upload new photo</span>
                                    <i class="bx bx-upload d-block d-sm-none"></i>
                                    <input type="file" id="upload" class="account-file-input" hidden
                                        accept="image/png, image/jpeg" />
                                </label>
                                <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
                                    <i class="bx bx-reset d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Reset</span>
                                </button>

                                <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
                            </div>
                        </div>
                    </div>
                    <hr class="my-0" />
                    <div class="card-body">
                        <form id="formAccountSettings" method="POST" onsubmit="return false">
                            <div class="row">
                                <div class="mb-3 col-md-4">
                                    <label for="firstName" class="form-label">First Name</label>
                                    <input class="form-control" type="text" id="firstName" name="firstName"
                                        value="John" autofocus />
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="Middlename" class="form-label">Middle Name</label>
                                    <input class="form-control" type="text" name="middlename" id="middlename"
                                        value="Doe" />
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="lastName" class="form-label">Last Name</label>
                                    <input class="form-control" type="text" name="lastName" id="lastName"
                                        value="Doe" />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="email" class="form-label">E-mail</label>
                                    <input class="form-control" type="text" id="email" name="email"
                                        value="john.doe@example.com" placeholder="john.doe@example.com" />
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="phoneNumber">Phone Number</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text">PH (+63)</span>
                                        <input type="text" id="phoneNumber" name="phoneNumber" class="form-control"
                                            placeholder="91210981523" />
                                    </div>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text" class="form-control" id="address" name="address"
                                        placeholder="Address" />
                                </div>




                                <div class="mb-3 col-md-6">
                                    <label for="currency" class="form-label">Gender</label>
                                    <select id="currency" class="select2 form-select">
                                        <option value="">Select Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>

                                    </select>
                                </div>
                            </div>
                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary me-2">Save changes</button>
                                <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                            </div>
                        </form>
                    </div>
                    <!-- /Account -->
                </div>
                <div class="card">
                    <h5 class="card-header">Delete Account</h5>
                    <div class="card-body">
                        <div class="mb-3 col-12 mb-0">
                            <div class="alert alert-warning">
                                <h6 class="alert-heading fw-bold mb-1">Are you sure you want to delete your account?</h6>
                                <p class="mb-0">Once you delete your account, there is no going back. Please be certain.
                                </p>
                            </div>
                        </div>
                        <form id="formAccountDeactivation" onsubmit="return false">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="accountActivation"
                                    id="accountActivation" />
                                <label class="form-check-label" for="accountActivation">I confirm my account
                                    deactivation</label>
                            </div>
                            <button type="submit" class="btn btn-danger deactivate-account">Deactivate Account</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection