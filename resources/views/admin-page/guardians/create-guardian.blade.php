@extends('layout.master')

@section('content')
    <div class="container-xxl my-4">
        <section class="section-header d-flex justify-content-between align-items-center">
            <div class="title-section">
                <h4 class="fw-medium mb-2">Add Guardian</h4>
                <h6 class="fw-medium text-primary"><a href="#" class="text-muted fw-light">Dashboard /</a> Add Guardian
                </h6>
            </div>
            <div class="action-section btn-group">
                <a href="{{ route('admin.guardians.index') }}" class="btn btn-primary"><i class="bx bx-undo"></i> Back to
                    List</a>
            </div>
        </section>

        <form action="{{ route('admin.guardians.store') }}" method="post">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @csrf
            <div class="row">
                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-4">
                                    <div class="mb-3">
                                        <label for="firstname-field" class="form-label">Firstname</label>
                                        <input type="text" class="form-control" name="firstname" id="firstname-field"
                                            value="{{ old('firstname') }}">
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="mb-3">
                                        <label for="lastname-field" class="form-label">Lastname</label>
                                        <input type="text" class="form-control" name="lastname" id="lastname-field"
                                            value="{{ old('lastname') }}">
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="mb-3">
                                        <label for="middlename-field" class="form-label">middlename</label>
                                        <input type="text" class="form-control" name="middlename" id="middlename-field"
                                            value="{{ old('middlename') }}">
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="mb-3">
                                        <label for="email-field" class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" id="email-field"
                                            value="{{ old('email') }}">
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="mb-3">
                                        <label for="password-field" class="form-label">password</label>
                                        <input type="password" class="form-control" name="password" id="password-field">
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="mb-3">
                                        <label for="middlename-field" class="form-label">Phone Number</label>
                                        <div class="input-group">
                                            <span class="input-group-text" id="phone-number-field">+63</span>
                                            <input type="text" class="form-control" id="basic-phone-number"
                                                aria-describedby="phone-number-field" name="phone_number"
                                                value="{{ old('phone_number') }}" />
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
                                        <label for="birthdate-field" class="form-label">birthdate</label>
                                        <input type="date" class="form-control" name="birthdate" id="birthdate-field"
                                            value="{{ old('birthdate') }}">
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="mb-3">
                                        <label for="age-field" class="form-label">Age</label>
                                        <input type="number" class="form-control" name="age" id="age-field"
                                            value="{{ old('age') }}">
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
                                            <input name="status" class="form-check-input" type="radio"
                                                value="inactive" id="status-inactive-checkbox" />
                                            <label class="form-check-label" for="status-inactive-checkbox"> Inactive
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary">Save Guardian</button>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label for="students-field" class="form-label">Students</label>
                                <select name="student_ids[]" id="students-select-field" class="form-select" multiple>
                                    <option value="">-- SELECT STUDENT --</option>
                                    @foreach ($students as $student)
                                        <option value="{{ $student->id }}">
                                            {{ $student->firstname . ' ' . $student->lastname }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- <div class="student-information-container">
                            <h4>Full Name: <span id="fullname-text"></span></h4>
                            <h4>Student ID: <span id="student-id-text"></span></h4>
                            <h4>Email: <span id="fullname-text"></span></h4>
                            <h4>Full Name: <span id="fullname-text"></span></h4>
                        </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#students-select-field').select2();
            })

            // $('#students-select-field').change(async function(e) {
            //     let student = await fetchStudent(e.target.value);
            //     console.log(student);
            // })

            // const fetchStudent = async (id) => {
            //     const response = await fetch(`/admin/students/all?id=${id}`);
            //     const data = await response.json();
            //     if (data.students.length > 0) {
            //         return data.students[0];
            //     }

            //     return;
            // }
        </script>
    @endpush
@endsection
