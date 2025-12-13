<div class="modal-header">
    <h5 class="modal-title">Add University ERP</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
    <form id="erpCreateForm" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label>ERP Name</label>
            <input type="text" name="name" class="form-control" placeholder="Enter ERP Name" required>
        </div>

        <div class="mb-3">
            <label>Live URL</label>
            <input type="url" name="live_url" class="form-control" placeholder="Enter Live URL">
        </div>

        <div class="mb-3">
            <label>Logo</label>
            <input type="file" name="logo" class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary w-100">Create ERP</button>
    </form>
</div>

<script>
$(document).ready(function () {
    $('#erpCreateForm').on('submit', function(e) {
        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({
            url: "{{ route('university-erp.store') }}",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function () {
                toastr.info("Processing...");
            },
            success: function (response) {
                if (response.status === 'success') {
                    toastr.success(response.message);

                    $('#modal-md').modal('hide');
                    $('#erp-table').DataTable().ajax.reload();
                }
            },
            error: function (xhr) {
                if(xhr.status === 422){
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, val){
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
