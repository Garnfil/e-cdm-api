@extends('layout.master')

@section('content')
    <div class="container-xxl my-4">
        <section class="section-header d-flex justify-content-between align-items-center">
            <div class="title-section">
                <h4 class="fw-medium mb-2">Add Course</h4>
                <h6 class="fw-medium text-primary"><a href="#" class="text-muted fw-light">Dashboard /</a> Add Course
                </h6>
            </div>
            <div class="action-section btn-group">
                <a href="{{ route('admin.courses.index') }}" class="btn btn-primary"><i class="bx bx-undo"></i> Back to
                    List</a>
            </div>
        </section>


        <div class="row">
            <div class="col-xl-3 col-sm-12"></div>
            <div class="col-xl-6 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.courses.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="mb-3">
                                        <label for="name-field" class="form-label">Name</label>
                                        <input type="text" name="name" id="name-field" class="form-control">
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="mb-3">
                                        <label for="description-field" class="form-label">Institute</label>
                                        <select name="institute_id" id="institute-field" class="form-select">
                                            @foreach ($institutes as $institute)
                                                <option value="{{ $institute->id }}">{{ $institute->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary btn-block w-100">Save Course</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-12"></div>
        </div>


    </div>
@endsection
