@extends('layout.master')

@section('content')
    <div class="container-xxl my-4">
        <section class="section-header d-flex justify-content-between align-items-center">
            <div class="title-section">
                <h4 class="fw-medium mb-2">School Events</h4>
                <h6 class="fw-medium text-primary"><a href="#" class="text-muted fw-light">Dashboard /</a> School Events
                </h6>
            </div>
            <div class="action-section btn-group">
                <a href="{{ route('admin.school-events.create') }}" class="btn btn-primary"><i class="bx bx-plus"></i> Add
                    School Event</a>
            </div>
        </section>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive text-wrap">
                    <table class="table  table-striped w-100" id="school-events-table">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Event Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            let table;

            function loadTable() {
                table = $('#school-events-table').DataTable({
                    processing: true,
                    pageLength: 10,
                    responsive: true,
                    serverSide: true,
                    lengthChange: false,
                    ordering: true,
                    searching: false,
                    ajax: {
                        url: "{{ route('admin.school-events.index') }}",
                        data: function(d) {
                            d.search = $('#search-field').val(),
                                d.type = $('#type-field').val(),
                                d.status = $('#status-field').val()
                        }
                    },
                    columns: [{
                            data: 'id',
                            name: 'id'
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'event_date',
                            name: 'event_date'
                        },
                        {
                            data: 'actions',
                            name: 'actions',
                            orderable: false,
                        }
                    ],
                    order: [
                        [0, 'desc'] // Sort by the first column (index 0) in descending order
                    ]
                });
            }

            $("#search-field").on('input', function(e) {
                if (table) {
                    table.draw();
                }
            })

            $('#type-field').change(function(e) {
                if (table) {
                    table.draw();
                }
            })

            $(document).on("click", ".remove-btn", function(e) {
                let id = $(this).attr("id");
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Remove event from list",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, remove it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/admin/school-events/${id}`,
                            method: "DELETE",
                            data: {
                                _token: "{{ csrf_token() }}",
                                id: id
                            },
                            success: function(response) {
                                Swal.fire('Removed!', response.message, 'success').then(
                                    result => {
                                        if (result.isConfirmed) {
                                            toastr.success(response.message, 'Success');
                                            location.reload();
                                        }
                                    })
                            }
                        })
                    }
                })
            });

            loadTable();
        </script>
    @endpush
@endsection