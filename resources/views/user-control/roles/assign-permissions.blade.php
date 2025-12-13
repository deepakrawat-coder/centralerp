<div class="modal-header">
    <h4 class="modal-title fw-bold">Add Role Permissions</h4>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
    <!-- Header Section -->


    <!-- Edit Role Form -->
    <form id="assignPermissionForm" class="row g-3">
        @csrf
        <input type="hidden" name="id" value="{{ $role->id }}">

        <!-- Role Name -->
        <div class="col-12 mb-4">
            <label class="form-label fw-bold" for="name">Role Name</label>
            <input type="text" id="name" name="name" value="{{ $role->name }}" class="form-control"
                placeholder="Enter a role name" />
        </div>

        <!-- Role Permissions -->
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Role Permissions</h5>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="selectAll">
                    <label class="form-check-label" for="selectAll">
                        Select All
                    </label>
                </div>
            </div>

            <!-- Permission List - Horizontal Layout like image -->
            <div class=" rounded p-3" style="max-height: 700px; overflow-y: auto;">
                @foreach ($groupedPermissions as $module => $permissions)
                    <!-- Module Row -->
                    <div class=" mb-3 d-flex justify-content-between">
                        <!-- Module Name (Optional - remove if not needed) -->
                        <div class="mb-2" style="width:20%">
                            <h6 class="fw-semibold text-black">{{ $module }}</h6>
                        </div>
                        <!-- Permissions in horizontal line -->
                        <div class="d-flex justify-content-between flex-wrap gap-3" style="width:80%">
                            @foreach ($permissions as $id => $name)
                                <div class="form-check">
                                    <input class="form-check-input permission-checkboxes"
                                        {{ in_array($id, $allotedPermissions) ? 'checked' : '' }} name="permissions[]"
                                        value="{{ $id }}" type="checkbox"
                                        id="permission-checkbox-{{ $id }}" />
                                    <label class="form-check-label" for="permission-checkbox-{{ $id }}">
                                        <!-- Remove module name if already in name -->
                                        @php
                                            // Remove module name from display if it's already there
                                           $displayName = str_replace($module . ' ', '', $name);
                                        @endphp
                                        {{ $displayName }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    @if (!$loop->last)
                        <hr class="my-3">
                    @endif
                @endforeach
            </div>
            <!-- End Permission List -->
        </div>

        <!-- Action Buttons -->
        <div class="col-12 text-center mt-4">
            <button type="submit" class="btn btn-primary me-sm-3 me-1">Save Changes</button>
            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">
                Cancel
            </button>
        </div>
    </form>
</div>

{{-- <script>
    $(document).ready(function() {
        // Select All functionality
        $('#selectAll').click(function() {
            if ($(this).prop("checked")) {
                $(".permission-checkboxes").prop("checked", true);
                toastr.info('All permissions selected');
            } else {
                $(".permission-checkboxes").prop("checked", false);
                toastr.info('All permissions deselected');
            }
        });

        // Update Select All checkbox state
        $('.permission-checkboxes').click(function() {
            const totalCheckboxes = $(".permission-checkboxes").length;
            const checkedCheckboxes = $(".permission-checkboxes:checked").length;

            if (totalCheckboxes === checkedCheckboxes) {
                $("#selectAll").prop("checked", true);
            } else {
                $("#selectAll").prop("checked", false);
            }
        });

        // Form Validation
        $("#assignPermissionForm").validate({
            rules: {
                name: {
                    required: true,
                    minlength: 2
                }
            },
            messages: {
                name: {
                    required: "Please enter role name",
                    minlength: "Role name must be at least 2 characters"
                }
            }
        });

        // Form Submission
        // $("#assignPermissionForm").submit(function(e) {
        //     e.preventDefault();

        //     if ($("#assignPermissionForm").valid()) {
        //         const submitBtn = $('button[type="submit"]');
        //         submitBtn.prop('disabled', true).html(
        //             '<span class="spinner-border spinner-border-sm me-2"></span>Saving...');

        //         const formData = $(this).serialize();

        //         $.ajax({
        //             url: "{{ route('roles.permissions.update', $role->id) }}",
        //             type: "POST",
        //             data: formData,
        //             dataType: 'json',
        //             beforeSend: () => toastr.info("Updating permissions..."),
        //             success: (response) => {
        //                 if (response.status === 'success') {
        //                     toastr.success(response.message);
        //                     $('#modal-md').modal('hide');

        //                     setTimeout(() => {
        //                         window.location.reload();
        //                     }, 1500);
        //                 } else {
        //                     toastr.error(response.message);
        //                     submitBtn.prop('disabled', false).html('Save Changes');
        //                 }
        //             },
        //             error: (xhr) => {
        //                 const errorMsg = xhr.responseJSON?.message ||
        //                     "Error updating permissions";
        //                 toastr.error(errorMsg);
        //                 submitBtn.prop('disabled', false).html('Save Changes');
        //             }
        //         });
        //     }
        // });
        $("#assignPermissionForm").on("submit", function(e) {
            e.preventDefault();

            let submitBtn = $('button[type="submit"]');
            submitBtn.prop("disabled", true).html(
                '<span class="spinner-border spinner-border-sm me-2"></span>Saving...'
            );

            $.ajax({
                url: "{{ route('roles.permissions.update', $role->id) }}",
                type: "POST",
                data: $(this).serialize(),
                dataType: "json",

                beforeSend: function() {
                    toastr.info("Updating permissions...");
                },

                success: function(response) {
                    // success response
                    if (response.status === "success") {
                        toastr.success(response.message);

                        $("#modal-md").modal("hide");

                        setTimeout(function() {
                            window.location.reload();
                        }, 1000);
                    } else {
                        toastr.error(response.message);
                        submitBtn.prop("disabled", false).html('Save Changes');
                    }
                },

                error: function(xhr) {
                    let msg = xhr.responseJSON?.message ?? "Error updating permissions";
                    toastr.error(msg);

                    submitBtn.prop("disabled", false).html('Save Changes');
                }
            });
        });


    });
</script> --}}
<script>
    $(document).ready(function() {

        // Select All functionality
        $('#selectAll').click(function() {
            $(".permission-checkboxes").prop("checked", $(this).prop("checked"));
            toastr.info($(this).prop("checked") ? 'All permissions selected' :
                'All permissions deselected');
        });

        // Update Select All checkbox state
        $('.permission-checkboxes').click(function() {
            const total = $(".permission-checkboxes").length;
            const checked = $(".permission-checkboxes:checked").length;
            $("#selectAll").prop("checked", total === checked);
        });

        // Form Submission (NO VALIDATION)
        $("#assignPermissionForm").on("submit", function(e) {
            e.preventDefault();

            let submitBtn = $('button[type="submit"]');
            submitBtn.prop("disabled", true).html(
                '<span class="spinner-border spinner-border-sm me-2"></span>Saving...'
            );

            $.ajax({
                url: "{{ route('roles.permissions.update', $role->id) }}",
                type: "POST",
                data: $(this).serialize(),
                dataType: "json",

                beforeSend: function() {
                    toastr.info("Updating permissions...");
                },

                success: function(response) {
                    if (response.status === "success") {
                        toastr.success(response.message);
                        $(".modal").modal("hide");
                        $('#role-table').DataTable().ajax.reload();
                    } else {
                        toastr.error(response.message);
                        submitBtn.prop("disabled", false).html('Save Changes');
                    }
                },

                error: function(xhr) {
                    let msg = xhr.responseJSON?.message ?? "Error updating permissions";
                    toastr.error(msg);
                    submitBtn.prop("disabled", false).html('Save Changes');
                }
            });
        });

    });
</script>

<style>
    .form-check-input {
        width: 16px;
        height: 16px;
        cursor: pointer;
        margin-right: 8px;
    }

    .form-check-input:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    .form-check-label {
        cursor: pointer;
        user-select: none;
        font-size: 14px;
    }

    .permission-module-row .d-flex {
        gap: 20px;
    }

    .permission-module-row .form-check {
        margin-bottom: 5px;
    }

    /* Module header styling */
    .permission-module-row h6 {
        font-size: 15px;
        color: #495057;
        border-bottom: 1px solid #dee2e6;
        padding-bottom: 5px;
        margin-bottom: 10px;
    }

    .btn-label-secondary {
        background-color: transparent;
        border-color: #6c757d;
        color: #6c757d;
    }

    .btn-label-secondary:hover {
        background-color: #6c757d;
        color: white;
    }
</style>
