@extends('layouts.app')
@section('title')
    Host Details
@endsection
@section('content')
    <section class="content">
        <div class="container-fluid">
            <!-- SELECT2 EXAMPLE -->
            <div class="card card-default">
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <!-- /.card-header -->
                        <div class="col-md-6">
                            <ul class="list-group list-group-unbordered">
                                <li class="list-group-item">
                                    <span class="info-box-text text-center text-muted"><b>Name</b></span>
                                    <span
                                        class="float-right info-box-number text-center text-muted mb-0">{{ $hostDetails->name  }} </span>
                                </li>
                                <li class="list-group-item">
                                    <span class="info-box-text text-center text-muted"><b>Date Seen</b></span>
                                    <span
                                        class="float-right info-box-number text-center text-muted mb-0">{{ date('d M, Y',strtotime($hostDetails->date_seen))  }} </span>
                                </li>
                            </ul>
                            <div class="card-header">
                                <strong>Noo Owner Match</strong>
                            </div>
                            <div class="card-body">
                                <table class="table table-custom">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Owner Name</th>
                                        <th>Owner Address</th>
                                        <th>Owner City</th>
                                        <th>Owner State</th>
                                        <th>Owner Zip Code</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($matchProperty)
                                        @foreach($matchProperty as $key=>$row)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>{{ $row->OwnerName1 }}</td>
                                                <td>{{ $row->OwnerAddress }}</td>
                                                <td>{{ $row->OwnerCity }}</td>
                                                <td>{{ $row->OwnerState }}</td>
                                                <td>{{ $row->OwnerZipcode }}</td>
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
                            <div class="card-header">
                                <strong>Manual Match
                                </strong>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('save.manual.match') }}"
                                      enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        <select class="form-control select2" multiple name="owner_id[]">
                                                            @foreach($nooProperties as $row)
                                                                <option
                                                                    value="{{ $row->Id }}">{{ $row->owner->OwnerName1 }}</option>
                                                            @endforeach
                                                        </select>
                                                        <input type="hidden" value="{{ $id }}" name="people_id">
                                                    </div>
                                                    <div class="col-md-3 text-right">
                                                        <div class="form-group">
                                                            <button type="submit" class="btn btn-info"><i
                                                                    class="fas fa-upload"></i>&nbsp;Submit
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="card-header">
                                <strong>
                                    Manual Match List
                                </strong>
                            </div>
                            <div class="card-body">
                                <table class="table table-custom">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Owner Name</th>
                                        <th>Owner Address</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!$manualMatch->isEmpty())
                                        @foreach($manualMatch as $key=> $row)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>{{ $row->owners['OwnerName1'] }}</td>
                                                <td>{{ $row->owners['OwnerAddress'] }}</td>
                                                <td><a onclick="return confirm('Do you want to delete ?')"
                                                       href="{{ route('destroy.manual.match',[$row->id]) }}"
                                                       class="btn btn-danger btn-xs"><i class="fas fa-times"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td class="text-center" colspan="4">No Data Found</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card-header"><strong>Fuzzy Match</strong></div>
                            <div class="card-body">
                                <table class="table table-custom">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Owner Name</th>
                                        <th>Owner Address</th>
                                        <th>Score</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($ownerRatio as $key=> $row)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $row[0]->OwnerName1 }}</td>
                                            <td>{{ $row[0]->OwnerAddress }}</td>
                                            <td>{{ $row[1] }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="card-body">
                                <form method="POST" action="{{ route('update.host.image_url') }}"
                                      enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <span>Host URL</span>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" value="{{ $hostDetails->image_url }}" name="image_url" class="form-control">
                                                        <input type="hidden" value="{{ $id }}" name="people_id">
                                                    </div>
                                                    <div class="col-md-2 text-right">
                                                        <div class="form-group">
                                                            <button type="submit" class="btn btn-info"><i
                                                                    class="fas fa-check-circle"></i>&nbsp;Save
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
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
