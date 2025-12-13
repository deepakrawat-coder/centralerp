<div class="modal-header">
    <h5 class="modal-title">Edit University ERP</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
    {{-- <form id="erpEditForm" enctype="multipart/form-data">
        @csrf
        @method('POST')

        <input type="hidden" name="erp_id" value="{{ $erp->id }}">

        <div class="mb-3">
            <label>ERP Name</label>
            <input type="text" name="name" class="form-control" value="{{ $erp->name }}" required>
        </div>

        <div class="mb-3">
            <label>Live URL</label>
            <input type="url" name="live_url" class="form-control" value="{{ $erp->live_url }}">
        </div>

        <div class="mb-3">
            <label>Logo</label>
            @if ($erp->logo)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $erp->logo) }}" width="80">
                </div>
            @endif
            <input type="file" name="logo" class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary w-100">Update ERP</button>
    </form> --}}
    <form id="erpEditForm" enctype="multipart/form-data">
        @csrf
        @method('PUT') <!-- important -->
        <input type="hidden" name="erp_id" value="{{ $erp->id }}">

        <div class="mb-3">
            <label>ERP Name</label>
            <input type="text" name="name" class="form-control" value="{{ $erp->name }}" required>
        </div>

        <div class="mb-3">
            <label>Live URL</label>
            <input type="url" name="live_url" class="form-control" value="{{ $erp->live_url }}">
        </div>

        <div class="mb-3">
            <label>Logo</label>
            <input type="file" name="logo" class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary w-100">Update ERP</button>
    </form>
</div>

<script>
    // $(document).ready(function() {
    //     $('#erpEditForm').on('submit', function(e) {
    //         e.preventDefault();

    //         let erpId = $('input[name="erp_id"]').val();
    //         let formData = new FormData(this);

    //         $.ajax({
    //             url: "/university-erp/update/" + erpId,
    //             type: "POST",
    //             data: formData,
    //             contentType: false,
    //             processData: false,
    //             beforeSend: function() {
    //                 toastr.info("Updating...");
    //             },
    //             success: function(response) {
    //                 if (response.status === true) {
    //                     toastr.success(response.message);
    //                     $('#modal-md').modal('hide');
    //                     $('#erp-table').DataTable().ajax.reload();
    //                 }
    //             },
    //             error: function(xhr) {
    //                 if (xhr.status === 422) {
    //                     let errors = xhr.responseJSON.errors;
    //                     $.each(errors, function(key, val) {
    //                         toastr.error(val[0]);
    //                     });
    //                 } else {
    //                     toastr.error("Something went wrong!");
    //                 }
    //             }
    //         });
    //     });
    // });
    $('#erpEditForm').on('submit', function(e) {
        e.preventDefault();

        let formData = new FormData(this);
        let erpId = $('input[name="erp_id"]').val();

        $.ajax({
            url: "/university-erp/" + erpId,
            type: "POST", // Keep POST with @method('PUT') OR type: "PUT"
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.status === 'success') {
                    toastr.success(response.message);
                    $('#modal-md').modal('hide');
                    $('#erp-table').DataTable().ajax.reload();
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, val) {
                        toastr.error(val[0]);
                    });
                } else {
                    toastr.error("Something went wrong!");
                }
            }
        });
    });
</script>
