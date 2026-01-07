@extends('layouts.main')
@section('styles')
    <style>
        #students-table {
            width: max-content !important;
        }

        #students-table thead tr th,
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
                    <h3 class="mb-4">Students List</h3>

                    <div class="table-responsive">
                        <table id="students-table" class="display w-100 table table-bordered table-responsive">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Enrollment No</th>
                                    <th>Name</th>
                                    <th>Father Name</th>
                                    <th>Email</th>
                                    <th>Contact</th>
                                    <th>Course</th>
                                    <th>Sub Course</th>
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

    {{-- <script>
    // PHP → JS
    const studentsData = @json($students);

    $(document).ready(function () {
        $('#students-table').DataTable({
            data: studentsData,
            pageLength: 25,
            responsive: true,
            order: [[0, 'desc']],
            columns: [
                {
                    data: null,
                    render: function (data, type, row, meta) {
                        return meta.row + 1 + meta.settings._iDisplayStart;
                    }
                },
                { data: 'Enrollment_No' },
                {
                    data: null,
                    render: row =>
                        `${row.First_Name ?? ''} ${row.Middle_Name ?? ''} ${row.Last_Name ?? ''}`.trim()
                },
                { data: 'Father_Name' },
                { data: 'Email' },
                { data: 'Contact' },
                { data: 'Course_ID' },
                {
                    data: 'Status',
                    render: status =>
                        status == 1
                            ? '<span class="badge bg-success">Active</span>'
                            : '<span class="badge bg-danger">Inactive</span>'
                },
                {
                    data: 'Created_At',
                    render: date =>
                        date ? new Date(date).toLocaleDateString('en-GB') : ''
                }
            ],
            language: {
                search: "Search students:",
                lengthMenu: "Show _MENU_ students"
            }
        });
    });
</script> --}}
    <script>
        $(document).ready(function() {
            const table = $('#students-table').DataTable({
                data: @json($students), // only for table data, NOT for serial
                pageLength: 25,
                responsive: true,
                ordering: true,
                // order: [
                //     [1, 'desc']
                // ], // order by Enrollment_No (NOT serial)
                columns: [{
                        data: null,
                        width: '10%'
                    }, // Serial Number column
                    {
                        data: 'Enrollment_No',
                        width: '15%'
                    },
                    {
                        data: null,
                        width: '30%',
                        render: row =>
                            `${row.First_Name ?? ''} ${row.Middle_Name ?? ''} ${row.Last_Name ?? ''}`
                            .trim()
                    },
                    {
                        data: 'Father_Name',
                        width: '30%'
                    },
                    {
                        data: 'Email',
                        width: '15%'
                    },
                    {
                        data: 'Contact',
                        width: '10%'
                    },
                    {
                        data: 'CourseName',
                        width: '30%'
                    },
                    {
                        data: 'SubCourseName',
                        width: '30%'
                    },
                    {
                        data: 'Address', // or data: null if whole row
                        width: '25%',
                        render: function(data, type, row) {

                            // If address is a JSON string, parse it
                            let address = typeof data === 'string' ? JSON.parse(data) : data;
                            // console.log(data);

                            // return ``;
                            if (!address) return '—';

                            return `
            ${address.present_address ?? ''}
            ${address.present_city ?? ''}, ${address.present_district ?? ''}
            ${address.present_state ?? ''} - ${address.present_pincode ?? ''}
        `.trim();
                        }
                    },
                    {
                        data: 'Status',
                        width: '10%',
                        render: status =>
                            status == 1 ?
                            '<span class="badge bg-success">Active</span>' :
                            '<span class="badge bg-danger">Inactive</span>'
                    },
                    {
                        data: 'Created_At',
                        width: '15%',
                        render: date =>
                            date ? new Date(date).toLocaleDateString('en-GB') : ''
                    }
                ],
                language: {
                    search: "Search students:",
                    lengthMenu: "Show _MENU_ students"
                }
            });

            // 🔥 PURE JS SERIAL NUMBER (AUTO UPDATE ON PAGINATION, SEARCH, SORT)
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
