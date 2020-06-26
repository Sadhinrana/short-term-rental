@extends('layouts.app')
@section('title')
    Vote Analytical View
@endsection
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- SELECT2 EXAMPLE -->
            <div class="card card-default">
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-custom">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th class="text-center">Community Name</th>
                                        <th class="text-center">Total Vote</th>
                                        <th class="text-center">Matched Vote</th>
                                        <th class="text-center">Mismatched Vote</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($communities as $key => $community)
                                        <tr>
                                            <td>{{  $key+1 }}</td>
                                            <td class="text-center">{{$community['name']}}</td>
                                            <td class="text-center">{{ ($community['matched'] + $community['mismatched']) }}</td>
                                            <td class="text-center">{{ $community['matched']  }}</td>
                                            <td class="text-center">{{ $community['mismatched']  }}</td>
                                            <td >
                                                <a class="btn btn-primary" href="/line-graph?id='{{ $community['ids'] }}'">Graph</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection


