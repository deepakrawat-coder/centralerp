@extends('layouts.main')
@section('styles')
    <style>
        #students-table {
            width: max-content !important;
        }

        #students-table thead tr th,
        #students-table tbody tr td {
            width: max-content !important;
        }

        .filter-section {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            display: none;
        }

        .filter-section.show {
            display: block;
        }

        .date-range-input {
            position: relative;
        }

        .date-range-input .form-control {
            padding-right: 40px;
        }

        .date-range-input .clear-date {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #999;
            cursor: pointer;
            display: none;
        }

        .date-range-input .clear-date:hover {
            color: #333;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker@3.1/daterangepicker.css" />
@endsection

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="mb-0">Students List</h3>
                        <div>
                            <button id="toggle-filters" class="btn btn-primary btn-sm me-2">
                                <i class="fa fa-filter"></i> Show Filters
                            </button>
                            
                        </div>
                    </div>

                    <!-- Filter Section (Hidden by Default) -->
                    <div class="filter-section" id="filterSection">
                        <div class="row">
                            <div class="col-lg-2 mb-2">
                                <input type="text" id="student_id" class="form-control" placeholder="Student ID">
                            </div>

                            <div class="col-lg-2 mb-2 date-range-input">
                                <input type="text" class="datepicker-here form-control digits" data-multiple-dates="3"
                                    data-multiple-dates-separator=", "data-language="en" id="processed_by_center"
                                    placeholder="Process Date Range">
                                <button type="button" class="clear-date" data-target="processed_by_center">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>

                            <div class="col-lg-2 mb-2 date-range-input">
                                <input type="text" class="datepicker-here form-control digits" data-multiple-dates="3"
                                    data-multiple-dates-separator=", "data-language="en" id="payment_received"
                                    placeholder="Payment Date Range">
                                <button type="button" class="clear-date" data-target="payment_received">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>

                            <div class="col-lg-2 mb-2 date-range-input">
                                <input type="text" class="datepicker-here form-control digits" data-multiple-dates="3"
                                    data-multiple-dates-separator=", "data-language="en" id="document_received"
                                    placeholder="Document Date Range">
                                <button type="button" class="clear-date" data-target="document_received">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>

                            <div class="col-lg-2 mb-2">
                                <select id="courses" class="form-control select2">
                                    <option value="">All Courses</option>
                                </select>
                            </div>

                            <div class="col-lg-2 mb-2">
                                <select id="users" class="form-control select2">
                                    <option value="">All Users</option>
                                </select>
                            </div>

                            <div class="col-lg-12 text-end">
                                <button id="apply-filters" class="btn btn-success btn-sm">
                                    <i class="fa fa-check"></i> Apply Filters
                                </button>
                                <button id="clear-filters" class="btn btn-danger btn-sm ms-2">
                                    <i class="fa fa-times"></i> Clear Filters
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="students-table" class="table table-bordered table-striped w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Student ID</th>
                                    <th>Enrollment</th>
                                    <th>Name</th>
                                    <th>Father</th>
                                    <th>Email</th>
                                    <th>Contact</th>
                                    <th>Process Date</th>
                                    <th>Payment Date</th>
                                    <th>Document Date</th>
                                    <th>User</th>
                                    <th>Course</th>
                                    <th>Specialization</th>
                                    <th>Address</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker@3.1/daterangepicker.min.js"></script>

    <script>
        let studentsTable;
       const uni_id = "{{ session('uni_id') }}";


        $(document).ready(function() {
            /* =============================
               TOGGLE FILTER SECTION
            ============================= */
            $('#toggle-filters').on('click', function() {
                $('#filterSection').toggleClass('show');
                if ($('#filterSection').hasClass('show')) {
                    $(this).html('<i class="fa fa-filter"></i> Hide Filters');
                } else {
                    $(this).html('<i class="fa fa-filter"></i> Show Filters');
                }
            });

            /* =============================
               INITIALIZE DATE RANGE PICKERS
            ============================= */
            function initDateRangePickers() {
                // Common options for all date range pickers
                const commonOptions = {
                    autoUpdateInput: false,
                    locale: {
                        cancelLabel: 'Clear',
                        format: 'YYYY-MM-DD',
                        separator: ' to ',
                        applyLabel: 'Apply',
                        cancelLabel: 'Clear',
                        fromLabel: 'From',
                        toLabel: 'To',
                        customRangeLabel: 'Custom',
                        weekLabel: 'W',
                        daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                        monthNames: [
                            'January', 'February', 'March', 'April', 'May', 'June',
                            'July', 'August', 'September', 'October', 'November', 'December'
                        ],
                        firstDay: 1
                    },
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                            'month').endOf('month')]
                    },
                    alwaysShowCalendars: true,
                    showDropdowns: true,
                    autoApply: true,
                };
                // Clear button functionality for date range pickers
                $('.clear-date').on('click', function() {
                    const target = $(this).data('target');
                    $('#' + target).val('');
                    $(this).hide();
                    applyFilters();
                });

                // Show/hide clear button based on input value
                $('#processed_by_center, #payment_received, #document_received').on('change', function() {
                    const clearBtn = $('.clear-date[data-target="' + $(this).attr('id') + '"]');
                    if ($(this).val()) {
                        clearBtn.show();
                    } else {
                        clearBtn.hide();
                    }
                });
            }

            /* =============================
               LOAD FILTER OPTIONS FROM LOCALSTORAGE
            ============================= */
            function loadFilterOptions() {
                try {
                    const stored = localStorage.getItem('filters_students');
                    if (!stored) {
                        console.log('No filter data found in localStorage');
                        return;
                    }

                    const parsedData = JSON.parse(stored);
                    let filters = parsedData?.data?.students || parsedData?.students || parsedData;

                    if (!filters) {
                        console.error('No filters found in data');
                        return;
                    }

                    // Load Courses
                    const coursesSelect = $('#courses');
                    coursesSelect.empty().append('<option value="">All Courses</option>');

                    if (filters.courses && Array.isArray(filters.courses)) {
                        filters.courses.forEach(course => {
                            const courseId = course.ID || course.id || '';
                            const courseName = course.Name || course.CourseName || '';

                            if (courseId && courseName) {
                                coursesSelect.append(
                                    `<option value="${courseId}">${courseName}</option>`
                                );
                            }
                        });
                    }

                    coursesSelect.select2({
                        placeholder: 'Select Course',
                        allowClear: true,
                        width: '100%'
                    });

                    // Load Users
                    const usersSelect = $('#users');
                    usersSelect.empty().append('<option value="">All Users</option>');

                    if (filters.users && Array.isArray(filters.users)) {
                        filters.users.forEach(user => {
                            const userId = user.ID || user.id || '';
                            const userName = user.Name || user.user_name || '';

                            if (userId && userName) {
                                usersSelect.append(
                                    `<option value="${userId}">${userName}</option>`
                                );
                            }
                        });
                    }

                    usersSelect.select2({
                        placeholder: 'Select User',
                        allowClear: true,
                        width: '100%'
                    });

                } catch (error) {
                    console.error('Error loading filter data:', error);
                }
            }

            /* =============================
               DATATABLE INITIALIZATION
            ============================= */
            studentsTable = $('#students-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength: 25,
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                ajax: {
                    url: `/services/students/${uni_id}`,
                    type: "GET",
                    data: function(d) {
                        // Parse date range strings
                        const processDate = $('#processed_by_center').val();
                        const paymentDate = $('#payment_received').val();
                        const documentDate = $('#document_received').val();

                        let processStart = '',
                            processEnd = '';
                        let paymentStart = '',
                            paymentEnd = '';
                        let documentStart = '',
                            documentEnd = '';

                        if (processDate && processDate.includes(',')) {
                            const parts = processDate.split(',').map(v => v.trim());
                            processStart = parts[0] || '';
                            processEnd = parts[1] || '';
                        }

                        if (paymentDate && paymentDate.includes(',')) {
                            const parts = paymentDate.split(',').map(v => v.trim());
                            paymentStart = parts[0] || '';
                            paymentEnd = parts[1] || '';
                        }

                        if (documentDate && documentDate.includes(',')) {
                            const parts = documentDate.split(',').map(v => v.trim());
                            documentStart = parts[0] || '';
                            documentEnd = parts[1] || '';
                        }

                        // console.log(processStart, processEnd);
                        // console.log(paymentStart, paymentEnd);
                        // console.log(documentStart, documentEnd);


                        // Send filter parameters
                        d.filters = {
                            student_id: $('#student_id').val(),
                            processed_by_center_start: processStart,
                            processed_by_center_end: processEnd,
                            payment_received_start: paymentStart,
                            payment_received_end: paymentEnd,
                            document_received_start: documentStart,
                            document_received_end: documentEnd,
                            course: $('#courses').val(),
                            user: $('#users').val()
                        };
                    },
                    error: function(xhr, error, thrown) {
                        console.error('DataTable AJAX Error:', error);
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        width: '5%'
                    },
                    {
                        data: 'Unique_ID',
                        name: 'Unique_ID',
                        width: '10%'
                    },
                    {
                        data: 'Enrollment_No',
                        name: 'Enrollment_No',
                        width: '10%'
                    },
                    {
                        data: 'Student_Name',
                        name: 'Student_Name',
                        width: '15%'
                    },
                    {
                        data: 'Father_Name',
                        name: 'Father_Name',
                        width: '10%'
                    },
                    {
                        data: 'Email',
                        name: 'Email',
                        width: '15%'
                    },
                    {
                        data: 'Contact',
                        name: 'Contact',
                        width: '10%'
                    },
                    {
                        data: 'Process_By_Center',
                        name: 'Process_By_Center',
                        width: '10%',
                        render: function(data) {
                            if (!data) return '';
                            const date = data.split(' ')[0];
                            return `<span class="badge bg-success">${date}</span>`;
                        }
                    },
                    {
                        data: 'Payment_Received',
                        name: 'Payment_Received',
                        width: '10%',
                        render: function(data) {
                            if (!data) return '';
                            const date = data.split(' ')[0];
                            return `<span class="badge bg-success">${date}</span>`;
                        }
                    },
                    {
                        data: 'Document_Verified',
                        name: 'Document_Verified',
                        width: '10%',
                        render: function(data) {
                            if (!data) return '';
                            const date = data.split(' ')[0];
                            return `<span class="badge bg-success">${date}</span>`;
                        }
                    },
                    {
                        data: 'user_name_code',
                        name: 'user_name_code',
                        width: '15%'
                    },
                    {
                        data: 'CourseName',
                        name: 'CourseName',
                        width: '15%'
                    },
                    {
                        data: 'SubCourseName',
                        name: 'SubCourseName',
                        width: '15%'
                    },
                    {
                        data: 'Address',
                        name: 'Address',
                        width: '20%'
                    },
                    {
                        data: 'Status',
                        name: 'Status',
                        width: '8%'
                    },
                    {
                        data: 'Created_At',
                        name: 'Created_At',
                        width: '10%'
                    }
                ],
                order: [
                    [2, 'desc']
                ], // Default sort by Enrollment No (column index 2)
                language: {
                    search: "Search:",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "Showing 0 to 0 of 0 entries",
                    infoFiltered: "(filtered from _MAX_ total entries)",
                    zeroRecords: "No matching records found",
                    processing: '<i class="fa fa-spinner fa-spin"></i> Loading...'
                }
            });

            /* =============================
               FILTER FUNCTIONS
            ============================= */

            // Apply Filters Button
            $('#apply-filters').on('click', function() {
                applyFilters();
            });

            // Clear Filters Button
            $('#clear-filters').on('click', function() {
                clearFilters();
            });           

            // Apply filters when date range is selected
            $('#processed_by_center, #payment_received, #document_received').on('apply.daterangepicker',
        function() {
                applyFilters();
            });

            // Apply filters function
            function applyFilters() {
                studentsTable.ajax.reload();
            }

            // Clear filters function
            function clearFilters() {
                $('#student_id').val('');

                // Clear date range pickers
                $('#processed_by_center').val('');
                $('#payment_received').val('');
                $('#document_received').val('');

                // Hide clear buttons
                $('.clear-date').hide();

                // Clear select2 dropdowns
                $('#courses').val('').trigger('change.select2');
                $('#users').val('').trigger('change.select2');

                // Apply cleared filters
                applyFilters();
            }

            // Auto-apply filters on Enter key in search fields
            $('#student_id').on('keyup', function(e) {
                if (e.keyCode === 13) { // Enter key
                    applyFilters();
                }
            });

            // Auto-apply filters when select2 changes
            $('#courses, #users').on('change', function() {
                applyFilters();
            });

            /* =============================
               INITIALIZE EVERYTHING
            ============================= */
            function init() {
                initDateRangePickers();
                loadFilterOptions();
                // Initial DataTable load
                studentsTable.ajax.reload();
            }

            // Run initialization
            init();
        });
    </script>
@endsection
