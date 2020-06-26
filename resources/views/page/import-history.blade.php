@extends('layouts.app')
@section('title')
Datafiniti Property List
@endsection
@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- SELECT2 EXAMPLE -->
        <div class="card card-default">
            <!-- /.card-header -->
            <div class="card-body">
                <form method="GET" action="{{ url('/datafiniti-property-list') }}">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <select class="form-control input-border country" name="country">
                                    <option value="">--Select Country--</option>
                                    @foreach($countries as $row)
                                        <option value="{{ $row->id }}" {{ $country==$row->id ? 'selected':'' }}>{{ $row->country_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select class="form-control input-border city" name="city">
                                    <option value="">--Select City--</option>
                                    @foreach($cities as $row)
                                        <option value="{{ $row->id }}" {{ $city==$row->id ? 'selected':'' }}>{{ $row->city_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <button class="btn btn-info search-btn" type="submit"><i class="fas fa fa-search"></i>&nbsp;Search</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="import-history table-responsive">
                    @include('page.import-history-data')
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
            var country_id = $(".country-id-"+id).val();
            var city_id = $('.city-id-'+id).val();
            var date_added = $('.date-added-'+id).val();
            var date_updated = $('.date-updated-'+id).val();
            var geo_location = $('.geo-location-'+id).val();
            var latitude = $('.latitude-'+id).val();
            var longitude = $('.longitude-'+id).val();
            $.ajax({
                type: 'GET',
                url:'{{ route('inline.rental.edit') }}',
                data:{
                    "id":id,
                    "country_id":country_id,
                    "city_id":city_id,
                    "date_added":date_added,
                    "date_updated":date_updated,
                    "geo_location":geo_location,
                    "latitude":latitude,
                    "longitude":longitude,
                },success:function(respone){
                    window.location.reload();
                }
            });
        });
    });
</script>
@endsection
