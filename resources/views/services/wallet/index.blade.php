@extends('layouts.main')

@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">

    <style>
        #wallets-table {
            width: max-content !important;
        }

        #wallets-table th,
        #wallets-table td {
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
@endsection

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="mb-0">Wallet Transactions</h3>
                        <div class="d-flex flex-row">
                            <button id="toggle-filters" class="btn btn-primary btn-sm">
                                <i class="fa fa-filter"></i> Show Filters
                            </button>
                            <button class="border-0 shadow-none bg-white fs-3 text-success"><i class="ri-file-excel-2-fill"
                                    onclick="excelData('wallet','{{ session('uni_id') }}','{{ session('live_url') }}')"></i></button>
                        </div>
                    </div>

                    {{-- FILTERS --}}
                    <div class="filter-section" id="filterSection">
                        <div class="row align-items-end">

                            <div class="col-lg-3 mb-2">
                                <input ype="text" class="datepicker-here form-control digits" data-multiple-dates="3"
                                    data-multiple-dates-separator=", "data-language="en" id="transaction_date"
                                    placeholder="Transaction Date (From , To)">
                            </div>

                            <div class="col-lg-2 mb-2">
                                <select id="transaction_type" class="form-control">
                                    <option value="">All Type</option>
                                </select>
                            </div>

                            <div class="col-lg-3 mb-2">
                                <input type="text" id="transaction_id" class="form-control" placeholder="Transaction ID">
                            </div>

                            <div class="col-lg-4 text-end mb-2">
                                <button id="apply-wallet-filters" class="btn btn-success btn-sm">
                                    Apply
                                </button>

                                <button id="clear-wallet-filters" class="btn btn-danger btn-sm ms-2">
                                    Clear
                                </button>
                            </div>

                        </div>
                    </div>

                    {{-- TABLE --}}
                    <div class="table-responsive">
                        <table id="wallets-table" class="display table table-bordered w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Type</th>
                                    <th>Transaction Date</th>
                                    <th>Transaction ID</th>
                                    <th>Gateway ID</th>
                                    <th>Bank</th>
                                    <th>Payment Mode</th>
                                    <th>Amount</th>
                                    <th>Added By</th>
                                    <th>Approved By</th>
                                    <th>Approved On</th>
                                    <th>Payment Proof</th>
                                    <th>University</th>
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

    <script>
        $(document).ready(function() {

            const liveURL = "{{ session('live_url') }}";
            const uni_id = "{{ session('uni_id') }}";

            // =========================
            // Load Type from localStorage
            // =========================
            // function loadWalletTypeFilter() {

            //     const stored = localStorage.getItem('filters_wallet');
            //     if (!stored) return;

            //     const parsed = JSON.parse(stored);
            //     const list = parsed.walletFilter || [];

            //     const $select = $('#transaction_type');
            //     $select.html('<option value="">All Type</option>');

            //     // avoid duplicate options
            //     const added = new Set();

            //     list.forEach(item => {
            //         const type = item.Type;

            //         if (added.has(type)) return;
            //         added.add(type);

            //         let label = '';
            //         if (type == 1) label = 'Online';
            //         else if (type == 2) label = 'Offline';
            //         else label = 'Unknown';

            //         $select.append(
            //             `<option value="${type}">${label}</option>`
            //         );
            //     });
            // }
            // loadWalletTypeFilter();

            function loadWalletTypeFilter() {

                const stored = localStorage.getItem('filters_wallet');
                if (!stored) return;

                const parsed = JSON.parse(stored);
                const list = parsed.walletFilter || [];

                const $select = $('#transaction_type');
                $select.html('<option value="">All Type</option>');

                // avoid duplicate options
                const added = new Set();

                list.forEach(item => {
                    const type = item.Type;

                    if (!type || added.has(type)) return;
                    added.add(type);

                    let label = 'Unknown';

                    if (type == 1) label = 'Offline'; // ✅ fixed
                    else if (type == 2) label = 'Online'; // ✅ fixed

                    $select.append(
                        `<option value="${type}">${label}</option>`
                    );
                });
            }

            loadWalletTypeFilter();


            // =========================
            // Toggle Filters
            // =========================
            $('#toggle-filters').on('click', function() {
                $('#filterSection').toggleClass('show');
                $(this).html($('#filterSection').hasClass('show') ?
                    '<i class="fa fa-filter"></i> Hide Filters' :
                    '<i class="fa fa-filter"></i> Show Filters');
            });

            // =========================
            // DataTable
            // =========================
            let table = $('#wallets-table').DataTable({
                processing: true,
                serverSide: true,


                ajax: {
                    url: `/services/wallet/${uni_id}`,
                    type: "GET",
                    data: function(d) {

                        // let range = $('#transaction_date').val() || '';
                        // let start = '',
                        //     end = '';

                        // if (range.includes(',')) {
                        //     let parts = range.split(',').map(v => v.trim());
                        //     start = parts[0] || '';
                        //     end = parts[1] || '';
                        // }

                        // d.filters = {
                        //     transaction_start: start,
                        //     transaction_end: end,
                        //     transaction_type: $('#transaction_type').val(),
                        //     transaction_id: $('#transaction_id').val()
                        // };
                        let range = $('#transaction_date').val() || '';
                        let start = '',
                            end = '';

                        if (range) {
                            let parts = range.includes(',') ?
                                range.split(',') :
                                range.includes(' - ') ?
                                range.split(' - ') : [range]; // ✅ single date

                            parts = parts.map(v => v.trim());

                            start = parts[0] || '';
                            end = parts[1] || '';
                        }

                        d.filters = {
                            transaction_start: start,
                            transaction_end: end,
                            transaction_type: $('#transaction_type').val(),
                            transaction_id: $('#transaction_id').val()
                        };

                    }
                },

                columns: [{
                        data: null,
                        orderable: false,
                        searchable: false
                    },

                    // {
                    //     data: 'Type',
                    //     render: t => t == 1 ?
                    //         '<span class="badge bg-success">Online</span>' :
                    //         '<span class="badge bg-secondary">Offline</span>'
                    // },
                    {
                        data: 'Type',

                    },

                    {
                        data: 'Transaction_Date',
                        render: d => d ? new Date(d).toLocaleDateString('en-GB') : '—'
                    },

                    {
                        data: 'Transaction_ID'
                    },
                    {
                        data: 'Gateway_ID',
                        defaultContent: '—'
                    },
                    {
                        data: 'Bank',
                        defaultContent: '—'
                    },
                    {
                        data: 'Payment_Mode',
                        defaultContent: '—'
                    },

                    {
                        data: 'Amount',
                        render: a => `<strong>₹${parseFloat(a).toLocaleString('en-IN')}</strong>`
                    },

                    {
                        data: 'Added_for_User',
                        defaultContent: '—'
                    },
                    {
                        data: 'Approved_By_User',
                        defaultContent: '—'
                    },

                    {
                        data: 'Approved_On',
                        render: d => d ? new Date(d).toLocaleString('en-GB') : '—'
                    },

                    {
                        data: 'File',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            // console.log(data);
                            // normalize value
                            if (
                                data === null ||
                                data === undefined ||
                                data === '' ||
                                data === 'null' ||
                                data === 'NULL'
                            ) {
                                return '<span class="text-muted">N/A</span>';
                            }

                            return `<a href="${data}" target="_blank"
                class="btn btn-sm btn-outline-primary">View</a>`;
                        }
                    },

                    {
                        data: 'University_Name'
                    },

                    {
                        data: 'Created_At',
                        render: d => new Date(d).toLocaleString('en-GB')
                    }
                ]
            });

            // =========================
            // Serial Number
            // =========================
            table.on('draw.dt', function() {
                let info = table.page.info();
                table.column(0, {
                        page: 'current'
                    })
                    .nodes()
                    .each((cell, i) => cell.innerHTML = info.start + i + 1);
            });

            // =========================
            // Filter Actions
            // =========================
            $('#apply-wallet-filters').on('click', () => table.ajax.reload());
            $('#transaction_type').on('change', () => table.ajax.reload());

            $('#clear-wallet-filters').on('click', function() {
                $('#transaction_date').val('');
                $('#transaction_type').val('');
                $('#transaction_id').val('');
                table.ajax.reload();
            });

        });
    </script>
@endsection
