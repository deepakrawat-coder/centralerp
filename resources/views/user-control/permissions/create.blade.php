<div class="modal-header">
    <h5 class="modal-title">Add Permission</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
    <form id="permissionCreateForm">
        @csrf

        <div class="mb-3">
            <label>Permission Name</label>
            <input type="text" name="name" class="form-control" placeholder="Enter permission name">
        </div>

        <button type="submit" class="btn btn-primary w-100">Create Permission</button>
    </form>
</div>

<script>
$(document).ready(function () {
    $('#permissionCreateForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: "{{ route('permissions.store') }}",
            type: "POST",
            data: $(this).serialize(),
            beforeSend: function () {
                toastr.info("Processing...");
            },
            success: function (response) {
                toastr.success(response.message);
                $('#modal-md').modal('hide');
                $('#permission-table').DataTable().ajax.reload();
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function (key, val) {
                        toastr.error(val[0]);
                    });
                } else {
                    toastr.error("Something went wrong!");
                }
            }
        });
    });
});
</script>
