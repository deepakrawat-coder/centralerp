@extends('layouts.main')
@section('styles')
<style>
    #wallets-table{
        width: max-content !important;
    }
    #wallets-table thead tr th,#wallets-table tbody tr td{
        width:max-content !important;
           
    }
</style>
@endsection
@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h3 class="mb-4">Wallet Transactions</h3>

                <div class="table-responsive">
                    <table id="wallets-table" class="display  table table-bordered">
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

<script>
$(document).ready(function () {

    const liveURL = "<?= session('live_url') ?>";

    const table = $('#wallets-table').DataTable({
        data: @json($wallets),
        pageLength: 25,
        responsive: true,
        ordering: true,
        // order: [[2, 'desc']], // Transaction Date
        columns: [
            { data: null, width: '3%' }, // Serial

            {
                data: 'Type',width:'10%',
                render: function (type) {
                    return type == 1
                        ? '<span class="badge bg-primary">Offline</span>'
                        : '<span class="badge bg-warning text-dark">Wallet</span>';
                }
            },

            {
                data: 'Transaction_Date',width:'10%',
                render: function (date) {
                    return date ? new Date(date).toLocaleDateString('en-GB') : '—';
                }
            },

            { data: 'Transaction_ID',width:'15%' },
            { data: 'Gateway_ID', defaultContent: '—',width:'15%' },
            { data: 'Bank', defaultContent: '—' ,width:'25%'},
            { data: 'Payment_Mode', defaultContent: '—',width:'10%' },

            {
                data: 'Amount',width:'15%',
                render: function (amt) {
                    return `<strong>₹${parseFloat(amt).toLocaleString('en-IN')}</strong>`;
                }
            },

            { data: 'Added_for_User', defaultContent: '—',width:'35%' },
            { data: 'Approved_By_User', defaultContent: '—',width:'35%' },

            {
                data: 'Approved_On',width:'15%',
                render: function (date) {
                    return date ? new Date(date).toLocaleString('en-GB') : '—';
                }
            },

            {
                data: 'File',width:'10%',
                orderable: false,
                searchable: false,
                render: function (file) {
                    if (!file) return '<span class="text-muted">N/A</span>';
                    return `<a href="${liveURL}${file}" target="_blank" class="btn btn-sm btn-outline-primary">View</a>`;
                }
            },

            { data: 'University_Name',width:'10%' },

            {
                data: 'Created_At',width:'15%',
                render: function (date) {
                    return new Date(date).toLocaleString('en-GB');
                }
            }
        ],
        language: {
            search: "Search wallet:",
            lengthMenu: "Show _MENU_ records"
        }
    });

    // 🔢 Auto Serial Number (search/sort/pagination safe)
    table.on('order.dt search.dt draw.dt', function () {
        table.column(0, { search: 'applied', order: 'applied' })
            .nodes()
            .each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
    }).draw();

});
</script>
@endsection
