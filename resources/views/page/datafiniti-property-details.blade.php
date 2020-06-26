@extends('layouts.app')
@section('title')
    Master Property Details
@endsection
<style>
    #map {
        position: absolute;
        top: 0;
        bottom: 0;
        width: 98%;
        height: 600px;
        margin-top: 2%;
    }
</style>
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- SELECT2 EXAMPLE -->
            <div class="card card-default">
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div id='map' class="col-md-12"></div>
                        <div class="col-md-12" style="margin-top: 40%;">
                            <!-- /.card-header -->
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Name</span>
                                            <span class="info-box-number text-center text-muted mb-0">{{ $masterProperty->name }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-2">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Latitude</span>
                                            <span class="info-box-number text-center text-muted mb-0">{{  $masterProperty->latitude  }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-2">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Longitude</span>
                                            <span class="info-box-number text-center text-muted mb-0">{{ $masterProperty->longitude }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">URL</span>
                                            <span class="info-box-number text-center text-muted mb-0"><a href="{{ $masterProperty->URL }}" target="_blank">{{ $masterProperty->URL }}</a></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-2">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Listing Name</span>
                                            <span class="info-box-number text-center text-muted mb-0">{{ $masterProperty->listing_name  }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-2">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Room Type</span>
                                            <span class="info-box-number text-center text-muted mb-0">{{ $masterProperty->room_type  }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-2">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Floor Size Value</span>
                                            <span class="info-box-number text-center text-muted mb-0">{{ $masterProperty->floor_size_value  }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-2">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Floor Size Unit</span>
                                            <span class="info-box-number text-center text-muted mb-0">{{ $masterProperty->floor_size_unit }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-2">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Price</span>
                                            <span class="info-box-number text-center text-muted mb-0">{{ $masterProperty->price }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-3">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Address</span>
                                            <span class="info-box-number text-center text-muted mb-0">{{ $masterProperty->address  }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-2">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">No of People</span>
                                            <span class="info-box-number text-center text-muted mb-0">{{ $masterProperty->no_of_people }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-2">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">No of Bathroom</span>
                                            <span class="info-box-number text-center text-muted mb-0">{{ $masterProperty->no_of_bathroom }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-2">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">No of Bedroom</span>
                                            <span class="info-box-number text-center text-muted mb-0">{{ $masterProperty->num_bedroom }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-2">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">No of Floor</span>
                                            <span class="info-box-number text-center text-muted mb-0">{{ $masterProperty->num_floor }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-2">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">No of Room</span>
                                            <span class="info-box-number text-center text-muted mb-0">{{ $masterProperty->num_room }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12">
                                    <div class="card">
                                        <div class="card-header border-transparent">
                                            <h3 class="card-title">Closest NOO Properties</h3>
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body p-0 review">
                                            <table class="table table-bordered table-hover table-striped">
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
                                                        <td>{{ $row->distance }} KM</td>
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
                                <div class="col-12 col-sm-12">
                                    <div class="card">
                                        <div class="card-header border-transparent">
                                            <h3 class="card-title">Description</h3>
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body p-0">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Value</th>
                                                        <th>Source URLs</th>
                                                        <th>Date Seen</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if(!$description->isEmpty())
                                                        @foreach($description as $key => $row)
                                                            @php($sourceURLs = json_decode($row->source_URL))
                                                            <tr>
                                                                <td>{{ $key+1 }}</td>
                                                                <td>{{ $row->value }}</td>
                                                                <td>
                                                                    @php($i=0)
                                                                    @foreach($sourceURLs as $url)
                                                                        <a target="_blank" href="{{ $url }}">{{ $url  }}</a> {{ $i==0 ? '':', '   }}
                                                                        @php($i++)
                                                                    @endforeach
                                                                </td>
                                                                <td>{{ $row->date_seen }}  </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan="5" class="text-center">No Data Found.</td>
                                                        </tr>
                                                    @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- /.table-responsive -->
                                        </div>

                                    </div>
                                    <!-- /.card -->
                                </div>
                                <div class="col-12 col-sm-12">
                                    <div class="card">
                                        <div class="card-header border-transparent">
                                            <h3 class="card-title">Feature</h3>
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body p-0">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Key</th>
                                                        <th>Value</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if(!$feature->isEmpty())
                                                        @foreach($feature as $key => $row)
                                                            @php($value = json_decode($row->value))
                                                            <tr>
                                                                <td>{{ $key+1 }}</td>
                                                                <td>{{ $row->key }}</td>
                                                                <td>{{ implode(", ",$value) }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan="5" class="text-center">No Data Found.</td>
                                                        </tr>
                                                    @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- /.table-responsive -->
                                        </div>

                                    </div>
                                    <!-- /.card -->
                                </div>
                                <div class="col-12 col-sm-12">
                                    <div class="card">
                                        <div class="card-header border-transparent">
                                            <h3 class="card-title">People</h3>
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body p-0">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Name</th>
                                                            <th>Title</th>
                                                            <th>Date Seen</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if(!$people->isEmpty())
                                                        @foreach($people as $key => $row)
                                                            <tr>
                                                                <td>{{ $key+1 }}</td>
                                                                <td>{{ $row->name }}</td>
                                                                <td>{{ $row->title }}</td>
                                                                <td>{{ $row->date_seen }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan="7" class="text-center">No Data Found.</td>
                                                        </tr>
                                                    @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- /.table-responsive -->
                                        </div>
                                    </div>
                                    <!-- /.card -->
                                </div>
                                <div class="col-12 col-sm-12">
                                    <div class="card">
                                        <div class="card-header border-transparent">
                                            <h3 class="card-title">Prices</h3>
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body p-0">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Amount Max</th>
                                                        <th>Amount Min</th>
                                                        <th>Currency</th>
                                                        <th>Date Seen</th>
                                                        <th>Is Sale</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if(!$price->isEmpty())
                                                            @foreach($price as $key => $row)
                                                                @php($date_seen = json_decode($row->date_seen))
                                                                <tr>
                                                                    <td>{{ $key+1 }}</td>
                                                                    <td>{{ number_format($row->amount_max,2) }}</td>
                                                                    <td>{{ number_format($row->amount_min,2) }}</td>
                                                                    <td>{{ $row->currency }}</td>
                                                                    <td>{{ implode(", ",$date_seen) }}</td>
                                                                    <td>{{ $row->is_sale }}</td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td colspan="7" class="text-center">No Data Found.</td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- /.table-responsive -->
                                        </div>

                                    </div>
                                    <!-- /.card -->
                                </div>

                                <div class="col-12 col-sm-12">
                                    <div class="card">
                                        <div class="card-header border-transparent">
                                            <h3 class="card-title">Review</h3>
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body p-0">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Date</th>
                                                        <th>Date Seen</th>
                                                        <th>Rating</th>
                                                        <th>Source URLs</th>
                                                        <th>Text</th>
                                                        <th>User Name</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if(!$review->isEmpty())
                                                        @foreach($review as $key => $row)
                                                            @php($source_url = json_decode($row->source_URL))
                                                            <tr>
                                                                <td>{{ $key+1 }}</td>
                                                                <td>{{ $row->date }}</td>
                                                                <td>{{ $row->date_seen }}</td>
                                                                <td>{{ $row->rating }}</td>
                                                                <td>
                                                                    @php($i=0)
                                                                    @foreach($sourceURLs as $url)
                                                                        <a target="_blank" href="{{ $url }}">{{ $url  }}</a> {{ $i==0 ? '':', '   }}
                                                                        @php($i++)
                                                                    @endforeach
                                                                </td>
                                                                <td>{{ $row->description }}</td>
                                                                <td>{{ $row->user_name }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan="7" class="text-center">No Data Found.</td>
                                                        </tr>
                                                    @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- /.table-responsive -->
                                        </div>

                                    </div>
                                    <!-- /.card -->
                                </div>
                                <div class="col-12 col-sm-12">
                                    <div class="card">
                                        <div class="card-header border-transparent">
                                            <h3 class="card-title">Status</h3>
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body p-0">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Type</th>
                                                        <th>Source URLs</th>
                                                        <th>Date Seen</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if(!$status->isEmpty())
                                                        @foreach($status as $key => $row)
                                                            @php($source_url = json_decode($row->source_URL))
                                                            @php($date_seen = json_decode($row->date_seen))
                                                            <tr>
                                                                <td>{{ $key+1 }}</td>
                                                                <td>{{ $row->type }}</td>
                                                                <td>
                                                                    @php($i=0)
                                                                    @foreach($sourceURLs as $url)
                                                                        <a target="_blank" href="{{ $url }}">{{ $url  }}</a> {{ $i==0 ? '':', '   }}
                                                                        @php($i++)
                                                                    @endforeach
                                                                </td>
                                                                <td>{{ implode(", ",$date_seen) }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan="7" class="text-center">No Data Found.</td>
                                                        </tr>
                                                    @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- /.table-responsive -->
                                        </div>

                                    </div>
                                    <!-- /.card -->
                                </div>
                                <div class="col-sm-6">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Property Image</span>
                                            <span class="info-box-number text-muted mb-0"
                                                  style="height: 500px;overflow: scroll;">
                                            @foreach($imageData as $key=> $row)
                                                    <a data-toggle="modal" href="javascript:void(0)" class="image"
                                                       id="{{ $key }}" data-target="#exampleModalCenter"><img
                                                            src="{{ $row['image'] }}"
                                                            class="img-rounded" alt="Responsive Image"
                                                            style="padding: 8px 0; width: 48%" height="240"/></a>
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
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
<script src='https://api.tiles.mapbox.com/mapbox-gl-js/v1.5.0/mapbox-gl.js'></script>
<link href='https://api.tiles.mapbox.com/mapbox-gl-js/v1.5.0/mapbox-gl.css' rel='stylesheet'/>
@section('scripts')
<script>
    const metersToPixelsAtMaxZoom = (meters, latitude) => meters / 0.075 / Math.cos(latitude * Math.PI / 180)
    $(document).ready(function () {
        window.value = '';
        get_data();

        setTimeout( function () {
            mapboxgl.accessToken = 'pk.eyJ1IjoiYWJpcmRhczUwIiwiYSI6ImNrMzN3NTduYjAzNnozaHBlYmJzd3Y3bmQifQ.OcXyAvX8p52Atkv9BUqvOA';
            var map = new mapboxgl.Map({
                container: 'map',
                style: 'mapbox://styles/mapbox/light-v10',
                center: ["{{ $masterProperty->longitude }}", "{{ $masterProperty->latitude }}"],
                zoom: 12,

            });
            map.on("load", function () {
                map.addSource('clusters', {
                        type: "geojson",
                        data: {
                            "type": "FeatureCollection",
                            "features": window.value
                        }
                    }
                );
                map.addLayer({
                    "id": "clusters1",
                    "type": "circle",
                    "source": "clusters",
                    "paint": {
                        "circle-radius": {
                            stops: [
                                [0, 0],
                                [20, metersToPixelsAtMaxZoom(1500, {{ $masterProperty->latitude }})]
                            ],
                            base: 2
                        },
                        "circle-color": "#D3D3D3",
                        "circle-opacity": 0.6
                    },
                    "filter": ["==", "modelId", 1],
                });
                map.addLayer({
                    "id": "clusters2",
                    "type": "symbol",
                    "source": "clusters",
                    "layout": {
                        "text-field": "{title}",
                        "text-font": ["Open Sans Semibold", "Arial Unicode MS Bold"],
                    }
                });
                map.on('click', function (e) {
                    let features = map.queryRenderedFeatures(e.point);
                    let displayProperties = [
                        "properties",
                    ];
                    let displayFeatures = features.map(function (feat) {
                        let displayFeat = {};
                        displayProperties.forEach(function (prop) {
                            displayFeat[prop] = feat[prop];
                        });
                        return displayFeat;
                    });
                    if (displayFeatures[0].properties.id) {
                        if (displayFeatures.length > 0 && displayFeatures[0].properties.id != 0) {
                            let url = '/noo-property-details/' + displayFeatures[0].properties.id;
                            window.open(url, '_blank');
                        }
                    }
                });
            });
        }, 2000);


        function get_data() {
            $.ajax({
                type: 'GET',
                url: "{{ route('master.property.details',[$masterProperty->id]) }}",
                success: function (data) {
                    window.value = data;
                }
            })
        }

        $(document).on('click', '.image', function () {
            let id = "{{ $masterProperty->id }}";
            let image_id = $(this).attr('id');
            $.ajax({
                url: "/leaseabuse-property-details/" + id,
                type: "GET",
                datatype: "html",
                data: {
                    "image_id": image_id,
                    "id": id,
                }
            }).done(function (data) {
                console.log(data);
                $(".modal-body").html(data);
            });
        });
        $(".NooPropertyImage").click(function () {
            let id = $(this).attr('id');
            $.ajax({
                url: "/image-object",
                type: "GET",
                datatype: "html",
                data: {
                    "id": id,
                }
            }).done(function (data) {
                $(".modal-body").html(data);
            });
        });
    });
</script>
@endsection
