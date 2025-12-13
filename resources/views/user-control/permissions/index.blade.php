@extends('layouts.main')
@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-header">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3>Permissions</h3>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#"><i data-feather="home"></i></a></li>
                                <li class="breadcrumb-item">User Management</li>
                                <li class="breadcrumb-item active">Permissions</li>
                            </ol>
                        </div>
                        <div class="col-sm-6 text-end">
                            <a href="javascript:void(0)" 
                               onclick="add('{{ route('permissions.create') }}', 'modal-md')" 
                               class="text-primary rounded" 
                               data-bs-toggle="tooltip" title="Add Permission">
                                <i class="ri-apps-2-add-fill fs-3"></i>
                            </a>
                        </div>

                        <div class="col-sm-12 mt-4">
                            <div class="table-responsive">
                                <table id="permission-table" class="display w-100"></table>
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
$(document).ready(function () {
    $('#permission-table').DataTable({
        ajax: "{{ route('permissions.index') }}",
        columns: [
            { title: "#", data: "serial" },
            { title: "Permission Name", data: "name" },
            { title: "Guard Name", data: "guard_name" },
            { title: "Action", data: "action", orderable: false, searchable: false },
        ]
    });

    // Delete Permission
    // $(document).on("click", ".deleteBtn", function() {
    //     let id = $(this).data("id");
    //     if (confirm("Are you sure you want to delete this permission?")) {
    //         $.ajax({
    //             url: "/user-control/permissions/" + id,
    //             type: "DELETE",
    //             data: { _token: "{{ csrf_token() }}" },
    //             success: function (response) {
    //                 toastr.success(response.message);
    //                 $('#permission-table').DataTable().ajax.reload();
    //             },
    //             error: function () {
    //                 toastr.error("Something went wrong!");
    //             }
    //         });
    //     }
    // });
});
</script>
@endsection
