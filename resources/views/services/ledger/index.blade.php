@extends('layouts.main')

@section('styles')
    <style>
        #student-ledger-table,
        .dataTables_scrollHeadInner {
            width: max-content !important;
        }

        #student-ledger-table thead tr th,
        #student-ledger-table tbody tr td {
            width: max-content !important;
            white-space: nowrap;
        }

        .filter-section {
            display: none;
            margin-bottom: 15px;
        }

        .filter-section.show {
            display: block;
        }
    </style>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">

                    {{-- HEADER --}}
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="mb-0">Student Ledger</h3>
                        <button id="toggle-filters" class="btn btn-primary btn-sm">
                            <i class="fa fa-filter"></i> Show Filters
                        </button>
                    </div>

                    {{-- ================= FILTER SECTION ================= --}}
                    <div class="filter-section" id="filterSection">
                        <div class="row align-items-end">

                            <div class="col-lg-3 mb-2">
                                <input type="text" class="datepicker-here form-control digits" data-multiple-dates="3"
                                    data-multiple-dates-separator=", "data-language="en" id="transaction_date"
                                    placeholder="Transaction Date Range">
                            </div>

                            <div class="col-lg-3 mb-2">
                                <input type="text" id="transaction_id" class="form-control" placeholder="Transaction ID">
                            </div>

                            <div class="col-lg-4 mb-2">
                                <select id="course_id" class="form-control">
                                    <option value="">Search Course</option>
                                </select>
                            </div>

                            <div class="col-lg-2 mb-2 text-end">
                                <button id="apply-ledger-filters" class="btn btn-success btn-sm">
                                    <i class="fa fa-check"></i> Apply
                                </button>
                                <button id="clear-ledger-filters" class="btn btn-danger btn-sm ms-2">
                                    <i class="fa fa-times"></i> Clear
                                </button>
                            </div>

                        </div>
                    </div>

                    {{-- ================= TABLE ================= --}}
                    <div class="table-responsive">
                        <table id="student-ledger-table" class="display table table-bordered w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Student ID</th>
                                    <th>Student Name</th>
                                    <th>Email</th>
                                    <th>Contact</th>
                                    <th>Duration</th>
                                    <th>Transaction Date</th>
                                    <th>Transaction ID</th>
                                    <th>Payment Type</th>
                                    <th>Fee Amount</th>
                                    <th>Settlement Amount</th>
                                    <th>Final Amount</th>
                                    <th>Center</th>
                                    <th>Created At</th>
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

    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {

            const uni_id = "{{ session('uni_id') }}";

            // =============================
            // Toggle Filters
            // =============================
            $('#toggle-filters').on('click', function() {
                $('#filterSection').toggleClass('show');
                $(this).html($('#filterSection').hasClass('show') ?
                    '<i class="fa fa-filter"></i> Hide Filters' :
                    '<i class="fa fa-filter"></i> Show Filters');
            });

            // // =============================
            // // Date Range Picker
            // // =============================
            // $('#transaction_date').daterangepicker({
            //     autoUpdateInput: false,
            //     locale: {
            //         format: 'YYYY-MM-DD',
            //         cancelLabel: 'Clear'
            //     }
            // });

            // $('#transaction_date').on('apply.daterangepicker', function(ev, picker) {
            //     $(this).val(
            //         picker.startDate.format('YYYY-MM-DD') +
            //         ', ' +
            //         picker.endDate.format('YYYY-MM-DD')
            //     );
            // });

            // $('#transaction_date').on('cancel.daterangepicker', function() {
            //     $(this).val('');
            // });

            // =============================
            // Load Course Dropdown (localStorage)
            // =============================
            // function loadLedgerCourseFilter() {

            //     const stored = localStorage.getItem('ledgers');
            //     if (!stored) return;

            //     const parsed = JSON.parse(stored);
            //     const list = parsed.ledgersUsers || [];

            //     const $select = $('#course_id');
            //     $select.html('<option value="">Search Course</option>');

            //     const added = new Set();

            //     list.forEach(item => {
            //         if (!item.Course_ID || added.has(item.Course_ID)) return;
            //         added.add(item.Course_ID);

            //         $select.append(
            //             `<option value="${item.Course_ID}">
        //         ${item.Course_Name ?? 'Unknown Course'}
        //     </option>`
            //         );
            //     });

            //     $select.select2({
            //         placeholder: 'Search Course',
            //         allowClear: true,
            //         width: '100%'
            //     });
            // }
            function loadLedgerUserFilter() {

                const stored = localStorage.getItem('ledgers');
                if (!stored) return;

                const parsed = JSON.parse(stored);
                const list = parsed.ledgersUsers || [];

                const $select = $('#course_id'); // (ID can stay same if backend expects it)
                $select.html('<option value="">Search User</option>');

                const added = new Set();

                list.forEach(item => {
                    if (!item.ID || added.has(item.ID)) return;

                    added.add(item.ID);

                    $select.append(`
            <option value="${item.ID}">
                ${item.Name ?? 'Unknown User'}
            </option>
        `);
                });

                $select.select2({
                    placeholder: 'Search User',
                    allowClear: true,
                    width: '100%'
                });
            }


            loadLedgerUserFilter();

            // =============================
            // DataTable
            // =============================
            let table = $('#student-ledger-table').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,


                ajax: {
                    url: `/services/ledger/${uni_id}`,
                    type: "GET",
                    data: function(d) {

                        // let range = $('#transaction_date').val() || '';
                        // let start = '',
                        //     end = '';

                        // if (range.includes(',')) {
                        //     let parts = range.split(',').map(v => v.trim());
                        //     start = parts[0];
                        //     end = parts[1];
                        // }

                        // d.filters = {
                        //     transaction_start: start,
                        //     transaction_end: end,
                        //     transaction_id: $('#transaction_id').val(),
                        //     course_id: $('#course_id').val()
                        // };
                        let range = $('#transaction_date').val() || '';
                        let start = '',
                            end = '';

                        if (range) {
                            if (range.includes(',')) {
                                // date range selected
                                let parts = range.split(',').map(v => v.trim());
                                start = parts[0] || '';
                                end = parts[1] || parts[0]; // safety
                            } else {
                                // single date selected
                                start = range.trim();

                            }
                        }

                        d.filters = {
                            transaction_start: start,
                            transaction_end: end,
                            transaction_id: $('#transaction_id').val(),
                            users_id: $('#course_id').val()
                        };

                    }
                },

                columns: [
                    // {
                    //     data: null,
                    // }
                    {
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'Unique_ID'
                    },
                    {
                        data: 'StudentName'
                    },
                    {
                        data: 'Email',
                        defaultContent: '—'
                    },
                    {
                        data: 'Contact',
                        defaultContent: '—'
                    },
                    {
                        data: 'Duration',
                        defaultContent: '—'
                    },

                    {
                        data: 'Date',
                        render: d => d ? new Date(d).toLocaleDateString('en-GB') : '—'
                    },

                    {
                        data: 'Transaction_ID',
                        defaultContent: '—'
                    },

                    {
                        data: 'PaymentType',
                        render: function(type) {
                            if (type === 'Course Fee')
                                return '<span class="badge bg-primary">Course Fee</span>';
                            if (type === 'Offline Student Fee')
                                return '<span class="badge bg-secondary">Offline</span>';
                            if (type === 'Wallet Payment')
                                return '<span class="badge bg-warning text-dark">Wallet</span>';
                            return '<span class="badge bg-dark">Unknown</span>';
                        }
                    },

                    // {
                    //     data: 'Fee',
                    //     render: function(v, type, row) {

                    //         if (v == null || v === '') return '—';

                    //         // Wallet Payment (JSON)
                    //         if (row.PaymentType === 'Wallet Payment' && typeof v === 'string') {
                    //             try {
                    //                 const parsed = JSON.parse(
                    //                     v.includes('&quot;') ? v.replace(/&quot;/g, '"')
                    //                     .replace(/&#39;/g, "'") : v
                    //                 );

                    //                 return (parsed?.Paid !== undefined && !isNaN(parsed.Paid)) ?
                    //                     `₹${Math.abs(+parsed.Paid).toLocaleString('en-IN')}` :
                    //                     '—';
                    //             } catch {
                    //                 return '—';
                    //             }
                    //         }

                    //         // Normal numeric fee
                    //         return !isNaN(v) ?
                    //             `₹${(+v).toLocaleString('en-IN')}` :
                    //             '—';
                    //     }
                    // },
                    {
                        data: 'Fee',
                        
                    },
                    {
                        data: 'Settlement_Amount',
                        render: v => v ? `₹${parseFloat(v).toLocaleString('en-IN')}` : '—'
                    },
                    {
                        data: 'Amount',
                        render: v => v ? `₹${parseFloat(v).toLocaleString('en-IN')}` : '—'
                    },
                    {
                        data: 'CenterName'
                    },

                    {
                        data: 'Created_At',
                        render: d => d ? new Date(d).toLocaleString('en-GB') : '—'
                    }
                ],

                language: {
                    search: "Search Ledger:",
                    lengthMenu: "Show _MENU_ records"
                }
            });

            // =============================
            // Serial Number (pagination-safe)
            // =============================
            table.on('draw.dt', function() {
                let info = table.page.info();
                table.column(0, {
                    page: 'current'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = info.start + i + 1;
                });
            });

            // =============================
            // Filter Actions
            // =============================
            $('#apply-ledger-filters').on('click', () => table.ajax.reload());

            $('#clear-ledger-filters').on('click', function() {
                $('#transaction_date').val('');
                $('#transaction_id').val('');
                $('#course_id').val('').trigger('change');
                table.ajax.reload();
            });

        });
    </script>
@endsection
