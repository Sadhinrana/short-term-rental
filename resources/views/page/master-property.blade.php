@extends('layouts.app')
@section('title')
Master Property
@endsection
@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- SELECT2 EXAMPLE -->
        <div class="card card-default">
{{--            <div class="card-header">--}}
{{--                <a href="{{ route('combine.data') }}" class="btn btn-primary" style="float: right">Combine Property</a>--}}
{{--            </div>--}}
            <!-- /.card-header -->
            <div class="row">
                <div class="col-md-12">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form action="{{ url('/master-property') }}" method="GET">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text input-border-logo" id="basic-addon1"><i class="fas fa-search"></i></span>
                                        </div>
                                        <input type="text"  class="form-control border-left-none input-border" placeholder="Search" aria-label="Username" aria-describedby="basic-addon1">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-control input-border" name="region_name">
                                        <option value="">--Select Region--</option>
                                        @foreach($regions as $row)
                                            <option value="{{ $row->name }}" {{ $row->name == $region_name ? 'selected':'' }}>{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-control select2 input-border" name="room_type[]" multiple="multiple" data-placeholder="Select Room Type">
                                        <option value="">--Select Room Type--</option>
                                        @foreach($room_types as $row)
                                            <option value="{{ $row->room_type }}" {{ in_array($row->room_type, $room_type)? 'selected':'' }}>{{ $row->room_type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select class="form-control input-border" name="match" >
                                        <option value="">--All Property--</option>
                                        <option value="3" {{ $match==3 ? 'selected':'' }}>Matched to a NOO Property</option>
                                        <option value="1" {{ $match==1 ? 'selected':'' }}>Unmatch to a NOO Property</option>
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <button class="btn btn-info search-btn" type="submit"><i class="fas fa fa-search"></i>&nbsp;Search</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                            <div class="master-property table-responsive">
                            @include('page.master-property-data')
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
