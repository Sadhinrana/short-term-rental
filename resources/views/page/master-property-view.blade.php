@extends('layouts.app')
@section('title')
    Master Property
@endsection

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/owl/owl.carousel.css') }}"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
    <style>
        .slick-dots {
            display: none !important;
        }
        .slick-dotted .slick-slide {
            width: auto !important;
        }
        hr{
            background: #609948
        }
        #map {
            width: 100%;
            height: 400px;
            margin-bottom: 5%;
        }
    </style>
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="">
                            <ul class="nav nav-tabs">
                                <li>
                                    <a  href="#activity" class="active" data-toggle="tab">Airbnb</a>
                                </li>
                                <li>
                                    <a  href="#timeline" data-toggle="tab">HomeWay</a>
                                </li>
                                <li>
                                    <a  href="#settings" data-toggle="tab">FlipKey</a>
                                </li>
                            </ul>
                        </div>

                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="activity">
                                    <div class="image-slide owl-carousel owl-carousel-center">
                                        @foreach($leaseAbuseProperty->region_listing_image as $row)
                                            <div class="item" style="background-image: url('{{ url($row->image) }}')"></div>
                                        @endforeach
                                    </div>
                                    <div class="margin-bottom-50">
                                        <h4 class="section-header"><i class="fas fa-check-circle"></i>&nbsp;<span>Match Details</span></h4>
                                        <div class="divider"></div>
                                        <p style="margin: 0"><strong>Explanation</strong></p>
                                        <p>{{ $leaseAbuseProperty->description }}</p>
                                        <p><strong>Listing Photos</strong></p>
                                        <div class="row mb-3">
                                            @foreach($leaseAbuseProperty->region_listing_image as $row)
                                                <div class="col-sm-2">
                                                    <a data-fancybox="gallery" href="{{ url($row->image) }}">
                                                        <div class="row-img" style="background-image: url('{{ url($row->image) }}')"></div>
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="margin-bottom-50">
                                        <h4 class="section-header">Listings Details</h4>
                                        <div class="divider"></div>
                                        <ul class="list-group list-group-unbordered mb-3">
                                            <li class="list-group-item">
                                                <strong>Listing URL</strong> <a class="float-right" target="_blank" href="{{ $leaseAbuseProperty->listingUrl }}">{{ $leaseAbuseProperty->listingUrl }}</a>
                                            </li>
                                            <li class="list-group-item">
                                                <strong>Listing Status</strong> <a class="float-right" >Not Found</a>
                                            </li>
                                            <li class="list-group-item">
                                                <strong>Host Compliance Listing ID</strong> <a class="float-right" >Not Found</a>
                                            </li>
                                            <li class="list-group-item">
                                                <strong>Listing Title</strong> <a class="float-right" >Not Found</a>
                                            </li>
                                            <li class="list-group-item">
                                                <strong>Property Type</strong> <a class="float-right" >Not Found</a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Room Type</b> <a class="float-right">{{ $leaseAbuseProperty->roomType }}</a>
                                            </li>
                                            <li class="list-group-item">
                                                <strong>Listing Info Last Capture</strong> <a class="float-right" >Not Found</a>
                                            </li>
                                            <li class="list-group-item">
                                                <strong>Screenshot Last Capture</strong> <a class="float-right" >Not Found</a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Price</b> <a class="float-right">{{$leaseAbuseProperty->currencySymbol.' '.$leaseAbuseProperty->price }}</a>
                                            </li>
                                            <li class="list-group-item">
                                                <strong>Cleaning Fee</strong> <a class="float-right" >Not Found</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="margin-bottom-50">
                                        <h4 class="section-header">Information Provided on Listing</h4>
                                        <div class="divider"></div>
                                        <ul class="list-group list-group-unbordered mb-3">
                                            <li class="list-group-item">
                                                <strong>Contact Name</strong> <a class="float-right" >Not Found</a>
                                            </li>
                                            <li class="list-group-item">
                                                <strong>Latitude</strong> <a class="float-right">{{ $leaseAbuseProperty->latitude }}</a>
                                            </li>
                                            <li class="list-group-item">
                                                <strong>Longitude</strong> <a class="float-right">{{ $leaseAbuseProperty->longitude}}</a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Minimum Stay(# of Nights)</b> <a class="float-right">{{ $leaseAbuseProperty->minNights }}</a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Max Sleeping Capacity(# of People)</b> <a class="float-right">Not Found</a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Number of Room</b> <a class="float-right">{{$masterProperty->num_room ? $masterProperty->num_room:'--' }}</a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Person Capacity</b> <a class="float-right">{{$leaseAbuseProperty->personCapacity }}</a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Number of Bedroom</b> <a class="float-right">{{$masterProperty->num_bedroom ? $masterProperty->num_bedroom:'--' }}</a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Number of Review</b> <a class="float-right">{{$leaseAbuseProperty->numReviews }}</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="tab-pane" id="timeline">
                                    N/A
                                </div>

                                <div class="tab-pane" id="settings">
                                    N/A
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div id="map"></div>
                            <div>
                                <h4 class="section-header">Information</h4>
                                <div class="divider"></div>
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <strong>Identified Address</strong><a class="float-right">{{ $masterProperty->address }}</a>
                                    </li>
                                    <li class="list-group-item">
                                       <strong>Identified Latitude, Longitude</strong><a class="float-right">{{ $masterProperty->latitude.', '.$masterProperty->longitude }}</a>
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Parcel Number</strong><a class="float-right">N/A</a>
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Owner Name</strong><a class="float-right">N/A</a>
                                    </li>
                                    <li class="list-group-item">
                                       <strong>Owner Address</strong><a class="float-right">N/A</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        function initMap() {
            let lat = "{{ $masterProperty->latitude }}";
            let lng = "{{ $masterProperty->longitude }}";
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
    <script type="text/javascript" src="{{ asset('plugins/owl/owl.carousel.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>

    <script>
        $('.owl-carousel-center').owlCarousel({
            center: true,
            rewind: true,
            margin:20,
            nav: true,
            navText: ['<img src="{{ asset('dist/img/ico-arrow-left.svg')}}">', '<img src="{{ asset('dist/img/ico-arrow-right.svg')}}">'],
            items: 2,
            dots: false
        });
        $('.owl-carousel-center').trigger('to.owl.carousel', 1)
    </script>

@endsection

