@extends('layout.master')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-8 mb-4 order-0">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-sm-7">
                            <div class="card-body">
                                <h5 class="card-title text-primary">Welcome, {{ auth()->user()->firstname }}! 🎉</h5>
                                <p class="mb-4">
                                    Welcome, Admin! We're glad to have you here. Manage with ease, monitor with insight, and
                                    make a difference. Let's keep everything running smoothly together!
                                </p>

                            </div>
                        </div>
                        <div class="col-sm-5 text-center text-sm-left">
                            <div class="card-body pb-0 px-0 px-md-4">
                                <img src="../assets/img/illustrations/educator.png" height="200" alt="View Badge User"
                                    data-app-dark-img="illustrations/educator.png"
                                    data-app-light-img="illustrations/educator.png" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 order-1">
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <button class="btn-primary btn">
                                            <i class='bx bx-user'></i>
                                        </button>
                                    </div>

                                </div>
                                <span class="fw-semibold d-block mb-1">Students</span>
                                <h3 class="card-title mb-2">{{ number_format($total_students) }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <button class="btn-primary btn">
                                            <i class='bx bx-user'></i>
                                        </button>
                                    </div>

                                </div>
                                <span>Instructors</span>
                                <h3 class="card-title text-nowrap mb-1">{{ number_format($total_students) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Total Revenue -->

            <!--/ Total Revenue -->

        </div>
        <div class="row">
            <!-- Order Statistics -->
            <div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between pb-0">
                        <div class="card-title mb-0">
                            <h5 class="m-0 me-2">Course Statistics</h5>
                        </div>
                        <div class="dropdown">
                            <button class="btn p-0" type="button" id="orederStatistics" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="orederStatistics">
                                <a class="dropdown-item" href="javascript:void(0);">Select All</a>
                                <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                                <a class="dropdown-item" href="javascript:void(0);">Share</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex flex-column align-items-center gap-1">
                                <h2 class="mb-2">{{ count($courses) }}</h2>
                                <span>Total Courses</span>
                            </div>
                            {{-- <div id="orderStatisticsChart"></div> --}}
                        </div>
                        <ul class="p-0 m-0">
                            @foreach ($courses as $course)
                                <li class="d-flex mb-4 pb-1">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <span class="avatar-initial rounded bg-label-primary"><i
                                                class="bx bx-mobile-alt"></i></span>
                                    </div>
                                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <h6 class="mb-0">{{ substr($course->name, 0, 30) . '...' }}</h6>
                                            <small class="text-muted">{{ $course->code }}</small>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold">{{ $course->subjects->count() }}</small>
                                        </div>
                                    </div>
                                </li>
                            @endforeach


                        </ul>
                    </div>
                </div>
            </div>
            <!--/ Order Statistics -->

            <!-- Expense Overview -->
            <div class="col-md-6 col-lg-4 order-1 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <ul class="nav nav-pills" role="tablist">
                            <li class="nav-item">
                                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#navs-tabs-line-card-income" aria-controls="navs-tabs-line-card-income"
                                    aria-selected="true">
                                    Discussions
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body px-0">
                        <div class="tab-content p-0">
                            <div class="tab-pane fade show active" id="navs-tabs-line-card-income" role="tabpanel">
                                <div class="d-flex p-4 pt-3">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <img src="../assets/img/icons/unicons/wallet.png" alt="User" />
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Total Discussion Posts</small>
                                        <div class="d-flex align-items-center">
                                            <h6 class="mb-0 me-1">{{ $total_discussions_count }}</h6>

                                        </div>
                                    </div>
                                </div>
                                <div id="incomeChart"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Expense Overview -->

            <!-- Transactions -->
            <div class="col-md-6 col-lg-4 order-2 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0 me-2">Recent Conference Sessions</h5>

                    </div>
                    <div class="card-body">
                        <ul class="p-0 m-0">
                            @forelse ($recent_conference_sessions as $conference_session)
                                <li class="d-flex mb-4 pb-1">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <div class="p-2 bg-primary text-white rounded d-flex justify-content-center">
                                            <i class='bx bx-video-recording'></i>
                                        </div>
                                    </div>
                                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <small
                                                class="text-muted d-block mb-1">{{ $conference_session->classroom->title }}</small>
                                            <h6 class="mb-0">
                                                {{ \Carbon\Carbon::parse($conference_session->end_datetime)->format('M d, Y h:i a') }}
                                            </h6>
                                        </div>
                                        <div class="user-progress d-flex align-items-center gap-1">
                                            <h6 class="mb-0">45 Students</h6>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <div class="text-center">
                                    <img src="{{ URL::asset('assets/img/elements/nodata.gif') }}" alt="">
                                </div>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
            <!--/ Transactions -->
        </div>
    </div>
@endsection
