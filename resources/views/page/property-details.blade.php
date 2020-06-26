@extends('layouts.app')
@section('title')
    Noo Property Details
@endsection
@section('content')
    <style type="text/css">
        #map {
            width: 600px;
            height: 400px;
        }
    </style>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- SELECT2 EXAMPLE -->
            <div class="card card-default">
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <!-- /.card-header -->
                        @if(!$property->image)
                            <div class="col-md-12">
                                @php($link = "https://www.google.com/maps/place/".$property->IDX_Address.','.$property->site->SiteCity.','.$property->site->SiteState.' '.$property->site->SiteZipCode)
                                <a target="_blank" style="margin-bottom: 1%;" href="{{ $link }}"
                                   class="btn btn-primary">Go to Google Map</a>
                                <a class="btn btn-success" data-toggle="modal" href="javascript:void(0)"
                                   class="NooPropertyImage" data-target="#exampleModalCenter"
                                   style="margin-bottom: 1%;float: right" href="" class="btn btn-success">Upload
                                    Image</a>
                            </div>
                        @endif

                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    @if($property->image)
                                        <img src="{{ asset($property->image) }}" style="text-align: center" width="600">
                                    @else
                                        @php($link = "https://maps.googleapis.com/maps/api/streetview?size=600x400&location=" . $property->site->SiteAddress . "," . $property->site->SiteCity . "" . $property->site->SiteState . "" .$property->site->SiteZipCode . "&key=AIzaSyDE2i7RPzDbo7CajfIwJG2XOsRna7a9n70")
                                        <img src="{{ $link }}">
                                    @endif
                                </div>
                            </div>
                            <br>

                            <ul class="list-group list-group-unbordered">
                                <div class="head-text">
                                    <h4 class="section-header">Owner Information</h4>
                                    <div class="divider"></div>
                                </div>
                                <li class="list-group-item">
                                    <span class="info-box-text text-center text-muted"><b>Owner Name 1</b></span>
                                    <span
                                        class="float-right info-box-number text-center text-muted mb-0">{{ $property->owner->OwnerName1 ? $property->owner->OwnerName1:'--' }} </span>
                                </li>
                                <li class="list-group-item">
                                    <span class="info-box-text text-center text-muted"><b>Owner Name 2</b></span>
                                    <span
                                        class="float-right info-box-number text-center text-muted mb-0">{{ $property->owner->OwnerName2 ? $property->owner->OwnerName2:'--' }} </span>
                                </li>
                                <li class="list-group-item">
                                    <span class="info-box-text text-center text-muted"><b>Address</b></span>
                                    <span
                                        class="float-right info-box-number text-center text-muted mb-0">{{ $property->owner->OwnerAddress ? $property->owner->OwnerAddress:'--' }} </span>
                                </li>
                                <li class="list-group-item">
                                    <span class="info-box-text text-center text-muted"><b>City</b></span>
                                    <span
                                        class="float-right info-box-number text-center text-muted mb-0">{{ $property->owner->OwnerCity ? $property->owner->OwnerCity:'--' }} </span>
                                </li>
                                <li class="list-group-item">
                                    <span class="info-box-text text-center text-muted"><b>State</b></span>
                                    <span
                                        class="float-right info-box-number text-center text-muted mb-0">{{ $property->owner->OwnerState ? $property->owner->OwnerState:'--' }} </span>
                                </li>
                                <li class="list-group-item">
                                    <span class="info-box-text text-center text-muted"><b>Zip</b></span>
                                    <span
                                        class="float-right info-box-number text-center text-muted mb-0">{{ $property->owner->OwnerZipcode ? $property->owner->OwnerZipcode:'--' }} </span>
                                </li>
                            </ul>

                        </div>

                        <div class="col-md-6">
                            <div class="head-text">
                                <h4 class="section-header">General Information</h4>
                                <div class="divider"></div>
                            </div>
                            <ul class="list-group list-group-unbordered">
                                <li class="list-group-item">
                                    <span class="info-box-text text-center text-muted"><b>Property GID</b></span>
                                    <span
                                        class="float-right info-box-number text-center text-muted mb-0">{{ $property->PropertyGID ? $property->PropertyGID:'--' }} </span>
                                </li>
                                <li class="list-group-item">
                                    <span class="info-box-text text-center text-muted"><b>Parcel ID</b></span>
                                    <span
                                        class="float-right info-box-number text-center text-muted mb-0">{{ $property->ParcelID ? $property->ParcelID:'--' }} </span>
                                </li>
                                <li class="list-group-item">
                                    <span class="info-box-text text-center text-muted"><b>Parcel City</b></span>
                                    <span
                                        class="float-right info-box-number text-center text-muted mb-0">{{ $property->ParcelCity ? $property->ParcelCity:'--' }} </span>
                                </li>
                                <li class="list-group-item">
                                    <span class="info-box-text text-center text-muted"><b>Legal Description</b></span>
                                    <span
                                        class="float-right info-box-number  text-muted mb-0">{{ $property->LegalDesc ? $property->LegalDesc:'--' }} </span>
                                </li>
                                <li class="list-group-item">
                                    <span class="info-box-text text-center text-muted"><b>Property Use</b></span>
                                    <span
                                        class="float-right info-box-number text-center text-muted mb-0">{{ $property->PropertyUse ? $property->PropertyUse:'--' }} </span>
                                </li>
                                <li class="list-group-item">
                                    <span class="info-box-text text-center text-muted"><b>Community ID</b></span>
                                    <span
                                        class="float-right info-box-number text-center text-muted mb-0">{{ $property->CommCommunityID ? $property->CommCommunityID:'--' }} </span>
                                </li>
                                <li class="list-group-item">
                                    <span class="info-box-text text-center text-muted"><b>IDX Address</b></span>
                                    <span
                                        class="float-right info-box-number text-center text-muted mb-0">{{ $property->IDX_Address ? $property->IDX_Address:'--' }} </span>
                                </li>
                                <li class="list-group-item">
                                    <span class="info-box-text text-center text-muted"><b>Number of Units</b></span>
                                    <span
                                        class="float-right info-box-number text-center text-muted mb-0">{{ $property->owner->NumberofUnits ? $property->owner->NumberofUnits:'--' }} </span>
                                </li>
                            </ul>
                            <div class="head-text" style="margin-top: 58px;">
                                <h4 class="section-header">Parsed Owner Address</h4>
                                <div class="divider"></div>
                            </div>
                            <ul class="list-group list-group-unbordered">
                                <li class="list-group-item">
                                    <span class="info-box-text text-center text-muted"><b>Number</b></span>
                                    <span
                                        class="float-right info-box-number text-center text-muted mb-0">{{ $property->owner->OwnerStreetNumber ? $property->owner->OwnerStreetNumber:'--' }} </span>
                                </li>
                                <li class="list-group-item">
                                    <span class="info-box-text text-center text-muted"><b>Predirection</b></span>
                                    <span
                                        class="float-right info-box-number text-center text-muted mb-0">{{ $property->owner->OwnerStreetPreDir ? $property->owner->OwnerStreetPreDir:'--' }} </span>
                                </li>
                                <li class="list-group-item">
                                    <span class="info-box-text text-center text-muted"><b>Name</b></span>
                                    <span
                                        class="float-right info-box-number text-center text-muted mb-0">{{ $property->owner->OwnerStreetName ? $property->owner->OwnerStreetName:'--' }} </span>
                                </li>
                                <li class="list-group-item">
                                    <span class="info-box-text text-center text-muted"><b>Type</b></span>
                                    <span
                                        class="float-right info-box-number text-center text-muted mb-0">{{ $property->owner->OwnerStreetType ? $property->owner->OwnerStreetType:'--' }} </span>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <div class="head-text">
                                <h4 class="section-header">Geospatial Information</h4>
                                <div class="divider"></div>
                            </div>
                            <ul class="list-group list-group-unbordered">
                                <li class="list-group-item">
                                    <span class="info-box-text text-center text-muted"><b>Longitude</b></span>
                                    <span
                                        class="float-right info-box-number text-center text-muted mb-0">{{ $property->X_DD ? $property->X_DD:'--' }} </span>
                                </li>
                                <li class="list-group-item">
                                    <span class="info-box-text text-center text-muted"><b>Latitude</b></span>
                                    <span
                                        class="float-right info-box-number text-center text-muted mb-0">{{ $property->Y_DD ? $property->Y_DD:'--' }} </span>
                                </li>
                            </ul><br>
                            <div class="head-text">
                                <h4 class="section-header">Parsed Site Address</h4>
                                <div class="divider"></div>
                            </div>
                            <ul class="list-group list-group-unbordered">
                                <li class="list-group-item">
                                    <span class="info-box-text text-center text-muted"><b>Number</b></span>
                                    <span
                                        class="float-right info-box-number text-center text-muted mb-0">{{ $property->site->SiteStreetNumber ? $property->site->SiteStreetNumber:'--' }} </span>
                                </li>
                                <li class="list-group-item">
                                    <span class="info-box-text text-center text-muted"><b>Predirection</b></span>
                                    <span
                                        class="float-right info-box-number text-center text-muted mb-0">{{ $property->site->SiteStreetPreDir ? $property->site->SiteStreetPreDir:'--' }} </span>
                                </li>
                                <li class="list-group-item">
                                    <span class="info-box-text text-center text-muted"><b>Name</b></span>
                                    <span
                                        class="float-right info-box-number text-center text-muted mb-0">{{ $property->site->SiteStreetName ? $property->site->SiteStreetName:'--' }} </span>
                                </li>
                                <li class="list-group-item">
                                    <span class="info-box-text text-center text-muted"><b>Type</b></span>
                                    <span
                                        class="float-right info-box-number text-center text-muted mb-0">{{ $property->site->SiteStreetType ? $property->site->SiteStreetType:'--' }} </span>
                                </li>
                                <li class="list-group-item">
                                    <span class="info-box-text text-center text-muted"><b>Postdirection</b></span>
                                    <span
                                        class="float-right info-box-number text-center text-muted mb-0">{{ $property->site->SiteStreetPostDir ? $property->site->SiteStreetPostDir:'--' }} </span>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <div class="head-text">
                                <h4 class="section-header">Site Information</h4>
                                <div class="divider"></div>
                            </div>
                            <ul class="list-group list-group-unbordered">
                                <li class="list-group-item">
                                    <span class="info-box-text text-center text-muted"><b>Address</b></span>
                                    <span
                                        class="float-right info-box-number text-center text-muted mb-0">{{ $property->site->SiteAddress ? $property->site->SiteAddress:'--' }} </span>
                                </li>
                                <li class="list-group-item">
                                    <span class="info-box-text text-center text-muted"><b>Unit</b></span>
                                    <span
                                        class="float-right info-box-number text-center text-muted mb-0">{{ $property->site->SiteUnit ? $property->site->SiteUnit:'--' }} </span>
                                </li>
                                <li class="list-group-item">
                                    <span class="info-box-text text-center text-muted"><b>Unit</b></span>
                                    <span
                                        class="float-right info-box-number text-center text-muted mb-0">{{ $property->site->SiteCity ? $property->site->SiteCity:'--' }} </span>
                                </li>
                                <li class="list-group-item">
                                    <span class="info-box-text text-center text-muted"><b>State</b></span>
                                    <span
                                        class="float-right info-box-number text-center text-muted mb-0">{{ $property->site->SiteState ? $property->site->SiteState:'--' }} </span>
                                </li>
                                <li class="list-group-item">
                                    <span class="info-box-text text-center text-muted"><b>Zip</b></span>
                                    <span
                                        class="float-right info-box-number text-center text-muted mb-0">{{ $property->site->SiteZipCode ? $property->site->SiteZipCode:'--' }} </span>
                                </li>
                            </ul>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <p><strong>Upload Image</strong></p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form action="{{ url('/upload-custom-image') }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="col-md-3">Upload Image</label>
                            <div class="col-sm-9">
                                <input type="hidden" name="id" value="{{ $property->Id }}" class="form-control">
                                <input type="hidden" name="PropertyGID" value="{{ $property->PropertyGID }}"
                                       class="form-control">
                                <input type="file" name="file" class="form-control input-border" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content -->
@endsection
@section('scripts')
    <script>
        function initMap() {
            let lat = "{{ $property->Y_DD }}";
            let lng = "{{ $property->X_DD }}";
            // The location of Uluru
            let uluru = {lat: parseFloat(lat), lng: parseFloat(lng)};
            // The map, centered at Uluru
            let map = new google.maps.Map(
                document.getElementById('map'), {zoom: 6, center: uluru});
            // The marker, positioned at Uluru
            let marker = new google.maps.Marker({position: uluru, map: map});
        }
    </script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDE2i7RPzDbo7CajfIwJG2XOsRna7a9n70&callback=initMap">
    </script>
@endsection
