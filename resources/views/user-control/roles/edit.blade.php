<div class="modal-header">
    <h5 class="modal-title">Edit Role</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
    <form id="roleEditForm">
        @csrf
        @method('PUT')

        <input type="hidden" name="role_id" value="{{ $role->id }}">

        <div class="mb-3">
            <label>Role Name</label>
            <input type="text" name="name" class="form-control" value="{{ $role->name }}">
        </div>

        

        <button type="submit" class="btn btn-primary w-100">Update Role</button>
    </form>
</div>

<script>

$('#roleEditForm').on('submit', function (e) {
    e.preventDefault();

    $.ajax({
        url: "{{ route('roles.update', $role->id) }}",
        type: "PUT",
        data: $(this).serialize(),
        beforeSend: function () {
            toastr.info("Processing...");
        },
        success: function (response) {
            if (response.status === "success") {
                toastr.success(response.message);
                $('#modal-md').modal('hide');
                $('#role-table').DataTable().ajax.reload();
            }
        },
        error: function (xhr) {
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                $.each(errors, (key, msg) => toastr.error(msg[0]));
            } else {
                toastr.error("Something went wrong!");
            }
        }
    });
});

</script>
