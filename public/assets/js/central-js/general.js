toastr.options = {
    closeButton: true,
    progressBar: true,
    positionClass: "toast-top-right",
    timeOut: "3000",
};
function rolePermissions(url, modal) {
    if (modal.length > 0) {
        $.ajax({
            url: url,
            type: "GET",
            success: function (data) {
                $("#" + modal + "-content").html(data);
                $("#" + modal).modal("show");
            },
        });
    } else {
        window.location.href = url;
    }
}
function add(url, modal) {
    if (modal.length > 0) {
        $.ajax({
            url: url,
            type: "GET",
            success: function (data) {
                $("#" + modal + "-content").html(data);
                $("#" + modal).modal("show");
            },
        });
    } else {
        window.location.href = url;
    }
}
function edit(url, modal) {
    $(".modal").modal("hide");
    $.ajax({
        url: url,
        type: "GET",
        success: function (data) {
            $("#" + modal + "-content").html(data);
            $("#" + modal).modal("show");
        },
    });
}
function destroy(url, table) {
    Swal.fire({
        title: "Are you sure?",
        text: "You will not be able to recover this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: url,
                type: "POST",
                data: {
                    _method: "DELETE",
                    _token: "{{ csrf_token() }}",
                },
                success: function (response) {
                    if (response.status === "success") {
                        Swal.fire("Deleted!", response.message, "success");

                        $("#" + table)
                            .DataTable()
                            .ajax.reload();
                    } else {
                        Swal.fire("Error!", response.message, "error");
                    }
                },
            });
        }
    });
}
