@extends('layouts.app')
@section('title')
    Noo Property List
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
                            <form method="GET" action="{{ url('/noo-property-list') }}">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text input-border-logo" id="basic-addon1"><i
                                                        class="fas fa-search"></i></span>
                                            </div>
                                            <input type="text" name="q" value="{{ $q }}" class="form-control border-left-none input-border"
                                                   placeholder="Search" aria-label="Username"
                                                   aria-describedby="basic-addon1">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <button class="btn btn-info search-btn" type="submit"><i
                                                    class="fas fa fa-search"></i>&nbsp;Search
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <a href="javascript(void)" class="btn btn-info"
                                           style="float: right"
                                           data-toggle="modal" data-target="#importModal"><i class="fas fa-upload"></i>&nbsp;Import
                                            Picture</a>

                                        <a href="javascript(void)" class="btn btn-purple"
                                           style="float: right;margin-right: 2%"
                                           data-toggle="modal" data-target="#exportModal"><i
                                                class="fas fa-cloud-download-alt"></i>&nbsp;Export Picture</a>
                                        <a href="javascript(void)" class="btn btn-primary"
                                           style="float: right;margin-right: 2%"
                                           data-toggle="modal" data-target="#exportDetailsModal"><i
                                                class="fas fa-cloud-download-alt"></i>&nbsp;Export Details</a>
                                    </div>
                                </div>
                            </form>
                            <div class="properties-history table-responsive">
                                @include('page.properties-history-data')
                            </div>

                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <div class="modal fade" id="exportModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form class="form-horizontal" action="{{ route('export.noo.picture') }}" method="GET">
                {{ csrf_field() }}
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Export Picture</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <lable class="col-md-4">Select City</lable>
                            <div class="col-md-8">
                                <select class="form-control input-border" name="city">
                                    <option value="">--Select City--</option>
                                    @foreach($cities as $row)
                                        <option value="{{ $row->ParcelCity }}">{{ $row->ParcelCity }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="export-btn"><i
                                class="fas fa-cloud-download-alt"></i>&nbsp;Export
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form class="form-horizontal" action="{{ route('import.noo.picture') }}" method="POST">
                {{ csrf_field() }}
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Import Picture</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <lable class="col-md-4">Select City</lable>
                            <div class="col-md-8">
                                <select class="form-control input-border" name="city">
                                    <option value="">--Select City--</option>
                                    @foreach($cities as $row)
                                        <option value="{{ $row->ParcelCity }}">{{ $row->ParcelCity }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="export-btn"><i
                                class="fas fa-cloud-download-alt"></i>&nbsp;Import
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="exportDetailsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form class="form-horizontal" action="{{ route('export.noo.details') }}" method="POST">
                {{ csrf_field() }}
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Export NOO Property</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <lable class="col-md-4">Select City</lable>
                            <div class="col-md-8">
                                <select class="form-control input-border" name="city">
                                    <option value="">--Select City--</option>
                                    @foreach($cities as $row)
                                        <option value="{{ $row->ParcelCity }}">{{ $row->ParcelCity }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="export-btn"><i
                                class="fas fa-cloud-download-alt"></i>&nbsp;Export
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- /.content -->
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            $(document).on('click', '.row-edit', function () {
                var id = $(this).attr('id');
                $(".show-value-" + id).hide();
                $(".inline-edit-" + id).show();
            });
            $(document).on('click', '.row-save', function () {
                let id = $(this).attr('id');
                let PropertyGID = $(".PropertyGID-" + id).val();
                let OwnerName1 = $(".OwnerName1-" + id).val();
                let SiteAddress = $(".SiteAddress-" + id).val();
                let SiteCity = $(".SiteCity-" + id).val();
                let SiteState = $(".SiteState-" + id).val();
                let siteId = $(".siteId-" + id).val();
                let ownerId = $(".ownerId-" + id).val();
                $.ajax({
                    type: 'GET',
                    url: "{{ route('inline.property.edit') }}",
                    data: {
                        "id": id,
                        "PropertyGID": PropertyGID,
                        "OwnerName1": OwnerName1,
                        "SiteAddress": SiteAddress,
                        "SiteCity": SiteCity,
                        "SiteState": SiteState,
                        "siteId": siteId,
                        "ownerId": ownerId,
                    }, success: function (response) {
                        window.location.reload();
                    }
                });
            });
        });
    </script>
@endsection
