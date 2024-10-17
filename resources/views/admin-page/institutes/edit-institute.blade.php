@extends('layout.master')

@section('content')
    <div class="container-xxl my-4">
        <section class="section-header d-flex justify-content-between align-items-center">
            <div class="title-section">
                <h4 class="fw-medium mb-2">Edit Insitute</h4>
                <h6 class="fw-medium text-primary"><a href="#" class="text-muted fw-light">Dashboard /</a> Edit Insitute
                </h6>
            </div>
            <div class="action-section btn-group">
                <a href="{{ route('admin.institutes.index') }}" class="btn btn-primary"><i class="bx bx-undo"></i> Back to
                    List</a>
            </div>
        </section>


        <div class="row">
            <div class="col-xl-3 col-sm-12"></div>
            <div class="col-xl-6 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.institutes.update', $institute->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="mb-3">
                                        <label for="name-field" class="form-label">Name</label>
                                        <input type="text" name="name" id="name-field" class="form-control"
                                            value="{{ $institute->name }}">
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="mb-3">
                                        <label for="description-field" class="form-label">Description</label>
                                        <input type="text" name="description" id="description-field" class="form-control"
                                            value="{{ $institute->description }}">
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary btn-block w-100">Save Institute</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-12"></div>
        </div>


    </div>
@endsection
