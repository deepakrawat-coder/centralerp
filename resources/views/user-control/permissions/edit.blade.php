<div class="modal-header">
    <h5 class="modal-title">Edit Permission</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
    <form id="permissionEditForm">
        @csrf
        @method('PUT')

        <input type="hidden" name="permission_id" value="{{ $permission->id }}">

        <div class="mb-3">
            <label>Permission Name</label>
            <input type="text" name="name" class="form-control" value="{{ $permission->name }}">
        </div>

        <button type="submit" class="btn btn-primary w-100">Update Permission</button>
    </form>
</div>

<script>
    $(document).ready(function() {
        $('#permissionEditForm').on('submit', function(e) {
            e.preventDefault();

            let permissionId = $('input[name="permission_id"]').val();
            let updateUrl = `/permissions/${permissionId}`;

            $.ajax({
                url: updateUrl,
                type: "PUT",
                data: $(this).serialize(),
                beforeSend: function() {
                    toastr.info("Processing...");
                },
                success: function(response) {
                    if (response.status === "success") {
                        toastr.success(response.message);
                        $('#modal-md').modal('hide');
                        $('#permission-table').DataTable().ajax.reload();
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, msg) {
                            toastr.error(msg[0]);
                        });
                    } else {
                        toastr.error("Something went wrong!");
                    }
                }
            });

        });
    });
</script>
