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
    </style>
@endsection

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <h3 class="mb-4">Student Ledger</h3>

                    <div class="table-responsive">
                        <table id="student-ledger-table" class="display table table-bordered">
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

    <script>
        $(document).ready(function() {
            const uni_id = "{{ session('uni_id') }}";
            const table = $('#student-ledger-table').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                autoWidth: false,
                pageLength: 25,

                ajax: {
                    url: `/services/ledger/{{ session('uni_id') }}`,
                    type: "GET"
                },

                columns: [{
                        data: null
                    },

                    {
                        data: 'Student_ID'
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
                        render: d => d ? d : '—'
                    },

                    {
                        data: 'PaymentType',
                        render: function(type) {
                            switch (type) {
                                case 'Course Fee':
                                    return '<span class="badge bg-primary">Course Fee</span>';
                                case 'Offline Student Fee':
                                    return '<span class="badge bg-secondary">Offline</span>';
                                case 'Wallet Payment':
                                    return '<span class="badge bg-warning text-dark">Wallet</span>';
                                default:
                                    return '<span class="badge bg-dark">Unknown</span>';
                            }
                        }
                    },

                    {
                        data: 'Fee',
                        render: function(v, type, row) {

                            // Type 1 → normal course fee
                            if (row.Type == 1) {
                                return v ?
                                    `₹${parseFloat(v).toLocaleString('en-IN')}` :
                                    '—';
                            }

                            // Type 2 & 3 → JSON like {"Paid":-5000}
                            if (row.Type == 2 || row.Type == 3) {
                                if (!v) return '—';

                                try {
                                    const parsed = JSON.parse(v);

                                    if (parsed.Paid !== undefined) {
                                        return `₹${Math.abs(parsed.Paid).toLocaleString('en-IN')}`;
                                    }
                                } catch (e) {
                                    return '—';
                                }
                            }

                            return '—';
                        }
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

            // 🔢 Auto serial number
            table.on('order.dt search.dt draw.dt', function() {
                table.column(0).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();
        });
    </script>
@endsection
