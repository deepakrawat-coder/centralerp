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
<script src="/assets/js/jquery-3.5.1.min.js"></script>
<!-- feather icon js-->
<script src="/assets/js/icons/feather-icon/feather.min.js"></script>
<script src="/assets/js/icons/feather-icon/feather-icon.js"></script>
<!-- Sidebar jquery-->
<script src="/assets/js/sidebar-menu.js"></script>
<script src="/assets/js/config.js"></script>
<!-- Bootstrap js-->
<script src="/assets/js/bootstrap/popper.min.js"></script>
<script src="/assets/js/bootstrap/bootstrap.min.js"></script>
<!-- Plugins JS start-->
{{-- <script src="/assets/js/chart/apex-chart/apex-chart.js"></script>
<script src="/assets/js/chart/apex-chart/stock-prices.js"></script> --}}
<script src="/assets/js/prism/prism.min.js"></script>
<script src="/assets/js/clipboard/clipboard.min.js"></script>
<script src="/assets/js/custom-card/custom-card.js"></script>
<script src="/assets/js/vector-map/jquery-jvectormap-2.0.2.min.js"></script>
<script src="/assets/js/vector-map/map/jquery-jvectormap-world-mill-en.js"></script>
<script src="/assets/js/vector-map/map/jquery-jvectormap-us-aea-en.js"></script>
<script src="/assets/js/vector-map/map/jquery-jvectormap-uk-mill-en.js"></script>
<script src="/assets/js/vector-map/map/jquery-jvectormap-au-mill.js"></script>
<script src="/assets/js/vector-map/map/jquery-jvectormap-chicago-mill-en.js"></script>
<script src="/assets/js/vector-map/map/jquery-jvectormap-in-mill.js"></script>
<script src="/assets/js/vector-map/map/jquery-jvectormap-asia-mill.js"></script>
<script src="/assets/js/datepicker/date-picker/datepicker.js"></script>
<script src="/assets/js/datepicker/date-picker/datepicker.en.js"></script>
<script src="/assets/js/datepicker/date-picker/datepicker.custom.js"></script>
<script src="/assets/js/vector-map/map-vector.js"></script>
<script src="/assets/js/dashboard/dashboard_3.js"></script>
<!-- Plugins JS Ends-->
<!-- Theme js-->
<script src="/assets/js/theme-customizer/customizer.js"></script>
<script src="/assets/js/datatable/datatables/jquery.dataTables.min.js"></script>
<script src="/assets/js/datatable/datatables/datatable.custom.js"></script>
<script src="/assets/js/script.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="/assets/js/tooltip-init.js"></script>
<script src="/assets/js/sweet-alert/sweetalert.min.js"></script>
<script src="/assets/js/sweet-alert/app.js"></script>
<script src="/assests/js/central-js/general.js"></script>
<script src="/assests/js/central-js/custom-script.js"></script>
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
    function loadUniversities(erpId) {
         let erpAccess = 'erpAccess';
        $.ajax({
            url: "/services/university-erp/0",
            type: "GET",
            data: {
                id: erpId,
                 indexPage: erpAccess
            },

            // beforeSend: function () {
            //     toastr.info("Fetching live URL...");
            // },

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

                    new bootstrap.Modal(document.getElementById('erpModal')).show();

                } else {
                    toastr.error("No universities found!");
                }
            },

            error: function() {
                toastr.error("Something went wrong!");
            }
        });
    }
    $(document).on('click', '.erp-item', function() {
        let erpId = $(this).data('id');
        loadUniversities(erpId);
    });
    $(document).on('click', '.erp-university-card', function() {

        let uniId = $(this).data('id');
        let liveUrl = $(this).data('live-url');
        filterdata(liveUrl, uniId);
        if (!uniId) {
            toastr.error("University ID missing!");
            return;
        }
        // window.location.href = "/dashboards/" + uniId+"?live_url="+liveUrl;
        $.ajax({
            url: "/dashboards/" + uniId,
            type: "GET",
            data: {
                id: uniId,
                live_url: liveUrl
            },
            success: function(res) {

                setTimeout(() => {
                    if (res.status) {
                        $('#students-table').DataTable().ajax.reload();
                        console.log('session_id',{{ session('uni_id') }});
                        window.location.href = "/dashboard?id="+res.uni_id;
                    } else {
                        toastr.error(res.message);
                    }
                }, 2000);
            },
            error: function() {
                toastr.error("Something went wrong!");
            }
        });

    });
    function filterdata(liveUrl, uniId) {
        let method = "students";

        // ✅ ALWAYS clear first
        localStorage.removeItem('filters_students');
        localStorage.removeItem('filters_users');
        localStorage.removeItem('filters_wallet');
        localStorage.removeItem('ledgers');

        $.ajax({
            url: `/filters`,
            type: "GET",
            dataType: "json",
            data: {
                liveUrl: liveUrl,
                method: method,
                uniId: uniId
            },
            success: function(response) {
                //  return false;
                if (!response || !response.data) {
                    toastr.error("No filter data found");
                    return;
                }

                // ✅ SET AFTER SUCCESS ONLY
                localStorage.setItem(
                    'filters_students',
                    JSON.stringify(response.data.students)
                );
                localStorage.setItem(
                    'filters_users',
                    JSON.stringify(response.data.users)
                );
                localStorage.setItem(
                    'filters_wallet',
                    JSON.stringify(response.data.wallet)
                );
                localStorage.setItem(
                    'ledgers',
                    JSON.stringify(response.data.ledgers)
                );

            },
            error: function(xhr) {
                console.error(xhr.responseText);
                toastr.error("Something went wrong");
            }
        });
    }
    function changeErpData(erpId) {
        let erpAccess = 'erpAccess';
        $.ajax({
            url: "/services/university-erp/0",
            type: "GET",
            data: {
                id: erpId,
                indexPage: erpAccess
            },

            // beforeSend: function () {
            //     toastr.info("Fetching live URL...");
            // },

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

                    new bootstrap.Modal(document.getElementById('erpModal')).show();

                } else {
                    toastr.error("No universities found!");
                }
            },

            error: function() {
                toastr.error("ERP Configuration is Not Complete");
            }
        });
    }
    $(document).on('click', '#logoutBtn', function(e) {
        e.preventDefault();

        $.ajax({
            url: '/logout',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function() {
                // ✅ clear storage only after success
                localStorage.clear();
                sessionStorage.clear();

                window.location.href = '/';
            },
            error: function() {
                toastr.error('Logout failed!');
            }
        });
    });
    function downloadExcel(header, data, method) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/export/excel';
        form.style.display = 'none';

        const tokenInput = document.createElement('input');
        tokenInput.name = '_token';
        tokenInput.value = $('meta[name="csrf-token"]').attr('content');
        form.appendChild(tokenInput);

        const methodInput = document.createElement('input');
        methodInput.name = 'method';
        methodInput.value = method;
        form.appendChild(methodInput);

        const headerInput = document.createElement('input');
        headerInput.name = 'header';
        headerInput.value = JSON.stringify(header); // ✅ send as JSON string
        form.appendChild(headerInput);

        const dataInput = document.createElement('input');
        dataInput.name = 'data';
        dataInput.value = JSON.stringify(data); // ✅ send as JSON string
        form.appendChild(dataInput);

        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
    }    
    const EXCEL_CONFIG = {
        students: {
            header: [
                'Student ID', 'Enrollment', 'Name', 'Father', 'Email', 'Contact',
                'Process Date', 'Payment Date', 'Document Date',
                'User', 'Course', 'Specialization', 'Address', 'Status', 'Created'
            ],
            filters: [
                'student_id',
                'processed_by_center_start',
                'processed_by_center_end',
                'payment_received_start',
                'payment_received_end',
                'document_received_start',
                'document_received_end',
                'course',
                'user'
            ]
        },

        wallet: {
            header: [
                'Type', 'Transaction Date', 'Transaction ID', 'Gateway ID',
                'Bank', 'Payment Mode', 'Amount', 'Added By', 'Approved By', 'Approved On', 
                'University', 'Created At'
            ],
            filters: [
                'transaction_start',
                'transaction_end',
                'transaction_id',
                'users_id'
            ]
        },

        users: {
            header: [
                'User Name', 'Verticals', 'Short Name', 'Email', 'Contact', 'Designation', 'Students Admission',
                'Address', 'Status', 'Created At'
            ],
            // filters: ['user']
            filters: [
                'processed_by_create_start',
                'processed_by_create_end',
                'user_vertical',
                'user_role'
            ]
        },

        ledger: {
            header: [
                'Student ID', 'Student Name', 'Email', 'Contact',
                'Duration', 'Transaction Date', 'Transaction ID', 'Payment Type', 'Fee Amount',
                'Settlement Amount', 'Final Amount', 'Center', 'Created At'
            ],
            filters: [
                'transaction_start',
                'transaction_end',
                'transaction_id',
                'users_id'
            ]
        }
    };  
    function excelData(method, uni_id, live_url) {

        // 🔹 Date range splitter
        function splitDate(value) {
            if (!value) return {
                start: null,
                end: null
            };

            let parts = value.includes(' - ') ?
                value.split(' - ') :
                value.includes(',') ?
                value.split(',') : [value];

            return {
                start: parts[0]?.trim() ?? null,
                end: parts[1]?.trim() ?? null
            };
        }

        // ✅ IMPORTANT: declare filters FIRST
        let filters = {};

        // ===============================
        // 🎓 STUDENTS FILTERS
        // ===============================
        if (method === 'students') {

            const process = splitDate($('#processed_by_center').val());
            const payment = splitDate($('#payment_received').val());
            const document = splitDate($('#document_received').val());

            filters = {
                student_id: $('#student_id').val(),
                processed_by_center_start: process.start,
                processed_by_center_end: process.end,
                payment_received_start: payment.start,
                payment_received_end: payment.end,
                document_received_start: document.start,
                document_received_end: document.end,
                course: $('#courses').val(),
                user: $('#users').val()
            };
        } else if (method === 'users') {
            const createDate = splitDate($('#created_AT').val());
            filters = {
                processed_by_create_start: createDate.start,
                processed_by_create_end: createDate.end,
                user_vertical: $('#user_vertical').val(),
                user_role: $('#user_role').val()
            };
        } else if (method === 'wallet') {
            // Use helper to parse single date or range
            const range = splitDate($('#transaction_date').val() || '');

            filters = {
                transaction_start: range.start || '',
                transaction_end: range.end || '',
                transaction_type: $('#transaction_type').val() || '',
                transaction_id: $('#transaction_id').val() || ''
            };
        } else if (method === 'ledger') {
            const range = splitDate($('#transaction_date').val() || '');
            filters = {
                transaction_start: range.start || '',
                transaction_end: range.end || '',
                transaction_id: $('#transaction_id').val() || '',
                users_id: $('#course_id').val() || ''
            };
        }


        // ===============================  
        // 🎯 APPLY EXCEL CONFIG RULES
        // ===============================
        const allowedFilters = EXCEL_CONFIG[method]?.filters || [];

        Object.keys(filters).forEach(key => {
            if (!allowedFilters.includes(key) || filters[key] === null || filters[key] === '') {
                delete filters[key];
            }
        });

        // console.log(filters); return false;

        // ===============================
        // 🔹 BUILD FINAL API URL
        // ===============================
        let finalUrl = live_url + '/app/process/index?method=' + method + '&uni_id=' + uni_id;
        //   console.log(finalUrl);return false;
        if (Object.keys(filters).length > 0) {
            finalUrl += '&filter=' + encodeURIComponent(
                btoa(JSON.stringify(filters))
            );
        }

        // ===============================
        // 🔥 FETCH & EXPORT
        // ===============================
        fetch(finalUrl)
            .then(res => res.json())
            .then(res => {

                if (!res.data || res.data.length === 0) {
                    toastr.warning('No data found');
                    return;
                }

                const header = EXCEL_CONFIG[method]?.header || [];
                downloadExcel(header, res.data, method);
            })
            .catch(() => toastr.error('Something went wrong'));
    }
</script>
