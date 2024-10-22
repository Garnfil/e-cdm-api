@extends('layout.master')

@section('content')
    <div class="container-xxl my-4">
        <section class="section-header d-flex justify-content-between align-items-center">
            <div class="title-section">
                <h4 class="fw-medium mb-2">Edit Subject</h4>
                <h6 class="fw-medium text-primary"><a href="#" class="text-muted fw-light">Dashboard /</a> Edit Subject
                </h6>
            </div>
            <div class="action-section btn-group">
                <a href="{{ route('admin.subjects.index') }}" class="btn btn-primary"><i class="bx bx-undo"></i> Back to
                    List</a>
            </div>
        </section>

        <div class="row">
            <div class="col-xl-3"></div>
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.subjects.update', $subject->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="form-group mb-3">
                                <label for="title-field" class="form-label">Title</label>
                                <input type="text" class="form-control" name="title" id="title-field"
                                    value="{{ $subject->title }}">
                            </div>
                            <div class="form-group mb-3">
                                <label for="code-field" class="form-label">Code</label>
                                <input type="text" class="form-control" name="code" id="code-field"
                                    value="{{ $subject->code }}">
                            </div>
                            <div class="form-group mb-3">
                                <label for="course-field" class="form-label">course</label>
                                <select name="course_id" id="course-field" class="form-select">
                                    @foreach ($courses as $course)
                                        <option {{ $course->id == $subject->course_id ? 'selected' : null }}
                                            value="{{ $course->id }}">{{ $course->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="description-field" class="form-label">Description</label>
                                <input type="text" class="form-control" name="description" id="description-field"
                                    value="{{ $subject->description }}">
                            </div>
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="form-group mb-3">
                                        <label for="" class="form-label">Type</label>
                                        <div class="form-check">
                                            <input name="type" class="form-check-input" type="radio" value="major"
                                                id="type-radio-major" {{ $subject->type == 'major' ? 'checked' : null }} />
                                            <label class="form-check-label" for="type-radio-major"> Major </label>
                                        </div>
                                        <div class="form-check">
                                            <input name="type" class="form-check-input" type="radio" value="minor"
                                                id="type-radio-minor" {{ $subject->type == 'minor' ? 'checked' : null }} />
                                            <label class="form-check-label" for="type-radio-minor"> Minor </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group mb-3">
                                        <label for="" class="form-label">Status</label>
                                        <div class="form-check">
                                            <input name="status" class="form-check-input" type="radio" value="active"
                                                id="status-radio-active"
                                                {{ $subject->status == 'active' ? 'checked' : null }} />
                                            <label class="form-check-label" for="status-radio-active"> Active </label>
                                        </div>
                                        <div class="form-check">
                                            <input name="status" class="form-check-input" type="radio" value="inactive"
                                                id="status-radio-inactive"
                                                {{ $subject->status == 'inactive' ? 'checked' : null }} />
                                            <label class="form-check-label" for="status-radio-inactive"> Inactive </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary btn-block w-100">Save Subject</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xl-3"></div>
        </div>
    </div>
@endsection
