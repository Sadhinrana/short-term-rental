@extends('layouts.app')
@section('title')
    LeaseAbuse Property List
@endsection
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- SELECT2 EXAMPLE -->
            <div class="card card-default">
                <div class="card-header">
                    <a href="{{ url('/region/list') }}" class="btn btn-primary" style="float: right">Import From API</a>
                </div>
                <!-- /.card-header -->
                <div class="row">
                    <div class="col-md-12">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form action="{{ url('/leaseabuse-property-list') }}" method="GET">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
                                            </div>
                                            <input type="text" name="q" value="{{ $keywords }}" class="form-control" placeholder="Search" aria-label="Username" aria-describedby="basic-addon1">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <button class="btn btn-primary search-btn" type="submit"><i class="fas fa fa-search"></i>&nbsp;Search</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="region-history table-responsive">
                                @include('page.region-history-data')
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            $(document).on('click','.row-edit',function(){
                var id = $(this).attr('id');
                $(".show-value-"+id).hide();
                $(".inline-edit-"+id).show();
            });
            $(document).on('click','.row-save',function(){
                var id = $(this).attr('id');
                var region_id = $(".region-id-"+id).val();
                var name = $('.name-'+id).val();
                var type = $('.type-'+id).val();
                var latitude = $('.latitude-'+id).val();
                var longitude = $('.longitude-'+id).val();
                var host_name = $('.hostName-'+id).val();
                var source = $('.source-'+id).val();
                var price = $('.price-'+id).val();
                $.ajax({
                    type:'GET',
                    url:"{{ route('inline.region.edit') }}",
                    data:{
                        "id":id,
                        "region_id":region_id,
                        "name":name,
                        "type":type,
                        "latitude":latitude,
                        "longitude":longitude,
                        "host_name":host_name,
                        "source":source,
                        "price":price,
                    },success:function(response){
                        window.location.reload();
                    }
                });
            });
        });
    </script>
@endsection
