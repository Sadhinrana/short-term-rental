<style>
    #map {
        position: absolute;
        width: 100%;
        height: 600px;
    }
</style>
<section class="content" id="matched">
    <div class="container-fluid">
        <!-- SELECT2 EXAMPLE -->
        <div class="card card-default">
            <div class="card-body">
                <div class="col-12 align-self-center">
                    <div class="col-md-12" id="map"></div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="{{ asset('/') }}plugins/jquery/jquery.min.js"></script>
<script src='https://api.tiles.mapbox.com/mapbox-gl-js/v1.5.0/mapbox-gl.js'></script>
<link href='https://api.tiles.mapbox.com/mapbox-gl-js/v1.5.0/mapbox-gl.css' rel='stylesheet' />
<script>
    $(document).ready(function () {
        get_data();
        let mapData = [];
        let mapIds = 1;
        let lat = "{{ $latitude }}";
        let lng = "{{ $longitude }}";
        mapboxgl.accessToken = 'pk.eyJ1IjoiYWJpcmRhczUwIiwiYSI6ImNrMzN3NTduYjAzNnozaHBlYmJzd3Y3bmQifQ.OcXyAvX8p52Atkv9BUqvOA';
        const metersToPixelsAtMaxZoom = (meters, latitude) => meters / 0.075 / Math.cos(latitude * Math.PI / 180)
        var map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/light-v10',
            center: [lng, lat],
            zoom: 12
        });

        function show_map() {
            console.log(mapData);
            let IDD = mapIds++;
            map.addSource('clusters' + IDD, {
                    type: "geojson",
                    data: {
                        "type": "FeatureCollection",
                        "features": mapData
                    }
                }
            );
            map.addLayer({
                "id": "clusters1" + IDD,
                "source": "clusters" + IDD,
                'type': 'circle',
                'paint': {
                    'circle-radius': 6,
                    'circle-color': '#B42222'
                },
                "filter": ["==", "modelId", 1],
            });
            // map.addLayer({
            //     "id": "clusters2" + IDD,
            //     "source": "clusters" + IDD,
            //     'type': 'circle',
            //     'paint': {
            //         'circle-radius': 6,
            //         'circle-color': '#1cb429'
            //     },
            //     "filter": ["==", "modelId", 2],
            // });
            map.addLayer({
                "id": "clusters3" + IDD,
                "type": "circle",
                "source": "clusters" + IDD,
                "paint": {
                    "circle-radius": {
                        stops: [
                            [0, 0],
                            [20, metersToPixelsAtMaxZoom(1500, "{{ $latitude }}")]
                        ],
                        base: 2
                    },
                    "circle-color": "#D3D3D3",
                    "circle-opacity": 0.6
                },
                "filter": ["==", "modelId", 2],
            });
            map.addLayer({
                "id": "clusters2" + IDD,
                "type": "symbol",
                "source": "clusters" + IDD,
                "layout": {
                    "text-field": "{title}",
                    "text-font": ["Open Sans Semibold", "Arial Unicode MS Bold"],
                }
            });
        }

        function get_data() {
            $.ajax({
                type: 'GET',
                url: "/noo-property-data?id=" + "{{ $id }}",
                success: function (data) {
                    mapData = data;
                    show_map();
                }
            })
        }

    });

</script>
