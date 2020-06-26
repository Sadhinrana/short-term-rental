@extends('layouts.app')
@section('title')
    LeaseAbuse Property Details
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
                            <!-- /.card-header -->
                            <div class="row">
                                <div class="col-12 col-sm-2">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Latitude</span>
                                            <span class="info-box-number text-center text-muted mb-0">{{ $details->latitude }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-2">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Longitude</span>
                                            <span class="info-box-number text-center text-muted mb-0">{{ $details->longitude }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-2">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Name</span>
                                            <span class="info-box-number text-center text-muted mb-0">{{ $details->region->name }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-2">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Type</span>
                                            <span class="info-box-number text-center text-muted mb-0">{{ $details->region->type }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-2">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Host Name</span>
                                            <span class="info-box-number text-center text-muted mb-0">{{ $details->hostName }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-2">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Date Crawled</span>
                                            <span class="info-box-number text-center text-muted mb-0">{{ $details->dateCrawled }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12">
                                    <div class="card">
                                        <div class="card-header border-transparent">
                                            <h3 class="card-title">Review</h3>
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body p-0 review">
                                            @include('page.region-listing-review')
                                            <!-- /.table-responsive -->
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-2">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">External ID</span>
                                            <span class="info-box-number text-center text-muted mb-0">{{ $details->externalId }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-10">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Description</span>
                                            <span class="info-box-number text-muted mb-0">{{ $details->description }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-2">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Host ID</span>
                                            <span class="info-box-number text-center text-muted mb-0">{{ $details->hostId }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-2">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Source</span>
                                            <span class="info-box-number text-center text-muted mb-0">{{ $details->source }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-2">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">User Id</span>
                                            <span class="info-box-number text-center text-muted mb-0">{{ $details->userId }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-2">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Person Capacity</span>
                                            <span class="info-box-number text-center text-muted mb-0">{{ $details->personCapacity }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-2">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Total Image</span>
                                            <span class="info-box-number text-center text-muted mb-0">{{ $details->totalImages }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-2">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Min Night</span>
                                            <span class="info-box-number text-center text-muted mb-0">{{ $details->minNights }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">About The Host</span>
                                            <span class="info-box-number text-muted mb-0">{{ $details->aboutTheHost }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-2">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Price</span>
                                            <span class="info-box-number text-center text-muted mb-0">{{ $details->price }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Detailed Address</span>
                                            <span class="info-box-number text-center text-muted mb-0">{{ $details->detailedAddress }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-2">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Name</span>
                                            <span class="info-box-number text-center text-muted mb-0">{{ $details->name }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Listing Url</span>
                                            <span class="info-box-number text-muted mb-0"><a target="_blank" href="{{ $details->listingUrl }}">{{ $details->listingUrl }}</a></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">About The Listing</span>
                                            <span class="info-box-number text-muted mb-0">{{ $details->aboutTheListing }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-2">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Currency</span>
                                            <span class="info-box-number text-center text-muted mb-0">{{ $details->currency }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-2">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Room Type</span>
                                            <span class="info-box-number text-center text-muted mb-0">{{ $details->roomType }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Listing Images</span>
                                            <span class="info-box-number text-muted mb-0" style="height: 500px;overflow: scroll;">
                                                    @foreach($details->region_listing_image as $key=> $row)
                                                        <a data-toggle="modal" href="javascript:void(0)" class="image" id="{{ $key }}" data-target="#exampleModalCenter" ><img src="{{ asset($row->image) }}"
                                                                class="img-rounded" alt="Responsive Image" style="padding: 8px 0; width: 48%" height="240" /></a>&nbsp;&nbsp;
                                                    @endforeach
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Listing Screenshots</span>
                                            <span class="info-box-number text-muted mb-0" style="height: 500px;overflow: scroll;">
                                                @foreach($details->region_listing_screeshot as $key=> $row)
                                                    <a href="{{ asset($row->image) }}" target="_blank"><img src="{{ asset($row->image) }}" class="img-rounded" alt="Responsive Image"  style="padding: 8px 0;width: 100%"/></a><br><br>
                                                @endforeach
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>
    <!-- /.content -->
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            $(document).on('click', '#review .pagination a', function (event) {
                $('li').removeClass('active');
                $(this).parent('li').addClass('active');
                event.preventDefault();
                var url = $(this).attr('href');
                var keywords = $(".keywords").val();
                getProperty(url, keywords);
            });
            $(document).on('click','.image',function(){
                let id = "{{ $details->id }}";
                let image_id = $(this).attr('id');
                $.ajax({
                    url: "/leaseabuse-property-details/"+id,
                    type: "GET",
                    datatype: "html",
                    data: {
                        "image_id": image_id,
                    }
                }).done(function (data) {
                   $(".modal-body").html(data);
                });
            });
            function getProperty(url, keywords) {
                $.ajax({
                    url: url,
                    type: "GET",
                    datatype: "html",
                    data: {
                        "keywords": keywords,
                    }
                }).done(function (data) {
                    $(".review").html(data);
                });
            }
        });
    </script>
@endsection

