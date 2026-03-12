<div class="modal-header">
    <h5 class="modal-title">Select Needed Fields</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
    <form id="downloadFied">
        @csrf
        <input type="hidden" name="uni_id" value="{{ $uniId }}">
        <input type="hidden" name="live_url" value="{{ $liveUrl }}">
        <input type="hidden" name="method" value="{{ $method }}">
        <div class="row">
            @forelse ($colums as $column )
                <div class=" col-md-4 form-check">
                    <input class="form-check-input" type="checkbox" id="{{ $column }}" name="{{ $column }}">
                    <label class="form-check-label" for="{{$column}}">{{ ucwords(str_replace("_"," ",$column)) }}</label>
                </div>
            @empty
                <h4>No Columns Configured</h4>
            @endforelse
        </div>
        <div class="row">
            <div class="col-md-2">
                <button class="btn btn-success border-radius-5 submitbutton" type="submit">Download</button>
            </div>
        </div>
    </form>
</div>
<script src="https://cdn.sheetjs.com/xlsx-0.20.2/package/dist/xlsx.full.min.js"></script>
<script>
    $('#downloadFied').on('submit',function(e){
        $('.submitbutton').prop("disabled",true);
        e.preventDefault();
        $.ajax({
            url:"{{ route('download-custom-data') }}",
            type:"post",
            data:$(this).serialize(),
            success: function(response) {
                if(response.status=='success'){
                    exportToExcel(response);
                    $('.submitbutton').prop("disabled",false);
                }else{
                    alert(response.message);
                }
            },
            error: function(error) {
                alert('Error:', error)
                console.error('Error:', error);
            }
        })
    });

    function exportToExcel(response) {
        if (response.status === 'success' && response.data) {
            // पहला element headers है
            const headers = response.data[0];
            
            // बाकी सारे elements rows हैं (objects के रूप में)
            const rows = response.data.slice(1);
            
            // Data को worksheet के format में बदलें
            // पहले headers array को डालें
            const worksheetData = [headers];
            
            // अब हर object row को array में बदलें
            rows.forEach(row => {
                const rowArray = [];
                
                // हर header के according value निकालें
                headers.forEach(header => {
                    // Object से value निकालें, अगर नहीं है तो empty string
                    rowArray.push(row[header] !== undefined ? row[header] : '');
                });
                
                worksheetData.push(rowArray);
            });
            
            // Debug - check the structure
            // console.log('Headers:', headers);
            // console.log('First row (converted):', worksheetData[1]);
            // console.log('Worksheet data structure:', worksheetData);
            
            // Workbook और worksheet बनाएं
            const wb = XLSX.utils.book_new();
            const ws = XLSX.utils.aoa_to_sheet(worksheetData);
            
            // worksheet को workbook में add करें
            XLSX.utils.book_append_sheet(wb, ws, "Students");
            
            // Excel file download करें
            XLSX.writeFile(wb, "students_export.xlsx");


        } else {
            console.error('Invalid response format:', response);
        }
    }
</script>
