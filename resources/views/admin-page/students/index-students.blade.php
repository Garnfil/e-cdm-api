@extends('layout.master')

@section('content')
    <div class="container-xxl my-4">
        <section class="section-header d-flex justify-content-between align-items-center">
            <div class="title-section">
                <h4 class="fw-medium mb-2">Students</h4>
                <h6 class="fw-medium text-primary"><a href="#" class="text-muted fw-light">Dashboard /</a> Students</h6>
            </div>
            <div class="action-section btn-group">
                <a href="#" class="btn btn-primary"><i class="bx bx-plus"></i> Add Student</a>
            </div>
        </section>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive text-wrap">
                    <table class="table table-striped table-bordered" id="students-table">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Student ID</th>
                                <th>Email</th>
                                <th>Name</th>
                                <th>Institute</th>
                                <th>Course</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
