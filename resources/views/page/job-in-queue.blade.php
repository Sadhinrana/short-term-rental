@extends('layouts.app')
@section('title')
    Job in Queue
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
                            <p><strong>Datafiniti Import</strong></p>
                        </div>
                        <!-- /.card-header -->
                        <form method="POST" action="{{ route('upload.file') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                      <div class="row">
                                          <div class="col-md-9">
                                              <div class="form-group">
                                                  <input type="file" class="form-control input-border" name="file" required="">
                                                  <input type="hidden" class="form-control" name="property_type" value="1">
                                              </div>
                                          </div>
                                          <div class="col-md-3 text-right">
                                              <div class="form-group">
                                                  <button type="submit" class="btn btn-info"><i class="fas fa-upload"></i>&nbsp;Upload</button>
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
                <div class="col-md-6">
                    <div class="card card-default">
                        <div class="card-header">
                            <p><strong>NOO Property Import</strong></p>
                        </div>
                        <!-- /.card-header -->
                        <form method="POST" action="{{ route('upload.file') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <input type="file" class="form-control input-border" name="file" required="">
                                                    <input type="hidden" class="form-control" name="property_type" value="2">
                                                </div>
                                            </div>
                                            <div class="col-md-3 text-right">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-info"><i class="fas fa-upload"></i>&nbsp;Upload</button>
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
{{--                <div class="col-md-6">--}}
{{--                    <div class="card card-default">--}}
{{--                        <div class="card-header">--}}
{{--                            <p><strong>LeaseAbuse Api Import</strong></p>--}}
{{--                        </div>--}}
{{--                        <!-- /.card-header -->--}}
{{--                        <form method="POST" action="{{ route('upload.file') }}" enctype="multipart/form-data">--}}
{{--                            {{ csrf_field() }}--}}
{{--                            <div class="card-body">--}}
{{--                                <div class="row">--}}
{{--                                    <div class="col-md-12">--}}
{{--                                        <div class="form-group">--}}
{{--                                            <label>Select Region</label>--}}
{{--                                            <select class="form-control" name="api_id">--}}
{{--                                                <option value="">Select Region</option>--}}
{{--                                                @foreach($regionsList as $row)--}}
{{--                                                    <option value="{{ $row['id'] }}">{{ $row['name'] }}</option>--}}
{{--                                                @endforeach--}}
{{--                                            </select>--}}
{{--                                            <input type="hidden" class="form-control" name="property_type" value="3">--}}
{{--                                        </div>--}}
{{--                                        <div class="form-group">--}}
{{--                                            <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i>&nbsp;Submit--}}
{{--                                            </button>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </form>--}}
{{--                        <!-- /.card-body -->--}}
{{--                    </div>--}}
{{--                </div>--}}
                <div class="col-md-12">
                    <div class="card card-default">
                        <div class="card-header">
                            <p><strong>Queue List</strong></p>
                        </div>
                        <div class="card-body">
                            <table class="table table-custom">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Property Type</th>
                                    <th>File</th>
                                    <th>Region Name</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Is Active</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!$jobInQueue->isEmpty())
                                    @foreach($jobInQueue as $key => $row)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>
                                                @if($row->property_type==1)
                                                    Datafiniti Property
                                                @elseif($row->property_type==2)
                                                    NOO Property
                                                @elseif($row->property_type==3)
                                                    LeaseAbuse Property
                                                @endif
                                            </td>
                                            <td><a>{{ $row->file_url }}</a></td>
                                            <td>
                                                @if($row->api_id)
                                                    @php($key = array_search($row->api_id,array_column($regionsList,'id')))
                                                    {{ $regionsList[$key]['name'] }}
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if($row->status==0)
                                                    <button type="button" class="btn btn-danger btn-xs">Pending</button>
                                                @elseif($row->status==1)
                                                    <button type="button" class="btn btn-primary btn-xs">Running
                                                    </button>
                                                @elseif($row->status==2)
                                                    <button type="button" class="btn btn-success btn-xs">Complete
                                                    </button>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if($row->is_active==0)
                                                    <a href="{{ route('job.active',[$row->id]) }}" title="Active"
                                                       class="btn btn-yellow btn-xs"><i class="fas fa-arrow-up"></i>
                                                    </a>
                                                @elseif($row->is_active==1 && $row->status !=2)
                                                    <button href="" class="btn btn-success btn-xs"><i
                                                            class="fas fa-arrow-down"></i>
                                                    </button>
                                                @endif
                                            </td>
                                            <td class="text-center"><a
                                                    onclick="return confirm('Do you want to destroy ?')" title="Delete"
                                                    href="{{ route('destroy.job-in-queue',[$row->id]) }}"
                                                    class="btn btn-danger btn-xs"><i class="fas fa-times"></i></a></td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="text-center" colspan="6">No Data Found</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
