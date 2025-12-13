@extends('layouts.main')
@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-header">
                <div class="card">
                    <div class="card-body">
                        <div class="row">

                            <div class="col-sm-6">
                                <h3>Users</h3>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#"><i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item">User Management</li>
                                    <li class="breadcrumb-item active">Users</li>
                                </ol>
                            </div>
                            <div class="col-sm-6 text-end">
                                <a href="javascript:void(0)" onclick="add('{{ route('users.create') }}', 'modal-md')"
                                    class="text-primary  rounded" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="Add a new user" data-bs-original-title="Add User">
                                    <i class="ri-apps-2-add-fill fs-3"></i>
                                </a>
                            </div>


                            <div class="col-sm-12 mt-4">
                                <div class="table-responsive">
                                    <table id="user-table" class="display w-100"></table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            $('#user-table').DataTable({
                processing: true,
                serverSide: false,
                ajax: "{{ route('users.index') }}",

                columns: [{
                        title: "#",
                        data: "serial"
                    },
                    {
                        title: "Name",
                        data: "name"
                    },
                    {
                        title: "Email",
                        data: "email"
                    },
                    {
                        title: "Roles",
                        data: "roles"
                    },
                    {
                        title: "Action",
                        data: "action",
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // Handle delete button with JS
            // $(document).on("click", ".deleteBtn", function() {
            //     let id = $(this).data("id");
            //     if (confirm("Delete this user?")) {
            //         $.ajax({
            //             url: "/user-control/users/" + id,
            //             type: "DELETE",
            //             data: {
            //                 _token: "{{ csrf_token() }}"
            //             },
            //             success: function() {
            //                 $('#user-table').DataTable().ajax.reload();

            //             }
            //         });
            //     }
            // });

        });
        $(document).ajaxComplete(function() {
            $('[data-bs-toggle="tooltip"]').tooltip();
        });

        $(document).ready(function() {

            $(document).on('mouseenter', '[data-bs-toggle="tooltip"]', function() {

                // Get instance
                let tooltip = bootstrap.Tooltip.getInstance(this);

                // If tooltip does NOT exist, create it
                if (!tooltip) {

                    // Detect color class from button
                    let colorClass = '';
                    if ($(this).hasClass('text-danger')) colorClass = 'tooltip-danger';
                    if ($(this).hasClass('text-warning')) colorClass = 'tooltip-warning';
                    if ($(this).hasClass('text-success')) colorClass = 'tooltip-success';
                    if ($(this).hasClass('text-primary')) colorClass = 'tooltip-primary';

                    new bootstrap.Tooltip(this, {
                        trigger: 'hover',
                        customClass: colorClass, // <-- apply dynamic tooltip color
                        placement: 'top',
                        delay: {
                            show: 50,
                            hide: 50
                        }
                    });
                }
            });

        });
    </script>
@endsection
