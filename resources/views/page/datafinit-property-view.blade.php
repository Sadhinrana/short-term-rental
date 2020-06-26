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
                                        @if(isset($dataFinitiProperty->image))
                                        @foreach($dataFinitiProperty->image as $row)
                                            <div class="item" style="background-image: url('{{ url($row->image) }}')"></div>
                                        @endforeach
                                        @endif
                                    </div>
                                    <div class="margin-bottom-50">
                                        <h4 class="section-header"><i class="fas fa-check-circle"></i>&nbsp;<span>Match Details</span></h4>
                                        <div class="divider"></div>
                                        <p style="margin: 0"><strong>Explanation</strong></p>
                                        <p>{{ isset($dataFinitiProperty->rules)?$dataFinitiProperty->rules:'' }}</p>
                                        <p><strong>Listing Photos</strong></p>
                                        <div class="row mb-3">
                                            @if(isset($dataFinitiProperty->image))
                                            @foreach($dataFinitiProperty->image as $row)
                                                <div class="col-sm-2">
                                                    <a data-fancybox="gallery" href="{{ url($row->image) }}">
                                                        <div class="row-img" style="background-image: url('{{ url($row->image) }}')"></div>
                                                    </a>
                                                </div>
                                            @endforeach
                                            @endif
                                        </div>
                                    </div>

                                    <div class="margin-bottom-50">
                                        <h4 class="section-header">Listings Details</h4>
                                        <div class="divider"></div>
                                        <ul class="list-group list-group-unbordered mb-3">
                                            <li class="list-group-item">
                                                <strong>Listing URL</strong> <a class="float-right" target="_blank" href="{{ $masterProperty->URL }}">{{ $masterProperty->URL }}</a>
                                            </li>
                                            <li class="list-group-item">
                                                <strong>Listing Status</strong> <a class="float-right" >N/A</a>
                                            </li>
                                            <li class="list-group-item">
                                                <strong>Host Compliance Listing ID</strong> <a class="float-right" >N/A</a>
                                            </li>
                                            <li class="list-group-item">
                                                <strong>Listing Title</strong> <a class="float-right" >N/A</a>
                                            </li>
                                            <li class="list-group-item">
                                                <strong>Property Type</strong> <a class="float-right" >{{ isset($dataFinitiProperty->property_type)?$dataFinitiProperty->property_type:'' }}</a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Room Type</b> <a class="float-right">{{ $masterProperty->room_type }}</a>
                                            </li>
                                            <li class="list-group-item">
                                                <strong>Listing Info Last Capture</strong> <a class="float-right" >N/A</a>
                                            </li>
                                            <li class="list-group-item">
                                                <strong>Screenshot Last Capture</strong> <a class="float-right" >N/A</a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Price</b> <a class="float-right">{{'$ '.$masterProperty->price }}</a>
                                            </li>
                                            <li class="list-group-item">
                                                <strong>Cleaning Fee</strong> <a class="float-right" >N/A</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="margin-bottom-50">
                                        <h4 class="section-header">Information Provided on Listing</h4>
                                        <div class="divider"></div>
                                        <ul class="list-group list-group-unbordered mb-3">
                                            <li class="list-group-item">
                                                <strong>Contact Name</strong> <a class="float-right" >N/A</a>
                                            </li>
                                            <li class="list-group-item">
                                                <strong>Latitude</strong> <a class="float-right">{{ $masterProperty->latitude }}</a>
                                            </li>
                                            <li class="list-group-item">
                                                <strong>Longitude</strong> <a class="float-right">{{ $masterProperty->longitude}}</a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Minimum Stay(# of Nights)</b> <a class="float-right">N/A</a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Max Sleeping Capacity(# of People)</b> <a class="float-right">N/A</a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Number of Room</b> <a class="float-right">{{$masterProperty->num_room ? $masterProperty->num_room:'' }}</a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Person Capacity</b> <a class="float-right">{{$masterProperty->no_of_people }}</a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Number of Bedroom</b> <a class="float-right">{{$masterProperty->num_bedroom ? $masterProperty->num_bedroom:'' }}</a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Number of Review</b> <a class="float-right">{{ isset($dataFinitiProperty->review)?count($dataFinitiProperty->review):0 }}</a>
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

                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Votes</h4>
                        </div>
                        <div class="card-body">
                            @if(!$votes->isEmpty())
                            <div>
                                <table class="table-custom" style="width: 100%">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>User</th>
                                        <th>Vote</th>
                                        <th>Votted At</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($votes as $vote)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $vote->user->name }}</td>
                                            <td>
                                                @if($vote->vote == 1)
                                                    <span class="badge badge-danger">No</span>
                                                @elseif($vote->vote == 2)
                                                    <span class="badge badge-warning">Unsure</span>
                                                @else
                                                    <span class="badge badge-success">Matched</span>
                                                @endif
                                            </td>
                                            <td>{{ $vote->created_at->diffForHumans() }}</td>
                                            <td>
                                                @if($vote->vote == 3)
                                                    <button data-toggle="modal" data-target="#vote{{ $vote->id }}" class="btn btn-success btn-xs">Show details</button></td>
                                                @else
                                                    <span class="text-gray">Not available</span>
                                                @endif
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Closest Noo Properties</h4>
                        </div>
                        <div class="card-body">
                            <table class="table-custom" style="width: 100%">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Address</th>
                                    <th>Google Image</th>
                                    <th>Distance in Feet</th>
                                    <th>Owner Name</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($closestsProperty)
                                    @foreach($closestsProperty as $key=>$row)
                                        @php($owner = \App\Owner::find($row->OwnerId))
                                        @php($link = "https://www.google.com/search?q=".$row->IDX_Address)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td><a target="_blank" href="{{ $link }}">{{ $row->IDX_Address }}</a></td>
                                            <td>
                                                @if($row->image)
                                                    <a data-toggle="modal" href="javascript:void(0)" class="NooPropertyImage"
                                                       id="{{ $row->id }}" data-id="{{ $row->id }}" data-target="#exampleModalCenter"><img src="{{ asset($row->image) }}" height="60" width="80"></a>
                                                @else
                                                    No Image Available
                                                @endif
                                            </td>
                                            <td>{{ number_format($row->distance,2) }} KM</td>
                                            <td>{{ $owner->OwnerName1 }}</td>
                                            <td><a title="Details" target="_blank" class="btn btn-primary btn-xs" href="{{ url('/noo-property-details',$row->id) }}"><i class="fas fa-info-circle"></i></a></td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" class="text-center">No Data Found</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
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
                            @if(!$comments->isEmpty())
                            <div>
                                <h4 class="section-header">Comments</h4>
                                <div class="divider"></div>

                                <table class="table-custom" style="width: 100%">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Picture</th>
                                        <th>User</th>
                                        <th>Comment</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                        @foreach($comments as $key=>$row)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>
                                            @if($row->picture)
                                                <img src="{{ url($row->picture) }}" height="60" width="60" style="border-radius: 50%">
                                                @endif
                                        </td>
                                        <td>{{ $row->user->name }}</td>
                                        <td>{{ $row->comments }}</td>
                                    </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                                @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @foreach($votes as $vote)
    <div class="modal fade" id="vote{{ $vote->id }}">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Votted By {{ $vote->user->name }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <strong for="">Comment</strong>
                        <p>{{ $vote->comments }}</p>
                    </div>
                    <div class="form-group">
                        <strong for="">Image</strong>
                        <img src="{{ asset($vote->picture) }}" class="img-thumbnail">
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
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

