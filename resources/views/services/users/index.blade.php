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
                    <h3 class="mb-4">Users List</h3>
                    <div>
                        <button id="toggle-filters" class="btn btn-primary btn-sm me-2">
                            <i class="fa fa-filter"></i> Show Filters
                        </button>
                    </div>
                </div>

                <div class="filter-section" id="filterSection">
                    <div class="row">                       

                        <div class="col-lg-2 mb-2 date-range-input">
                            <input type="text" class="datepicker-here form-control digits" id="created_AT"
                                   placeholder="Created Date Range">
                            {{-- <button type="button" class="clear-date" data-target="created_AT"><i class="fa fa-times"></i></button> --}}
                        </div>

                        <div class="col-lg-2 mb-2">
                            <select id="user_role" class="form-control">
                                <option value="">All Role</option>
                            </select>
                        </div>

                        <div class="col-lg-2 mb-2">
                            <select id="user_vertical" class="form-control">
                                <option value="">All Vertical</option>
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
                    <table id="users-table" class="display w-100 table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>User Name</th>
                                <th>Short Name</th>
                                <th>Email</th>
                                <th>Contact</th>
                                <th>Designation</th>
                                <th>Students Admission</th>
                                <th>Address</th>
                                <th>Status</th>
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
    let userTable;

    // ================================
    // Load filter options from localStorage
    // ================================
   function loadFilterOptions() {
    const stored = localStorage.getItem('filters_users');
    // console.log(stored);
    if (!stored) return;

    const parsed = JSON.parse(stored);

    // your data is inside usersRole
    const roles = parsed.usersRole?.roles || [];
    const verticals = parsed.usersRole?.verticals || [];
console.log(roles);
    // Populate role select
    const roleSelect = $('#user_role')
        .empty()
        .append('<option value="">All Role</option>');

    roles.forEach(r => {
        roleSelect.append(`<option value="${r}">${r}</option>`);
    });

    // Populate vertical select
    const verticalSelect = $('#user_vertical')
        .empty()
        .append('<option value="">All Vertical</option>');

    verticals.forEach(v => {
        verticalSelect.append(`<option value="${v}">${v}</option>`);
    });
}

    // ================================
    // Toggle filter section
    // ================================
    $('#toggle-filters').on('click', function() {
        $('#filterSection').toggleClass('show');
        $(this).html($('#filterSection').hasClass('show')
            ? '<i class="fa fa-filter"></i> Hide Filters'
            : '<i class="fa fa-filter"></i> Show Filters');
    });

    // ================================
    // Clear date button
    // ================================
    $('.clear-date').on('click', function() {
        const target = $(this).data('target');
        $('#' + target).val('');
        $(this).hide();
        applyFilters();
    });

    $('#created_AT').on('change', function() {
        const clearBtn = $('.clear-date[data-target="' + $(this).attr('id') + '"]');
        clearBtn.toggle(!!$(this).val());
    });

    // ================================
    // Initialize DataTable
    // ================================
    userTable = $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        pageLength: 25,
        lengthMenu: [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, "All"]
        ],
        ajax: {
            url: `/services/users/${uni_id}`,
            type: "GET",
            data: function(d) {
                // Parse date range
                const createDate = $('#created_AT').val() || '';
                let createStart = '', createEnd = '';
                if (createDate.includes(',')) {
                    const parts = createDate.split(',').map(v => v.trim());
                    createStart = parts[0] || '';
                    createEnd = parts[1] || '';
                }

                d.filters = {
                   
                    processed_by_create_start: createStart,
                    processed_by_create_end: createEnd,
                    user_vertical: $('#user_vertical').val(),
                    user_role: $('#user_role').val()
                };
            },
            error: function(xhr, error, thrown) {
                console.error('DataTable AJAX Error:', error);
            }
        },
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            {
                data: 'Photo',
                orderable: false,
                searchable: false,
                render: function(photo) {
                    if (!photo) return '<span class="text-muted">N/A</span>';
                    let liveURL = "{{ session('live_url') }}";
                    return `<img src="${liveURL}${photo}" width="45" height="45" style="object-fit:cover;border-radius:6px;">`;
                }
            },
            { data: 'Name' },
            { data: 'Short_Name' },
            { data: 'Email' },
            { data: 'Mobile' },
            { data: 'Designation' },
            { data: 'Admissions' },
            { 
                data: 'Address',
                render: function(data, type, row) {
                    return `${row.Address ?? ''} ${row.District ?? ''} ${row.State ?? ''} ${row.Pincode ?? ''}`.trim();
                }
            },
            { 
                data: 'Status',
                render: function(status) {
                    return status == 1 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
                }
            },
            { 
                data: 'Created_At',
                render: function(date) {
                    return date ? new Date(date).toLocaleDateString('en-GB') : '';
                }
            }
        ],
        order: [[2, 'desc']],
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

    // ================================
    // Apply & Clear Filters
    // ================================
    function applyFilters() { userTable.ajax.reload(); }
    $('#apply-filters').on('click', applyFilters);

    function clearFilters() {
      
        $('#created_AT').val('');
        $('.clear-date').hide();
        $('#user_role').val('').trigger('change.select2');
        $('#user_vertical').val('').trigger('change.select2');
        applyFilters();
    }
    $('#clear-filters').on('click', clearFilters);

    // Auto-apply filters when select changes
    $('#user_role, #user_vertical').on('change', applyFilters);

    // ================================
    // Initialize everything
    // ================================
    function init() {
        loadFilterOptions();
        applyFilters();
    }

    init();
});
</script>
@endsection
