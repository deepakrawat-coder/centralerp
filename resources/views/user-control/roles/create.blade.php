<div class="modal-header">
    <h5 class="modal-title">Add Role</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
    <form id="roleCreateForm">
        @csrf

        <div class="mb-3">
            <label>Role Name</label>
            <input type="text" name="name" class="form-control" placeholder="Enter role name">
        </div>
        <button type="submit" class="btn btn-primary w-100">Create Role</button>
    </form>
</div>

<script>
$(document).ready(function () {
    $('#roleCreateForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: "{{ route('roles.store') }}",
            type: "POST",
            data: $(this).serialize(),
            beforeSend: function () {
                toastr.info("Processing...");
            },
            success: function (response) {
                toastr.success(response.message);
                $('#modal-md').modal('hide');
                $('#role-table').DataTable().ajax.reload();
            },
            error: function (xhr) {
                toastr.error("Error occurred!");
            }
        });
    });
});
</script>
