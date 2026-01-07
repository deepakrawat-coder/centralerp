@extends('layouts.main')

@section('styles')
    <style>
        /* #student-ledger-table {
                                            width: max-content !important;
                                        }

                                        #student-ledger-table thead tr th,
                                        #student-ledger-table tbody tr td {
                                            width: max-content !important;
                                        } */
        #student-ledger-table,
        .dataTables_scrollHeadInner {
            width: max-content !important;
        }

        #student-ledger-table thead tr th,
        #student-ledger-table tbody tr td {
            width: max-content !important;

        }
    </style>
@endsection

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <h3 class="mb-4">Student Ledger</h3>

                    {{-- <div class="table-responsive">
                        <table id="student-ledger-table" class="display table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Student ID</th>
                                    <th>Student Name</th>
                                    <th>Father Name</th>
                                    <th>Duration</th>
                                    <th>Type</th>
                                    <th>Fee</th>
                                    <th>Fee (Without Sharing)</th>
                                    <th>Center Fee</th>
                                    <th>Settlement Amount</th>
                                    <th>Status</th>
                                    <th>Added For</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div> --}}
                    <div class="table-responsive">
                        <table id="student-ledger-table" class="display  table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>

                                    <th>Student ID</th>
                                    <th>Student Name</th>
                                    <th>Father Name</th>
                                    <th>Duration</th>
                                    <th>Transaction Date</th>
                                    <th>Transaction ID</th>
                                    <th>Type</th>
                                    <th>Source</th>
                                    <th>Fee</th>
                                    <th>Center Fee</th>
                                    <th>Settlement Amount</th>

                                    <th>Added For</th>
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

    <script>
        $(document).ready(function() {

            const table = $('#student-ledger-table').DataTable({
                data: @json($studentLedgers),
                pageLength: 25,
                responsive: false,
                scrollX: true,
                autoWidth: false,
                ordering: true,
                // order: [[5, 'desc']], // Date column

                columns: [{
                        data: null,
                        width: '5%'
                    },

                    {
                        data: 'Unique_ID',
                        width: '12%',
                        defaultContent: '—'
                    },

                    {
                        data: 'StudentName',
                        width: '25%',
                        defaultContent: '—'
                    },

                    {
                        data: 'Father_Name',
                        width: '20%',
                        defaultContent: '—'
                    },

                    {
                        data: 'Duration',
                        width: '10%',
                        defaultContent: '—'
                    },

                    {
                        data: 'Date',
                        width: '12%',
                        render: function(date) {
                            return date ? new Date(date).toLocaleDateString('en-GB') : '—';
                        }
                    },

                    {
                        data: 'Transaction_ID',
                        width: '12%',
                        render: function(transactionID) {
                            return transactionID ? `<p>${transactionID}</p>` : '';
                        }
                    },

                    {
                        data: 'Type',
                        width: '8%',
                        render: function(type) {
                            return type == 1 ?
                                '<span class="badge bg-primary">Debit</span>' :
                                '<span class="badge bg-danger">Credit</span>';
                        }
                    },

                    {
                        data: 'Source',
                        width: '12%',
                        render: function(source) {
                            if (!source) return '—';

                            switch (source) {
                                case 'Offline':
                                    return '<span class="badge bg-secondary text-white">Offline</span>';

                                case 'Online':
                                    return '<span class="badge bg-info text-white">Online</span>';

                                case 'Wallet':
                                    return '<span class="badge bg-warning text-white">Wallet</span>';

                                case 'Registration Fee':
                                    return '<span class="badge bg-primary text-white">Registration Fee</span>';

                                case 'Late Fee':
                                    return '<span class="badge bg-danger text-white">Late Fee</span>';

                                default:
                                    return `<span class="badge bg-dark text-white">${source}</span>`;
                            }
                        }
                    },
                    {
                        data: null,
                        width: '12%',
                        render: function(row) {

                            // 🔥 Decide source
                            let rawValue = (row.Type == 1) ? row.Fee : row.Amount;

                            if (rawValue === null || rawValue === '') {
                                return '';
                            }

                            // 🔍 If JSON string → convert to readable string
                            if (typeof rawValue === 'string') {
                                try {
                                    const parsed = JSON.parse(rawValue);

                                    // If JSON is array/object → join values
                                    if (typeof parsed === 'object') {
                                        return Object.values(parsed)
                                            .map(val =>
                                                `₹${parseFloat(val).toLocaleString('en-IN')}`)
                                            .join('<br>');
                                    }
                                } catch (e) {
                                    // Not JSON → continue as normal string
                                }
                            }

                            // 💰 Normal number handling
                            if (!isNaN(rawValue)) {
                                return `₹${parseFloat(rawValue).toLocaleString('en-IN')}`;
                            }

                            return '';
                        }
                    },



                    {
                        data: 'Center_Fee',
                        width: '14%',
                        render: function(fee) {
                            return fee && !isNaN(fee) ?
                                `₹${parseFloat(fee).toLocaleString('en-IN')}` :
                                '—';
                        }
                    },

                    {
                        data: 'Settlement_Amount',
                        width: '14%',
                        render: function(amt) {
                            return amt && !isNaN(amt) ?
                                `₹${parseFloat(amt).toLocaleString('en-IN')}` :
                                '—';
                        }
                    },



                    {
                        data: 'Added_For_User',
                        width: '25%',
                        defaultContent: '—'
                    },

                    {
                        data: 'Created_At',
                        width: '15%',
                        render: function(date) {
                            return date ? new Date(date).toLocaleString('en-GB') : '—';
                        }
                    }
                ],

                language: {
                    search: "Search ledger:",
                    lengthMenu: "Show _MENU_ records"
                }
            });

            // 🔢 Auto serial number (search / sort / pagination safe)
            table.on('order.dt search.dt draw.dt', function() {
                table.column(0, {
                        search: 'applied',
                        order: 'applied'
                    })
                    .nodes()
                    .each(function(cell, i) {
                        cell.innerHTML = i + 1;
                    });
            }).draw();

        });
    </script>
@endsection
