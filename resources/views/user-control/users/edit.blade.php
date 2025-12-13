<div class="modal-header">
    <h5 class="modal-title">Edit User</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

    <form id="userEditForm">
        @csrf
        @method('PUT')

        <input type="hidden" name="user_id" value="{{ $user->id }}">

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control"
                   value="{{ $user->name }}">
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control"
                   value="{{ $user->email }}">
        </div>

        {{-- <div class="mb-3">
            <label>Password (leave blank to keep same)</label>
            <input type="password" name="password" class="form-control" placeholder="Enter new password">
        </div> --}}

        <div class="mb-3">
            <label>Assign Roles</label>
            <select name="roles" class="form-control" >
                @foreach ($roles as $role)
                    <option value="{{ $role->name }}"
                        {{ $user->roles->contains('name', $role->name) ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary w-100">Update User</button>

    </form>
</div>

<script>
$(document).ready(function () {

    $('#userEditForm').on('submit', function(e) {
        e.preventDefault();

        let userId = $('input[name="user_id"]').val();

        $.ajax({
            url: "/users/" + userId,
            type: "POST",
            data: $(this).serialize(),
            beforeSend: function () {
                toastr.info("Updating...");
            },
            success: function (response) {
                if (response.status === "success") {
                    toastr.success(response.message);
                     $('#user-table').DataTable().ajax.reload();
                    // Hide modal
                    $('#modal-md').modal('hide');

                   
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
