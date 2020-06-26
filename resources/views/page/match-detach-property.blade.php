@extends('layouts.app-pop')

@section('title')
    Rental Property
@endsection

@section('styles')
    <link rel="stylesheet" type="text/css" media="screen" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/slick/slick.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/slick/slick-theme.css') }}"/>
    <style>
        .slick-dots {
            display: none !important;
        }

        .slick-dotted .slick-slide {
            width: auto !important;
        }


        /* the slides */
        .slick-slide {
            margin: 0 5px;
        }

        /* the parent */
        .slick-list {
            margin: 0 -5px;
        }

        .border-btn {
            margin-bottom: 0px !important;
        }

        .text-head{
            font-size: 16px;
        }

        .nanobar .bar {
            background: #20c997;
            background: url("http://nanobar.jacoborus.codes/img/rainbow.gif");
        }
    </style>
@endsection

@section('content')
    <style>
        #map {
            width: 100%;
            height: 400px;
        }
        #nooPropertyMap {
            width: 100%;
            height: 400px;
        }
        .gm-style-mtc {
            display: none;
        }
        #floating-panel {
            position: absolute;
            left: 25%;
            z-index: 5;
            padding: 5px;
            text-align: center;
            font-family: 'Roboto','sans-serif';
            line-height: 30px;
            padding-left: 10px;
        }
        #floating-panel {
            margin-left: -100px;
        }
    </style>
    <section class="content" id="matched" style="display: none">
        <!-- The reverse image details modal -->
        <div class="modal" id="visionModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Vision Result</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-custom">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Text</th>
                                <th>Number</th>
                            </tr>
                            </thead>
                            <tbody>

                                <tr v-for="(row,key) in visionResults">
                                    <td>@{{ key+1 }}</td>
                                    <td><img :src="row.image" height="80" width="80"></td>
                                    <td>@{{ row.text }}</td>
                                    <td>@{{ row.number }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal" id="myModal">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <table class="table table-custom" id="editableTable" href="600px">
                            <thead>
                            <tr>
                                <th>Source</th>
                                <th>Format</th>
                                <th>height</th>
                                <th>Width</th>
                                <th>Scores</th>
                                <th> Image</th>
                                <th class="text-center">Image Size</th>
                            </tr>
                            </thead>
                            <tbody v-if="reverseImageResult !== null">
                            <tr v-for="res in reverseImageResult">
                                <td>
                                    <a :href="res.backlinks[0].backlink" target="_blank">@{{res.domain}}</a>
                                </td>
                                <td> @{{res.format}}</td>
                                <td> @{{res.height}}</td>
                                <td> @{{res.width}}</td>
                                <td> @{{res.score}}</td>
                                <td><img :src="res.image_url"></td>
                                <td class="text-center"> @{{res.filesize}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>

        <!-- End The reverse image details modal -->
        <div class="container-fluid">
            <div class="card card-default">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <div class="out-img">
                                <div class="row">
                                    <div class="col-md-4">
                                        <button class="btn btn-purple btn-block border-btn" @click="loadMasterProperty(previousMasterPropertyId)">
                                            <i class="fa fa-chevron-left"></i> &nbsp; Previous
                                        </button>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <a class="text-head text-center" data-toggle="modal" data-target="#modal-id" href="#" style="padding: 0;">
                                            @{{ masterProperty.listing_name }}
                                        </a>
                                    </div>
                                    <div class="col-md-4">
                                        <button class="btn btn-purple border-btn btn-block" @click="loadMasterProperty(nextMasterPropertyId)">Skip
                                            &nbsp;
                                            <i class="fa fa-chevron-right"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="margin-10"></div>
                                <div class="slider">
                                    <template v-for="row in masterPropertyImages">
                                        <a :href="row.image" class="fancybox">
                                            <img class="img-still show-img " :src="row.image">
                                        </a>
                                    </template>
                                </div>
                                <div class="margin-10"></div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="row justify-content-center">
                                            <h4>@{{ masterProperty.name }}</h4>
                                        </div>

                                        <div class="row justify-content-center">
                                            <h4>@{{ masterProperty.room_type }}</h4>
                                        </div>

                                        <div class="row justify-content-center">
                                            <div style="font-size: 14px;" class="h6">@{{ masterProperty.num_bedroom }}
                                                Bedrooms @{{ masterProperty.no_of_bathroom }} Bathrooms
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="slider-nav-thumbnails">
                                            <template v-for="row in masterPropertyImages">
                                                <img class="img-slick" :src="row.image">
                                            </template>
                                        </div>
                                    </div>
                                </div>
                                <div class="margin-10"></div>
                                <div class="margin-10"></div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-8">
                                            <div v-if="nooProperty">
                                                <h4>Host Information</h4>
                                            </div>
                                            <div v-if="host.image_url">
                                                <img :src="host.image_url" height="100px" width="100px"
                                                     style="border-radius: 50%;">
                                            </div>
                                            <div>
                                                <a href="javascript:void(0)" @click="HostDetails(host.id)">@{{ host.name }}</a>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <button class="btn mr-15 btn-default border-btn btn-block"
                                                    @click="getReverseImageResult()">Reverse Image &nbsp;
                                                <span v-if="!loading"> <i class="fa fa-info-circle"></i> </span> <span
                                                    v-if="loading"> <i class="fa fa-spinner fa-spin"></i></span>
                                            </button>
                                            <button class="btn mr-15 btn-default border-btn btn-block" @click="getVisionResult()">Viaion Result
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="row text-center">
                                <div class="col-4">
                                    <label for="">Matched</label>
                                    <p>@{{ matched }}</p>
                                </div>
                                <div class="col-4">
                                    <label for="">Unmatched</label>
                                    <p>@{{ unmatched }}</p>
                                </div>
                                <div class="col-4">
                                    <label for="">Unsure</label>
                                    <p>@{{ unsure }}</p>
                                </div>
                            </div>
                            <div class="row text-center">
                                <div class="col-4">
                                    <label for="">Street Number</label>
                                    <input v-on:keyup.enter="searchNOOPropertyByStreet" type="text" class="form-control" id="mapSearchStreetNo" placeholder="Street no...">
                                </div>
                                <div class="col-4">
                                    <label for="mapSearchHasPool">Pool?</label><br>
                                    <input type="checkbox" style="width: 26px; height: 26px;" v-on:change="searchNOOPropertyByStreet" value="1" id="mapSearchHasPool">
                                </div>
                                <div class="col-4">
                                    <label for="">Street Number</label>
                                    <input v-on:keyup.enter="searchNOOPropertyByStreet" type="text" class="form-control" id="mapSearchStreetName" placeholder="Street name...">
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-12 text-center mt-4">
                                    <div class="text-head m-auto">MATCH?</div>
                                    <button class="btn btn-yes border-btn" @click="voteYes()">Yes &nbsp; <i class="fa fa-check-circle"></i></button>
                                    <button class="btn border-btn btn-no" @click="voteNo()">No &nbsp; <i class="fa fa-times-circle"></i></button>
                                    <button class="btn btn-yellow border-btn" @click="voteUnsure()"> Unsure &nbsp; <i class="fa fa-question-circle"></i></button>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mt-5">
                                    <div id="map" class="m-auto"
                                         style="height: 350px; width: 350px; border-radius: 50%;"></div>
                                </div>
                                <div class="col-md-12 text-center mt-4">
                                    <button class="btn btn-default border-btn" style="margin-bottom: 10px;" @click="newWindowMap()">
                                        Map Link
                                    </button>
                                    <button class="btn btn-default border-btn" style="margin-bottom: 10px;" @click="detachWindowMap()">
                                        Detach Map
                                    </button>
                                </div>
                            </div>
                            <div class="margin-10"></div>
                        </div>
                        <div class="col-12 col-md-4" style="padding-left: 10px">
                            <div class="out-img">
                                <div class="row">
                                    <div class="col-md-4">
                                        <button class="btn btn-purple btn-block border-btn" @click="loadPreviousNooProperty()">
                                            <i
                                                class="fa fa-chevron-left"></i> &nbsp; Previous
                                        </button>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-head text-center" style="padding: 0;">
                                            @{{nooProperty.IDX_Address}}
                                            <br>
                                            <small v-if="nooProperty">Properties: <span id="passed">@{{ skippedNooProperty }}</span>/<span id="total">@{{ totalNooPropertyFound }}</span></small>
                                            <div v-if="nooProperty" class="progress">
                                                <div class="progress-bar" role="progressbar" :style="'width: '+ ((skippedNooProperty / totalNooPropertyFound) * 100).toFixed(0) +'%'" :aria-valuenow="((skippedNooProperty / totalNooPropertyFound) * 100).toFixed(0)" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <button class="btn btn-purple border-btn btn-block" @click="skipNooProperty()">Skip
                                            &nbsp;
                                            <i class="fa fa-chevron-right"></i></button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12" style="position: relative; top: -26px;">
                                        <button type="button" class="btn btn-default border-btn" value="Toggle Street View" @click="StreetViewMap" v-if="StreetViewMapButton==true"> Street View</button>
                                        <button type="button" class="btn btn-default border-btn" value="Toggle Street View" @click="SatelliteViewMap" v-if="SatelliteViewMapButton==true">Satellite View</button>
                                    </div>
                                </div>
                                <div id="nooPropertyMap" class="row justify-content-center"></div>
                                <div class="margin-10"></div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div style="border-right: 1px solid #6c6d69">
                                            <div v-if="nooProperty" class="row justify-content-center">
                                                <a :href="'/noo-property-owner/' + nooProperty.OwnerId"><h4>Owner Information</h4></a>
                                            </div>
                                            <div v-if="nooProperty" class="row justify-content-center">
                                                @{{nooProperty.OwnerName1}}
                                            </div>
                                            <div v-if="nooProperty" class="row justify-content-center">
                                                @{{nooProperty.OwnerAddress}}
                                            </div>
                                            <div v-if="nooProperty" class="row justify-content-center">
                                                @{{nooProperty.OwnerCity}}, @{{nooProperty.OwnerState}}
                                                @{{nooProperty.OwnerZipcode}}
                                            </div>
                                            <div v-if="nooProperty" class="row justify-content-center">
                                                Distance: @{{ (nooProperty.distance * 3280).toFixed(2) }} ft
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div v-if="nooProperty" class="row justify-content-center">
                                            <a :href="'/noo-property-details/' + nooProperty.propertyId"><h4>Site Information</h4></a>
                                        </div>
                                        <div v-if="nooProperty" class="row justify-content-center">
                                            @{{nooProperty.SiteAddress}}
                                        </div>
                                        <div v-if="nooProperty" class="row justify-content-center">
                                            @{{nooProperty.SiteCity}}, @{{nooProperty.SiteState}}
                                            @{{nooProperty.SiteZipCode}}
                                        </div>
                                        <a class="btn btn-default border-btn float-right" target="_blank"
                                           :href="'https://www.google.com/search?q='+nooProperty.SiteAddress+','+nooProperty.SiteCity+','+nooProperty.SiteState">Google</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12">&nbsp;</div>
                </div>
            </div>
        </div>

        <!-- Modals -->
        <div class="modal" id="voteYesModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Why they are matching ?</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Upload Picture:</label>
                                <input type="file" v-on:change="onImageChange" class="form-control" id="image">
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Message:</label>
                                <textarea class="form-control" v-model="comment" rows="5" id="comment"></textarea>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary" @click="voteYesComment()">Submit
                                </button>
                            </div>
                        </form>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-id">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Modal title</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="margin-bottom-50">
                            <h4 class="section-header">Listings Details</h4>
                            <div class="divider"></div>
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <strong>Listing URL</strong> <a class="float-right" target="_blank" :href="masterProperty.URL">@{{  masterProperty.URL }}</a>
                                </li>
                                <li class="list-group-item">
                                    <strong>Listing Status</strong> <a class="float-right">N/A</a>
                                </li>
                                <li class="list-group-item">
                                    <strong>Host Compliance Listing ID</strong> <a class="float-right">N/A</a>
                                </li>
                                <li class="list-group-item">
                                    <strong>Listing Title</strong> <a class="float-right">N/A</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Room Type</b> <a class="float-right">@{{  masterProperty.room_type }}</a>
                                </li>
                                <li class="list-group-item">
                                    <strong>Listing Info Last Capture</strong> <a class="float-right">N/A</a>
                                </li>
                                <li class="list-group-item">
                                    <strong>Screenshot Last Capture</strong> <a class="float-right">N/A</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Price</b> <a class="float-right">$@{{ masterProperty.price }}</a>
                                </li>
                                <li class="list-group-item">
                                    <strong>Cleaning Fee</strong> <a class="float-right">N/A</a>
                                </li>
                            </ul>
                        </div>
                        <div class="margin-bottom-50">
                            <h4 class="section-header">Information Provided on Listing</h4>
                            <div class="divider"></div>
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <strong>Contact Name</strong> <a class="float-right">N/A</a>
                                </li>
                                <li class="list-group-item">
                                    <strong>Latitude</strong> <a class="float-right">@{{  masterProperty.latitude }}</a>
                                </li>
                                <li class="list-group-item">
                                    <strong>Longitude</strong> <a class="float-right">@{{  masterProperty.longitude}}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Minimum Stay(# of Nights)</b> <a class="float-right">N/A</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Max Sleeping Capacity(# of People)</b> <a class="float-right">N/A</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Number of Room</b> <a class="float-right">@{{ masterProperty.num_room ?  masterProperty.num_room:'' }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Person Capacity</b> <a class="float-right">@{{ masterProperty.no_of_people }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Number of Bedroom</b> <a class="float-right">@{{ masterProperty.num_bedroom ?  masterProperty.num_bedroom:'' }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection


@section('scripts')

    <script src="https://raw.githubusercontent.com/HubSpot/pace/v1.0.0/pace.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/nanobar/0.4.2/nanobar.min.js" integrity="sha256-NO0pJ6CphG1cwHIt91QZQNiPgDEZCkuCDdVK2Sdz8ko=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.5.2/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.5.2/firebase-analytics.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.5.2/firebase-messaging.js"></script>
    <script type="text/javascript" src="{{ asset('plugins/slick/slick.js') }}"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDE2i7RPzDbo7CajfIwJG2XOsRna7a9n70"></script>
    <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
    <script>

        $(document).ready(function () {
            $('body').magnificPopup({
                delegate: 'a.fancybox',
                type: 'image'
            });
        });

        const vueApp = new Vue({
            el: '#matched',

            data: {
                matched: 0,
                unmatched: 0,
                unsure: 0,

                map :',',
                midMap: null,
                mapLoaded: false,
                newSearch: false,
                searched: false,
                nanobar: null,

                currentMasterPropertyId: '{{ $id }}',
                previousMasterPropertyId: '',
                nextMasterPropertyId: '',

                currentNooPropertyId: '',
                nextNooPropertyId: '',
                previousNooPropertyId: '',

                totalNooPropertyFound: 0,
                skippedNooProperty: 1,

                masterPropertyId: "{{ $id }}",
                nooProperty: '',
                nooPropertyArrayIndex: 0,
                type: "{{ (isset($_GET['q'])) ? $_GET['q'] : null }}",
                masterProperty: '',
                masterPropertyImages: '',
                slickRender: 0,
                MapData: '',
                NumberInImage: '',
                visionResults:null,
                reverseImageResult: null,
                loading: false,
                picture: '',
                comment: '',
                host: '',
                SatelliteViewMapButton:true,
                StreetViewMapButton:false,
            },

            mounted() {
                this.nanobar = new Nanobar();
                this.nanobar.go(30);

                let _this = this;
                this.MasterProperty();
                $('#matched').show();
                $(".master-property").show();
            },

            computed: {
                nooPropertyImage: function () {
                    return "https://maps.googleapis.com/maps/api/streetview?size=600x400&location=" + this.nooProperty.SiteAddress + "," + this.nooProperty.SiteCity + "" + this.nooProperty.SiteState + "" + this.nooProperty.SiteZipCode + "&key=AIzaSyDE2i7RPzDbo7CajfIwJG2XOsRna7a9n70";
                },
            },

            methods: {

                searchNOOPropertyByStreet(e) {
                    let _this = this;

                    if (typeof e != 'undefined') {
                        _this.newSearch = true;
                        _this.skippedNooProperty = 1;
                        _this.totalNooPropertyFound = 0;
                        propertyIndex = 0;
                        _this.nooPropertyArrayIndex = 0;
                    }

                    if (_this.searched) {
                        propertyIndex = _this.nooPropertyArrayIndex;
                    }

                    axios.get("{{ route('searchNOOPropertyByStreet') }}", {
                            params: {
                                masterPropertyId: _this.currentMasterPropertyId,
                                StreetNo: $('#mapSearchStreetNo').val(),
                                HasPool: $('#mapSearchHasPool').is(":checked"),
                                StreetName: $('#mapSearchStreetName').val(),
                                propertyIndex: propertyIndex,
                            }
                        })
                        .then(function(response) {
                            return response.data;
                        }).then(function(data) {

                            _this.midMap.getSource('clusters1').setData({
                                "type": "FeatureCollection",
                                "features": data.map_data,
                            });
                            _this.midMap.setCenter([data.property.X_DD, data.property.Y_DD]);

                            if (_this.newSearch === true) {
                                _this.MapData = data.property.map_data;
                                _this.totalNooPropertyFound = data.total_found;
                            }

                            _this.nooProperty = data.property;
                            _this.currentNooPropertyId = data.property.propertyId;
                            _this.searched = true;
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                },

                StreetViewMap(){
                    let _this = this;
                    _this.StreetViewMapButton = false;
                    _this.SatelliteViewMapButton = true;
                    let lat = parseFloat(_this.nooProperty.Y_DD);
                    let lng = parseFloat(_this.nooProperty.X_DD);
                    _this.map = new google.maps.StreetViewPanorama(
                        document.getElementById('nooPropertyMap'), {
                            position: {lat: lat, lng: lng},
                            pov: {heading: 165, pitch: 0},
                            motionTracking: false
                        });
                },

                SatelliteViewMap(){
                    let _this = this;
                    _this.StreetViewMapButton = true;
                    _this.SatelliteViewMapButton = false;
                    let lat = parseFloat(_this.nooProperty.Y_DD);
                    let lng = parseFloat(_this.nooProperty.X_DD);

                    var map = new google.maps.Map(document.getElementById('nooPropertyMap'), {
                        center: {lat: lat, lng: lng},
                        zoom: 18,
                        mapTypeId: 'satellite'
                    });

                    var markers = _this.MapData.map(function(location, i) {
                        return new google.maps.Marker({
                            map: map,
                            position: new google.maps.LatLng(parseFloat(location.geometry.coordinates[1]), parseFloat(location.geometry.coordinates[0]))
                        });
                    });

                    var markerCluster = new MarkerClusterer(map, markers, {
                        imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'
                    });

                    map.setTilt(45);
                },

                initMap(){
                    let _this = this;
                    let lat = parseFloat(_this.nooProperty.Y_DD);
                    let lng = parseFloat(_this.nooProperty.X_DD);

                    _this.map = new google.maps.StreetViewPanorama(
                        document.getElementById('nooPropertyMap'), {
                            position: {lat: lat, lng: lng},
                            pov: {heading: 165, pitch: 0},
                            motionTracking: false
                        });
                },

                onImageChange(e) {
                    let files = e.target.files || e.dataTransfer.files;
                    if (!files.length)
                        return;
                    this.createImage(files[0]);
                },

                createImage(file) {
                    let reader = new FileReader();
                    let vm = this;
                    reader.onload = (e) => {
                        vm.picture = e.target.result;
                    };
                    reader.readAsDataURL(file);
                },

                loadMasterProperty(masterPropertyId){
                    if (!masterPropertyId) {
                        swal('Opps!', 'No more propery found!', 'warning')
                        return;
                    }

                    let _this = this;

                    _this.nanobar.go(30);

                    axios.get('/api/getMasterProperty/' + masterPropertyId).then(response => {
                        return response.data;
                    }).then(masterProperty => {
                        this.masterProperty           = masterProperty.masterProperty;
                        this.currentMasterPropertyId  = masterProperty.masterProperty.id;
                        this.nextMasterPropertyId     = masterProperty.nextProperty;
                        this.previousMasterPropertyId = masterProperty.previousProperty;
                        this.masterPropertyImages     = masterProperty.images;
                        this.NumberInImage            = masterProperty.number;
                        this.visionResults            = masterProperty.visionResult
                        this.nooPropertyArrayIndex = 0;
                        this.NOOProperty();
                        this.ShowMapData();
                        this.HostInformation();
                        this.StreetViewMap();
                        _this.nanobar.go(40);

                        // Changing browser url
                        currentURLArr = location.href.split('/');
                        currentURLArr[5] = masterPropertyId;
                        window.history.pushState("string", "Rental Property", currentURLArr.join('/'));

                        setTimeout(function () {
                            _this.SlickSlider();
                            _this.nanobar.go(75);
                        }, 200);

                        setTimeout(function (){
                            axios.get('/get-vision-result/' + _this.currentMasterPropertyId).then(response => {
                                    return response.data;
                                }).then(visionData => {
                                    _this.NumberInImage = visionData.number;
                                    _this.visionResults = visionData.visionResult;
                                    _this.nanobar.go(100);
                                });
                        }, 1000);


                    }).catch(error => {
                        swal(
                          'Something went wrong!',
                          'error'
                        )
                    })
                },

                voteYesComment() {
                    event.preventDefault();
                    let _this = this;
                    let data = {
                        id: _this.currentMasterPropertyId,
                        index: _this.nooPropertyArrayIndex,
                        comment: _this.comment,
                        picture: _this.picture
                    }
                    axios.post('/api/yesVote/', data).then(response => {
                        _this.matched++;
                        $("#image").val("");
                        _this.comment = '';
                        _this.picture = '';
                        $("#voteYesModal").modal('hide');
                        if (_this.nextMasterPropertyId) {
                            _this.loadMasterProperty(_this.nextMasterPropertyId);
                        } else {
                            swal("No Next Rental Property!", {
                                icon: "warning",
                            });
                        }
                    })
                },

                HostInformation() {
                    axios.get('/api/host-information/' + this.currentMasterPropertyId).then(response => {
                        this.host = response.data;
                    });
                },

                /* Atik's code */
                getReverseImageResult() {
                    this.loading = true;
                    let cur = $('.slider').slick('slickCurrentSlide');
                    axios.get('/api/reverseImageResult?imgUrl=' + this.masterPropertyImages[cur].image_link).then(response => {
                        this.reverseImageResult = response.data.results.matches;
                        if (this.reverseImageResult) {
                            this.loading = false;
                            $('#myModal').modal();
                        }
                    });
                },
                /* End of Atik's code */

                getVisionResponse() {

                },

                getVisionResult(){
                    $("#visionModal").modal();
                },

                MasterProperty() {
                    let _this = this;
                    axios.get('/api/getMasterProperty/' + this.currentMasterPropertyId).then(response => {
                            _this.nanobar.go(45);
                            return response.data;
                        })
                        .then(masterProperty => {
                                _this.masterPropertyImages = masterProperty.images;
                                _this.masterProperty = masterProperty.masterProperty;

                                _this.currentMasterPropertyId = this.currentMasterPropertyId;
                                _this.nextMasterPropertyId = masterProperty.nextProperty;
                                _this.previousMasterPropertyId = masterProperty.previousProperty;
                                _this.NumberInImage = masterProperty.number;
                                _this.nooPropertyArrayIndex = 0;
                                _this.visionResults = masterProperty.visionResult;
                                _this.NOOProperty();
                                _this.ShowMapData();
                                _this.HostInformation();

                                setTimeout(function () {
                                    _this.SlickSlider();
                                    _this.nanobar.go(65);
                                }, 200)

                        }).finally(function() {
                            // setTimeout(function (){
                            //     axios.get('/get-vision-result/' + _this.currentMasterPropertyId).then(response => {
                            //             return response.data;
                            //         }).then(visionData => {
                            //             _this.NumberInImage = visionData.number;
                            //             _this.visionResults = visionData.visionResult;
                            //             _this.nanobar.go(100);
                            //     });
                            // }, 1000);
                        });
                },

                SlickSlider() {
                    if (this.slickRender === 1) {
                        $('.slider').slick('unslick');
                        $('.slider-nav-thumbnails').slick('unslick');
                    }
                    this.slickRender = 1;
                    $('.slider').slick({
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        fade: false,
                        asNavFor: '.slider-nav-thumbnails',
                    });
                    $('.slider-nav-thumbnails').slick({
                        slidesToShow: 5,
                        slidesToScroll: 1,
                        asNavFor: '.slider',
                        // dots: true,
                        focusOnSelect: true,
                        arrows: false,
                        responsive: [
                            {
                                breakpoint: 767,
                                settings: {
                                    slidesToShow: 3,
                                    slidesToScroll: 1,
                                }
                            },
                        ],
                    });
                },

                NOOProperty() {
                    let _this = this;
                    if (_this.NumberInImage) {

                        axios.get('/api/getNooProperty/' + this.currentMasterPropertyId + '/' + _this.nooPropertyArrayIndex).then(response => {
                            _this.nooProperty = response.data.property;
                            _this.MapData = response.data.map_data;

                            _this.totalNooPropertyFound = response.data.total_found;
                            _this.currentNooPropertyId = _this.nooProperty.propertyId;
                            _this.skippedNooProperty++;
                            _this.StreetViewMap();
                        })

                    } else {
                        setTimeout(function () {
                            axios.get('/api/getNooProperty/' + _this.currentMasterPropertyId + '/' + _this.nooPropertyArrayIndex).then(response => {
                                _this.nooProperty = response.data.property;
                                _this.MapData = response.data.map_data;

                                _this.totalNooPropertyFound = response.data.total_found;
                                _this.currentNooPropertyId = _this.nooProperty.propertyId;

                                _this.StreetViewMap();
                            })
                        }, 100)
                    }
                },

                voteNo() {
                    this.unmatched++;
                    this.nooPropertyArrayIndex++;
                    axios.get('/api/getNooProperty/' + this.currentMasterPropertyId + '/' + this.nooPropertyArrayIndex + '?type=1').then(response => {
                        this.nooProperty = response.data.property;
                        this.skippedNooProperty++;
                        this.StreetViewMap();
                        this.ShowMapData();
                    })
                },

                voteYes() {
                    $("#voteYesModal").modal('show');
                },

                voteUnsure() {
                    swal("Why they are unsure:", {
                        content: "input",
                    }).then((value) => {
                        this.nooPropertyArrayIndex++;
                        this.unsure++;
                        axios.get('/api/getNooProperty/' + this.currentMasterPropertyId + '/' + this.nooPropertyArrayIndex + '?type=2&comment=' + value).then(response => {
                            this.nooProperty = response.data.property;
                            this.skippedNooProperty++;
                            this.StreetViewMap();
                            this.ShowMapData();
                        })
                    });
                },

                skipNooProperty() {
                    let _this = this;

                    _this.newSearch = false;

                    if (_this.nooPropertyArrayIndex < _this.totalNooPropertyFound - 1) {
                        _this.nooPropertyArrayIndex++;
                    }else{
                        swal('Opps!', 'No more property found!', 'warning');
                        return false;
                    }


                    if (_this.searched) {
                        _this.skippedNooProperty++;
                        _this.searchNOOPropertyByStreet();
                        _this.StreetViewMap();
                    } else {
                        axios.get('/api/getNooProperty/' + _this.currentMasterPropertyId + '/' + _this.nooPropertyArrayIndex).then(response => {
                            return response.data;
                        }).then(data => {
                            _this.nooProperty = data.property;
                            _this.MapData = data.map_data;

                            _this.currentNooPropertyId = data.property.propertyId;
                            _this.skippedNooProperty++;
                            _this.StreetViewMap();

                            _this.midMap.getSource('clusters1').setData({
                                "type": "FeatureCollection",
                                "features": data.map_data,
                            });
                            _this.midMap.setCenter([data.property.X_DD, data.property.Y_DD]);
                        })
                    }
                },

                loadPreviousNooProperty() {
                    let _this = this;
                    _this.newSearch = false;

                    if (_this.nooPropertyArrayIndex > 0) {
                        _this.nooPropertyArrayIndex--;

                        _this.skippedNooProperty--;

                        if (_this.searched) {
                            _this.searchNOOPropertyByStreet()
                            _this.StreetViewMap();
                        } else {
                            axios.get('/api/getNooProperty/' + _this.currentMasterPropertyId + '/' + _this.nooPropertyArrayIndex).then(response => {
                                _this.nooProperty = response.data.property;
                                _this.StreetViewMap();

                                _this.midMap.getSource('clusters1').setData({
                                    "type": "FeatureCollection",
                                    "features": response.data.map_data,
                                });

                                _this.midMap.setCenter([response.data.property.X_DD, response.data.property.Y_DD]);
                            })
                        }
                    }
                },

                ShowMap(changeProperty = false) {
                    let _this = this;

                    if(changeProperty == true) {
                        _this.midMap.getSource('clusters1').setData({
                            "type": "FeatureCollection",
                            "features": this.MapData,
                        });

                        return;
                    }

                    let mapIds = 1;

                    let lat = _this.masterProperty.latitude;
                    let lng = _this.masterProperty.longitude;

                    const metersToPixelsAtMaxZoom = (meters, latitude) => meters / 0.075 / Math.cos(latitude * Math.PI / 180);

                    mapboxgl.accessToken = 'pk.eyJ1IjoiYWJpcmRhczUwIiwiYSI6ImNrMzN3NTduYjAzNnozaHBlYmJzd3Y3bmQifQ.OcXyAvX8p52Atkv9BUqvOA';

                    _this.midMap = new mapboxgl.Map({
                        container: 'map',
                        style: 'mapbox://styles/mapbox/light-v10',
                        center: [_this.nooProperty.X_DD, _this.nooProperty.Y_DD],
                        zoom: 13
                    });

                    let IDD = mapIds++;

                    setTimeout(function () {

                        _this.midMap.addSource('clusters' + IDD, {
                                type: "geojson",
                                data: {
                                    "type": "FeatureCollection",
                                    "features": _this.MapData,
                                }
                            }
                        );

                        _this.midMap.addLayer({
                            "id": "clusters1" + IDD,
                            "source": "clusters" + IDD,
                            'type': 'circle',
                            'paint': {
                                'circle-radius': 6,
                                'circle-color': '#B42222'
                            },
                            "filter": ["==", "modelId", 1],
                        });

                        _this.midMap.addLayer({
                            "id": "clusters22" + IDD,
                            "source": "clusters" + IDD,
                            'type': 'circle',
                            'paint': {
                                'circle-radius': 6,
                                'circle-color': '#0000FF'
                            },
                            "filter": ["==", "modelId", 3],
                        });

                        _this.midMap.addLayer({
                            "id": "clusters3" + IDD,
                            "type": "symbol",
                            "source": "clusters" + IDD,
                            "layout": {
                                "text-field": "{title}",
                                "text-font": ["Open Sans Semibold", "Arial Unicode MS Bold"],
                            },
                            "filter": ["==", "modelId", 2],
                        });

                        _this.midMap.addLayer({
                            "id": "clusters2" + IDD,
                            "type": "symbol",
                            "source": "clusters" + IDD,
                            "layout": {
                                "text-field": "{title}",
                                "text-font": ["Open Sans Semibold", "Arial Unicode MS Bold"],
                            }
                        });

                        _this.midMap.on('mouseenter', "clusters1" + IDD, function(e) {
                            _this.midMap.getCanvas().style.cursor = 'pointer';

                            var coordinates = e.features[0].geometry.coordinates.slice();
                            var description = e.features[0].properties.description;

                            while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                                coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                            }

                            popup.setLngLat(coordinates).setHTML(description).addTo(_this.midMap);

                        });

                        _this.midMap.on('mouseleave', "clusters1" + IDD, function() {
                            _this.midMap.getCanvas().style.cursor = '';
                            popup.remove();
                        });


                        let popup = new mapboxgl.Popup({
                            closeButton: false,
                            closeOnClick: false
                        });

                        _this.midMap.on('click', function (e) {
                            let features = _this.midMap.queryRenderedFeatures(e.point);
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
                                    _this.nooPropertyArrayIndex = displayFeatures[0].properties.id;

                                    setTimeout(function () {
                                        if (_this.searched) {
                                            axios.get("{{ route('searchNOOPropertyByStreet') }}", {
                                                params: {
                                                    masterPropertyId: _this.currentMasterPropertyId,
                                                    StreetNo: $('#mapSearchStreetNo').val(),
                                                    HasPool: $('#mapSearchHasPool').is(":checked"),
                                                    StreetName: $('#mapSearchStreetName').val(),
                                                    propertyIndex: _this.nooPropertyArrayIndex,
                                                }
                                            })
                                            .then(function(response) {
                                                return response.data;
                                            }).then(function(data) {

                                                _this.midMap.getSource('clusters1').setData({
                                                    "type": "FeatureCollection",
                                                    "features": data.map_data,
                                                });
                                                _this.midMap.setCenter([data.property.X_DD, data.property.Y_DD]);

                                                _this.nooProperty = data.property;
                                                _this.MapData = data.property.map_data;

                                                _this.currentNooPropertyId = data.property.propertyId;
                                            })
                                            .catch(function(error) {
                                                console.log(error);
                                            });
                                        } else {
                                            axios.get('/api/getNooProperty/' + _this.masterPropertyId + '/' + _this.nooPropertyArrayIndex).then(nooPropertyResponse => {
                                                _this.nooProperty = nooPropertyResponse.data.property;
                                                _this.currentNooPropertyId = nooPropertyResponse.data.property.propertyId;
                                                _this.MapData = nooPropertyResponse.data.map_data;
                                                _this.midMap.getSource('clusters' + IDD).setData({
                                                    "type": "FeatureCollection",
                                                    "features": _this.MapData,
                                                });
                                                _this.midMap.setCenter([nooPropertyResponse.data.property.X_DD, nooPropertyResponse.data.property.Y_DD]);
                                            })
                                        }

                                        _this.StreetViewMap();

                                    }, 200)

                                }
                            }
                        });

                        // _this.midMap.setCenter([_this.nooProperty.X_DD, _this.nooProperty.Y_DD]);

                    }, 400);
                },

                ShowMapData(changeProperty = false) {
                    axios.get('/noo-property-data?id=' + this.currentMasterPropertyId+'&index='+this.nooPropertyArrayIndex).then(response => {
                        this.MapData = response.data;
                        let _this = this;
                        setTimeout(function () {
                            _this.ShowMap(changeProperty);

                        }, 400)
                    })
                },

                newWindowMap() {
                    let url = '/rental-property/match-map/' + this.currentMasterPropertyId;
                    let myWindow = window.open(url, "Property Map", "width=800,height=600");
                },

                detachWindowMap() {
                    let url = '/rental-property/detach/' + this.currentMasterPropertyId;
                    let myWindow = window.open(url, "Property Detach Map", "width=" + screen.width + ",height=" + screen.height);
                },

                openReverseImageLink(link) {
                    window.open(link, '_blank');
                },

                HostDetails(id){
                    let url = "/host-details/"+id;
                    window.open(url, '_blank');
                }
            }
        })
    </script>
@endsection
