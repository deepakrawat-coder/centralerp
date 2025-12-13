@extends('layouts.main')
@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-header">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <h3>Roles</h3>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#"><i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item">User Management</li>
                                    <li class="breadcrumb-item active">Roles</li>
                                </ol>
                            </div>
                            <div class="col-sm-6 text-end">
                                <a href="javascript:void(0)" onclick="add('{{ route('roles.create') }}', 'modal-md')"
                                    class="text-primary rounded" data-bs-toggle="tooltip" title="Add Role">
                                    <i class="ri-apps-2-add-fill fs-3"></i>
                                </a>
                            </div>
                            <div class="col-sm-12 mt-4">
                                <div class="table-responsive">
                                    <table id="role-table" class="display w-100"></table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- View Permissions Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModalLabel">Permissions</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="viewModalBody"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function rolePermissionsView(roleName, modules) {
            const titleElem = document.getElementById('viewModalLabel');
            const bodyElem = document.getElementById('viewModalBody');

            if (!titleElem || !bodyElem) {
                console.error('Modal elements not found in DOM.');
                return;
            }

            titleElem.innerText = 'Permissions of ' + roleName;
            bodyElem.innerHTML = '<pre>' + modules + '</pre>';

            const viewModal = new bootstrap.Modal(document.getElementById('viewModal'));
            viewModal.show();
        }
        $(document).ready(function() {
            $('#role-table').DataTable({
                ajax: "{{ route('roles.index') }}",
                columns: [{
                        title: "#",
                        width:'10%',
                        data: "serial"
                    },
                    {
                        title: "Role Name",
                         width:'70%',
                        data: "name"
                    },
                    {
                        title: "Permissions",
                         width:'10%',
                        data: "permissions"
                    },
                    {
                        title: "Action",
                         width:'10%',
                        data: "action",
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            $(document).on("click", ".deleteBtn", function() {
                let id = $(this).data("id");
                if (confirm("Are you sure you want to delete this role?")) {
                    $.ajax({
                        url: "/user-control/roles/" + id,
                        type: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            toastr.success(response.message);
                            $('#role-table').DataTable().ajax.reload();
                        },
                        error: function() {
                            toastr.error("Something went wrong!");
                        }
                    });
                }
            });
        });
    </script>
@endsection
