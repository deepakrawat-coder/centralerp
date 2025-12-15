</div>
<!-- footer start-->
<div class="modal fade" id="modal-md" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content" id="modal-md-content">
        </div>
    </div>
</div>

<div class="modal fade" id="modal-lg" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" id="modal-lg-content">
        </div>
    </div>
</div>

<div class="modal fade" id="modal-xl" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content" id="modal-xl-content">
        </div>
    </div>
</div><!-- University ERP Modal -->
<div class="modal fade" id="erpModal" tabindex="-1" aria-labelledby="erpModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="erpModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row" id="erpModalBody">
                    <!-- Dynamic ERP items will go here -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- latest jquery-->
<script src="../assets/js/jquery-3.5.1.min.js"></script>
<!-- feather icon js-->
<script src="../assets/js/icons/feather-icon/feather.min.js"></script>
<script src="../assets/js/icons/feather-icon/feather-icon.js"></script>
<!-- Sidebar jquery-->
<script src="../assets/js/sidebar-menu.js"></script>
<script src="../assets/js/config.js"></script>
<!-- Bootstrap js-->
<script src="../assets/js/bootstrap/popper.min.js"></script>
<script src="../assets/js/bootstrap/bootstrap.min.js"></script>
<!-- Plugins JS start-->
{{-- <script src="../assets/js/chart/apex-chart/apex-chart.js"></script>
<script src="../assets/js/chart/apex-chart/stock-prices.js"></script> --}}
<script src="../assets/js/prism/prism.min.js"></script>
<script src="../assets/js/clipboard/clipboard.min.js"></script>
<script src="../assets/js/custom-card/custom-card.js"></script>
<script src="../assets/js/vector-map/jquery-jvectormap-2.0.2.min.js"></script>
<script src="../assets/js/vector-map/map/jquery-jvectormap-world-mill-en.js"></script>
<script src="../assets/js/vector-map/map/jquery-jvectormap-us-aea-en.js"></script>
<script src="../assets/js/vector-map/map/jquery-jvectormap-uk-mill-en.js"></script>
<script src="../assets/js/vector-map/map/jquery-jvectormap-au-mill.js"></script>
<script src="../assets/js/vector-map/map/jquery-jvectormap-chicago-mill-en.js"></script>
<script src="../assets/js/vector-map/map/jquery-jvectormap-in-mill.js"></script>
<script src="../assets/js/vector-map/map/jquery-jvectormap-asia-mill.js"></script>
<script src="../assets/js/datepicker/date-picker/datepicker.js"></script>
<script src="../assets/js/datepicker/date-picker/datepicker.en.js"></script>
<script src="../assets/js/datepicker/date-picker/datepicker.custom.js"></script>
<script src="../assets/js/vector-map/map-vector.js"></script>
<script src="../assets/js/dashboard/dashboard_3.js"></script>
<!-- Plugins JS Ends-->
<!-- Theme js-->
<script src="../assets/js/theme-customizer/customizer.js"></script>
<script src="../assets/js/datatable/datatables/jquery.dataTables.min.js"></script>
<script src="../assets/js/datatable/datatables/datatable.custom.js"></script>
<script src="../assets/js/script.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="../assets/js/tooltip-init.js"></script>
<script src="../assets/js/sweet-alert/sweetalert.min.js"></script>
<script src="../assets/js/sweet-alert/app.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "timeOut": "3000"
    }
</script>

<script>
    function rolePermissions(url, modal) {
        if (modal.length > 0) {
            $.ajax({
                url: url,
                type: "GET",
                success: function(data) {
                    $('#' + modal + '-content').html(data);
                    $('#' + modal).modal('show');
                }
            })
        } else {
            window.location.href = url
        }
    }








    function add(url, modal) {
        if (modal.length > 0) {
            $.ajax({
                url: url,
                type: "GET",
                success: function(data) {
                    $('#' + modal + '-content').html(data);
                    $('#' + modal).modal('show');
                }
            })
        } else {
            window.location.href = url
        }
    }

    function edit(url, modal) {
        $(".modal").modal('hide');
        $.ajax({
            url: url,
            type: "GET",
            success: function(data) {
                $('#' + modal + '-content').html(data);
                $('#' + modal).modal('show');
            }
        })
    }

    //    function destroy(url, table) {
    //     swal({
    //         title: "Are you sure?",
    //         text: "You will not be able to recover this!",
    //         type: "warning",
    //         showCancelButton: true,
    //         confirmButtonColor: "#3085d6",
    //         confirmButtonText: "Yes, delete it!",
    //         cancelButtonText: "Cancel",
    //         closeOnConfirm: false
    //     }, function() {
    //         $.ajax({
    //             url: url,
    //             type: "POST",
    //             data: {
    //                 _method: "DELETE",
    //                 _token: "{{ csrf_token() }}"
    //             },
    //             success: function(response) {
    //                 if (response.status === "success") {
    //                     swal("Deleted!", response.message, "success");

    //                     if (table.length > 0) {
    //                         $('#' + table).DataTable().ajax.reload();
    //                     } else {
    //                         location.reload();
    //                     }
    //                 } else {
    //                     swal("Error!", response.message, "error");
    //                 }
    //             }
    //         });
    //     });
    // }
    function destroy(url, table) {
        Swal.fire({
            title: "Are you sure?",
            text: "You will not be able to recover this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        _method: "DELETE",
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.status === "success") {
                            Swal.fire("Deleted!", response.message, "success");

                            $('#' + table).DataTable().ajax.reload();
                        } else {
                            Swal.fire("Error!", response.message, "error");
                        }
                    }
                });

            }
        });
    }
</script>
{{-- <script>
$(document).ready(function() {
    let debounceTimer;
    const delay = 300; // milliseconds

    $('#search-bar').on('keyup', function() {
        clearTimeout(debounceTimer);
        let query = $(this).val();

        debounceTimer = setTimeout(function() {
            if(query.length >= 4) {
                $.ajax({
                    url: "{{ route('university-erp.search') }}",
                    type: "GET",
                    data: { q: query },
                    success: function(data) {
                        let html = '';
                        if(data.length > 0){
                            data.forEach(function(erp){
                                html += `
                                    <li class="list-group-item d-flex align-items-center">
                                        ${erp.logo ? `<img src="${erp.logo}" class="rounded me-2" width="40">` : ''}
                                        <div>
                                            <strong>${erp.name}</strong><br>
                                            <small>${erp.live_url || ''}</small>
                                        </div>
                                    </li>`;
                            });
                        } else {
                            html = '<li class="list-group-item">No ERP found.</li>';
                        }
                        $('#erp-search-results').html(html);
                    },
                    error: function() {
                        $('#erp-search-results').html('<li class="list-group-item text-danger">Error fetching results.</li>');
                    }
                });
            } else {
                $('#erp-search-results').empty();
            }
        }, delay);
    });
});
</script> --}}
{{-- <script>
function debounce(func, wait) {
    let timeout;
    return function() {
        const context = this, args = arguments;
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(context, args), wait);
    };
}

$('#search-bar').on('input', debounce(function() {
    let query = $(this).val();

    if(query.length < 3) {
        $('#search-results').empty();
        return;
    }

    $.ajax({
        url: "{{ route('university-erp.search') }}",
        type: "GET",
        data: { q: query },
        success: function(response) {
            let html = '';
            response.forEach(function(erp){
                html += `<li class="list-group-item">
                            <img src="${erp.logo ? '/storage/' + erp.logo : '/assets/images/default.png'}" width="30" class="me-2">
                            ${erp.name}
                         </li>`;
            });
            $('#search-results').html(html);
        }
    });
}, 300)); // 300ms debounce
</script> --}}


<script>
    function debounce(func, wait) {
        let timeout;
        return function() {
            const context = this,
                args = arguments;
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(context, args), wait);
        };
    }

    $('#search-bar').on('input', debounce(function() {
        let query = $(this).val().trim();

        if (query.length < 3) {
            $('#search-results').empty();
            return;
        }

        $.ajax({
            url: "{{ route('university-erp.search') }}",
            type: "GET",
            data: {
                q: query
            },
            success: function(response) {
                let html = '';
                if (response.length === 0) {
                    html = '<li class="list-group-item">No results found</li>';
                } else {
                    response.forEach(function(erp) {
                        html += `<li class="list-group-item d-flex align-items-center">
                                <a href="javascript:void(0);" class="d-flex align-items-center text-decoration-none erp-item" data-id="${erp.id}">
                                <img src="${erp.logo ? '/storage/' + erp.logo : '/assets/images/default.png'}" width="30" class="me-2 rounded-circle">
                                ${erp.name}
                                </a>
                             </li>`;
                    });
                }
                $('#search-results').html(html);
            }
        });
    }, 300));
    
    $(document).on('click', '.erp-item', function() {
        let erpId = $(this).data('id');

        $.ajax({
            url: "/services/university-erp/0",
            type: "GET",
            data: {
                id: erpId
            },

            beforeSend: function() {
                toastr.info("Fetching live URL...");
            },

            success: function(response) {
                if (response.status === true && Array.isArray(response.data)) {

                    let universities = response.data;
                    let liveUrl = response.live_url.replace(/\/$/, '');

                    $('#erpModalLabel').text('Select University');
                    $('#erpModalBody').html('');

                    let html = `<div class="row justify-content-center">`;

                    universities.forEach(function(uni) {

                        let logo = uni.Logo ?
                            liveUrl + uni.Logo :
                            '/assets/images/default.png';

                        html += `
                        <div class="col-md-4 text-center mb-3">
                            <div class="card erp-university-card"
                                 data-id="${uni.ID}"
                                 data-live-url="${liveUrl}"                                 
                                 style="cursor:pointer;">
                                <div class="card-body">
                                    <img src="${logo}" class="img-fluid mb-2" style="max-height:90px;">
                                    <p class="mb-0">
                                        <strong>${uni.Short_Name}</strong><br>
                                        <small>(${uni.Vertical})</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                    `;
                    });

                    html += `</div>`;
                    $('#erpModalBody').html(html);

                    // 🔥 SHOW MODAL
                    new bootstrap.Modal(document.getElementById('erpModal')).show();

                } else {
                    toastr.error("No universities found!");
                }
            },

            error: function() {
                toastr.error("Something went wrong!");
            }
        });
    });
    $(document).on('click', '.erp-university-card', function() {

        let uniId = $(this).data('id');
        let liveUrl = $(this).data('live-url');
        if (!uniId) {
            toastr.error("University ID missing!");
            return;
        }

        $.ajax({
            url: "/dashboards/"+uniId,
            type: "GET",
            data: {
                id: uniId,
                live_url: liveUrl
            },
            success: function(res) {
                if (res.status) {
                    window.location.href = "/dashboard" ;
                } else {
                    toastr.error(res.message);
                }
            },
            error: function() {
                toastr.error("Something went wrong!");
            }
        });

    });
</script>
