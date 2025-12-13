<div class="modal-header">
    <h5 class="modal-title">Add User</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

    <form id="userCreateForm">
        @csrf

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" placeholder="Enter name">
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" placeholder="Enter email">
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" placeholder="Enter password">
        </div>

        <div class="mb-3">
            <label>Assign Roles</label>
            <select name="roles" class="form-control" >
                @foreach ($roles as $role)
                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary w-100">Create User</button>

    </form>
</div>

<script>
$(document).ready(function () {

    $('#userCreateForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: "{{ route('users.store') }}",
            type: "POST",
            data: $(this).serialize(),
            beforeSend: function () {
                toastr.info("Processing...");
            },
            success: function (response) {
                if (response.status === "success") {
                    toastr.success(response.message);

                    // Close modal
                    $('#modal-md').modal('hide');

                    // Reload page OR reload datatable
                    $('#user-table').DataTable().ajax.reload();
                }
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


