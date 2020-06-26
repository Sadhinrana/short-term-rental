@extends('layouts.app')
@section('title')
    Noo Property Owner List
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
                            <form method="GET" action="{{ route('noo.property.owner') }}">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select class="form-control input-border city" name="city">
                                                <option value="">--Select City--</option>
                                                @foreach($cities as $city)
                                                    <option value="{{ $city->OwnerCity }}" {{ $selectedCity == $city->OwnerCity ? 'selected' : '' }}>{{ $city->OwnerCity }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control input-border" name="keyword" placeholder="Keyword" value="{{ $selectedkeyword }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <button class="btn btn-info search-btn" type="submit"><i class="fas fa fa-search"></i>&nbsp;Search</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="properties-history table-responsive">
                                <table  class="table table-custom">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>City</th>
                                        <th>State</th>
                                        <th>Zip-code</th>
                                        <th class="text-center" colspan="2">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!$owners->isEmpty())
                                        @foreach($owners as $key => $owner)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $owner->OwnerName1 }}</td>
                                                <td>{{ $owner->OwnerAddress }}</td>
                                                <td>{{ $owner->OwnerCity }}</td>
                                                <td>{{ $owner->OwnerState }}</td>
                                                <td>{{ $owner->OwnerZipcode }}</td>
                                                <td class="text-center">
                                                    <a class="btn btn-xs btn-success mr-r-5" title="Details" href="{{ route('noo.property.owner.show', ['id' => $owner->Id]) }}"><i class="fas fa-info-circle"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="8" class="text-center">No Data Found.</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                                <div style="float: right">{{ $owners->links() }}</div>
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
