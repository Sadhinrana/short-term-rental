@extends('layouts.app')
@section('title')
    Rental Property Map
@endsection
@section('content')
    <style>
        #map {
            position: absolute;
            top: 0;
            bottom: 0;
            width: 100%;
            height: 800px;
        }
    </style>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- SELECT2 EXAMPLE -->
            <div class="card card-default">

                <div class="row">
                    <div id='map' class="col-md-12"></div>
                </div>
                <!-- /.card-body -->
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
@section('scripts')
    <script src="https://www.gstatic.com/firebasejs/7.5.2/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.5.2/firebase-analytics.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.5.2/firebase-messaging.js"></script>
    <script>
        $(document).ready(function () {
            get_data();
            let mapData = [];
            let mapIds = 1;
            let lat = "{{ $lat }}";
            let lng = "{{ $lng }}";
            var config = {
                apiKey: "AIzaSyCgD0QTsObsy9TqxCX0Pjohqp_xa9sgquM",
                authDomain: "shorttermrental-8c9e6.firebaseapp.com",
                databaseURL: "https://shorttermrental-8c9e6.firebaseio.com",
                projectId: "shorttermrental-8c9e6",
                storageBucket: "shorttermrental-8c9e6.appspot.com",
                messagingSenderId: "527825715913",
                appId: "1:527825715913:web:eec180af251e10b9468318",
                measurementId: "G-6Y4R7Q3PX6"
            };
            firebase.initializeApp(config);
            navigator.serviceWorker.register("{{url('/firebase-messaging-sw.js')}}").then(function(){
                const messaging = firebase.messaging();
                messaging.requestPermission().then(function () {
                    return messaging.getToken();
                }).then(function (token) {
                    registerFcmToken(token);
                }).catch(function (err) {
                    console.log(err);
                });
                messaging.onMessage(function(payload) {
                    console.log(payload.data.masterPropertyID);
                    if (payload.data.vote == 3) {
                        var modeId = 2
                    } else {
                        var modeId = 1
                    }

                    for(i=0; i < mapData.length; i++) {
                        if (mapData[i].pId == payload.data.masterPropertyID) {
                            mapData[i].properties.modelId = modeId;
                        }
                    }
                    show_map();
                });
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            function registerFcmToken(token){
                var param = {token: token};
                $.ajax({
                    //Your register Url
                    url: "{{ url('/registerFcmToken') }}",
                    type: 'post',
                    data: param,
                    success: function(res){
                        console.log(res)
                    }
                });
            }
            mapboxgl.accessToken = 'pk.eyJ1IjoiYWJpcmRhczUwIiwiYSI6ImNrMzN3NTduYjAzNnozaHBlYmJzd3Y3bmQifQ.OcXyAvX8p52Atkv9BUqvOA';
            var map = new mapboxgl.Map({
                container: 'map',
                style: 'mapbox://styles/mapbox/light-v10',
                center: [lng, lat],
                zoom: 10
            });

            function show_map(){
                let IDD = mapIds++;
                map.addSource('clusters'+IDD, {
                        type: "geojson",
                        data: {
                            "type": "FeatureCollection",
                            "features": mapData
                        }
                    }
                );
                map.addLayer({
                    "id": "clusters1"+IDD,
                    "source": "clusters"+IDD,
                    'type': 'circle',
                    'paint': {
                        'circle-radius': 6,
                        'circle-color': '#B42222'
                    },
                    "filter": ["==", "modelId", 1],
                });
                map.addLayer({
                    "id": "clusters2"+IDD,
                    "source": "clusters"+IDD,
                    'type': 'circle',
                    'paint': {
                        'circle-radius': 6,
                        'circle-color': '#1cb429'
                    },
                    "filter": ["==", "modelId", 2],
                });
            }

            function get_data() {
                $.ajax({
                    type: 'GET',
                    url: "/rental-property-map",
                    success: function (data) {
                        mapData = data;
                        show_map();
                    }
                })
            }
        });
    </script>
@endsection
