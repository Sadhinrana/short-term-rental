@extends('layouts.app')
@section('title')
    Export Community
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            @if(Session::get('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ Session::get('message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
        @endif
        <!-- SELECT2 EXAMPLE -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-default">
                        <div class="card-header">
                            <p><strong>Export Community</strong></p>
                        </div>
                        <!-- /.card-header -->
                        <form method="POST" action="{{ route('export.community') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <select class="form-control" name="community" required>
                                                        <option value="">Select Community</option>
                                                        @foreach($properties as $row)
                                                            <option>{{ $row->ParcelCity  }}</option>
                                                            @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3 text-right">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-info"><i class="fas fa-upload"></i>&nbsp;Export</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
