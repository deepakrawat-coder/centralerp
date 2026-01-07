@extends('layouts.main')
@section('styles')
    <style>
        #users-table {
            width: max-content !important;
        }

        #users-table thead tr th,
        #wallets-table tbody tr td {
            width: max-content !important;

        }
    </style>
@endsection
@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <h3 class="mb-4">Users List</h3>

                    <div class="table-responsive">
                        <table id="users-table" class="display w-100 table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Student Image</th>
                                    <th>User Name</th>

                                    <th>Short Name</th>
                                    <th>Email</th>
                                    <th>Contact</th>
                                    <th>Designation</th>
                                    <th>Students Admission </th>
                                    <th>Address</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody></tbody> {{-- EMPTY --}}
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

            const table = $('#users-table').DataTable({
                data: @json($users), // backend users array
                pageLength: 25,
                responsive: true,
                ordering: true,
                // order: [
                //     [1, 'asc']
                // ], // order by Name (NOT serial)
                columns: [{
                        data: null,
                        width: '5%',
                    }, // 🔢 Serial Number
                    {
                        data: 'Photo',
                        width: '10%',
                        orderable: false,
                        searchable: false,
                        render: function(photo) {
                            if (!photo) {
                                return '<span class="text-muted">N/A</span>';
                            }
                            let liveURL = '<?= session('live_url') ?>';
                            return `
                        <img src="${liveURL}${photo}" 
                             alt="User Image" 
                             width="50" 
                             height="50" 
                             style="object-fit:cover;border-radius:6px;">
                    `;
                        }
                    },
                    {
                        data: 'Name',
                        width: '60%',
                    },



                    {
                        data: 'Short_Name',
                        width: '20%',
                    },
                    {
                        data: 'Email',
                        width: '20%',
                    },
                    {
                        data: 'Mobile',
                        width: '10%',
                    },
                    {
                        data: 'Designation',
                        width: '5%',
                    },
                    {
                        data: 'Admissions',
                        width: '5%',
                    },

                    {
                        data: null,
                        width: '60%',
                        render: function(row) {
                            return `
                        ${row.Address ?? ''} 
                        ${row.District ?? ''} 
                        ${row.State ?? ''} 
                        ${row.Pincode ?? ''}
                    `.trim();
                        }
                    },

                    {
                        data: 'Status',
                        width: '10%',
                        render: function(status) {
                            return status == 1 ?
                                '<span class="badge bg-success">Active</span>' :
                                '<span class="badge bg-danger">Inactive</span>';
                        }
                    },

                    {
                        data: 'Created_At',
                        width: '15%',
                        render: function(date) {
                            return date ?
                                new Date(date).toLocaleDateString('en-GB') :
                                '';
                        }
                    }
                ],
                language: {
                    search: "Search users:",
                    lengthMenu: "Show _MENU_ users"
                }
            });

            // 🔥 SERIAL NUMBER (Pure JS – works with search, sort & pagination)
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
