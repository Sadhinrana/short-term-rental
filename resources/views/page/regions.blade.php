@extends('layouts.app')
@section('title')
    LeaseAbuse Region List
@endsection
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- SELECT2 EXAMPLE -->
            <div class="card card-default">
                <!-- /.card-header -->
                <div class="row">
                    <div class="col-md-12">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="region-history table-responsive">
                                <table class="table table-bordered table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Latitude</th>
                                            <th>Longitude</th>
                                            <th>Name</th>
                                            <th>Type</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(!$regions->isEmpty())
                                            @foreach($regions as $key => $row)
                                                <tr>
                                                    <td>{{ $key+1 }}</td>
                                                    <td>{{ $row->latitude }}</td>
                                                    <td>{{ $row->longitude }}</td>
                                                    <td>{{ $row->name }}</td>
                                                    <td>{{ $row->type }}</td>
                                                    <td>
                                                        {{ Form::open(array('url' => '/region/listings', 'method' => 'get')) }}
                                                            <input type="hidden" value="{{ $row->api_id }}" name="api_id">
                                                            <button type="submit"><i class="fas fa-upload"></i></button>
                                                        {{ Form::close() }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <th class="text-center" colspan="6">No Data Found</th>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
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
