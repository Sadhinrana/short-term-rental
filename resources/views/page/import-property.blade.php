@extends('layouts.app')
@section('title')
Noo Property Import
@endsection

@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- SELECT2 EXAMPLE -->
        <div class="card card-default">
            <!-- /.card-header -->
            <form method="POST" action="{{ url('/noo-property-import') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="card-body">
                    <div class="alert alert-success alert-dismissible fade show" role="alert" style="display:none">
                        Sucessfully Import Excel.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @if(Session::get('message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ Session::get('message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Upload File</label>
                                <input type="file" class="form-control" name="file" required="">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i>&nbsp;Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <!-- /.card-body -->
        </div>
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection
@section('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.15.1/xlsx.full.min.js"></script>
<script>
    // Send ajax request Add Product
    $("#file-upload").submit(function(event) {
        // Stop browser from submitting the form
        event.preventDefault();
        // Send ajax request
        $.ajax({
            type: 'POST',
            url: '{{ route('file.upload') }}',
            data: new FormData( this ),
            cache: false,
            contentType: false,
            processData: false,
            success: function(data){
                parseExcel(data[0], data[1]);
            },
        });
    });

    function parseExcel(uri, fileName) {
        var sheet = {
            data: []
        };

        let url = uri;
        let oReq = new XMLHttpRequest();
        oReq.open("GET", url, true);
        oReq.responseType = "arraybuffer";
        oReq.onload = function (e) {
            let arraybuffer = oReq.response;
            let data = new Uint8Array(arraybuffer);
            let arr = new Array();
            for (let i = 0; i != data.length; ++i) arr[i] = String.fromCharCode(data[i]);
            let bstr = arr.join("");
            let workbook = XLSX.read(bstr, {type: "binary"});

            sheet.data = XLSX.utils.sheet_to_json(workbook.Sheets[workbook.SheetNames[0]], {raw: true});
            uploadExcel(sheet, fileName);
        };
        oReq.send();
    }

    function uploadExcel(data, fileName) {
        // Send ajax request
        $.ajax({
            type: 'POST',
            url: '{{ route('import.property') }}',
            data: {
                '_token': '{{ csrf_token() }}',
                'data': JSON.stringify(data),
                'fileName': fileName,
            },
            success: function(data){
                console.log(data);
                if (data.status === 200) {
                    $("#file-upload").trigger('reset');

                    $('.alert-success').show();
                    setTimeout(function () {
                        $('.alert-success').hide();
                    }, 3000);
                }
            },
        });
    }
</script>
@endsection
