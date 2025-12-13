@extends('layouts.main')

@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-header">
            <div class="card">
                <div class="card-body">
                    <div class="row">

                        <div class="col-sm-6">
                            <h3>University ERP</h3>
                        </div>

                        <div class="col-sm-6 text-end">
                            <a href="javascript:void(0)" 
                               
                               onclick="add('{{ route('university-erp.create') }}', 'modal-md')"
                               class="text-primary rounded" 
                               data-bs-toggle="tooltip" 
                               data-bs-placement="top"
                               title="Add New ERP">
                               <i class="ri-apps-2-add-fill fs-3"></i>
                            </a>
                        </div>

                        <div class="col-sm-12 mt-4">
                            <div class="table-responsive">
                                <table id="erp-table" class="display w-100"></table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {

    $('#erp-table').DataTable({
        processing: true,
        serverSide: false,
        ajax: "{{ route('university-erp.index') }}",
        columns: [
            { title: "#", data: "serial" },
            { title: "Name", data: "name" },
            { title: "Live URL", data: "live_url" },
            { title: "Logo", data: "logo", render: function(data){
                if(data){
                    return '<img src="/storage/'+data+'" width="60">';
                } else {
                    return 'N/A';
                }
            }},
            { title: "Action", data: "action", orderable: false, searchable: false }
        ]
    });

    $(document).ajaxComplete(function() {
        $('[data-bs-toggle="tooltip"]').tooltip();
    });
});
</script>
@endsection
