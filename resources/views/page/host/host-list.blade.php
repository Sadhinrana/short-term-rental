@extends('layouts.app')
@section('title')
    Host List
@endsection
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="card card-default">
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{ route('host.list') }}" method="GET">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="input-group mb-4">
                                    <select class="form-control input-border" name="city">
                                        <option value="">--Select City--</option>
                                        @foreach($cities as $row)
                                            <option value="{{ $row->id }}" {{ $city_id == $row->id ? 'selected':'' }}>{{ $row->city_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <button class="btn btn-info search-btn" type="submit"><i
                                            class="fas fa fa-search"></i>&nbsp;Search
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-custom">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Host Name</th>
                                    <th>Date Seen</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!$hosts->isEmpty())
                                    @foreach($hosts as $key => $row)
                                        <tr>
                                            <td>{{ $key + $hosts->firstItem() }}</td>
                                            <td>{{ $row->name }}</td>
                                            <td>{{ date('d M, Y',strtotime($row->date_seen)) }}</td>
                                            <td class="text-center"><a href="{{ route('host.details',[$row->id]) }}" title="Details" class="btn btn-xs btn-primary"><i class="fas fa-info-circle"></i></a></td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center">No Data Found.</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                        <div>{{ $hosts->links() }}</div>
                    </div>

                </div>
                <!-- /.card-body -->
            </div>
        </div><!-- /.container-fluid -->
    </section>
@endsection
