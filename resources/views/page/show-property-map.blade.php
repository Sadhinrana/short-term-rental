<!DOCTYPE html>
<html>
<meta charset='utf-8'/>
<title>Property Map</title>
<meta name='viewport' content='initial-scale=1,maximum-scale=1,user-scalable=no'/>
<script src='https://api.tiles.mapbox.com/mapbox-gl-js/v1.5.0/mapbox-gl.js'></script>
<link href='https://api.tiles.mapbox.com/mapbox-gl-js/v1.5.0/mapbox-gl.css' rel='stylesheet'/>
<link rel="stylesheet" href="{{ asset('/') }}plugins/fontawesome-free/css/all.min.css">
<!-- Tempusdominus Bbootstrap 4 -->
<link rel="stylesheet" href="{{ asset('/') }}plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
<!-- iCheck -->
<link rel="stylesheet" href="{{ asset('/') }}plugins/icheck-bootstrap/icheck-bootstrap.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="{{ asset('/') }}dist/css/adminlte.min.css">
<!-- overlayScrollbars -->
<link rel="stylesheet" href="{{ asset('/') }}plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
<!-- Daterange picker -->
<link rel="stylesheet" href="{{ asset('/') }}plugins/daterangepicker/daterangepicker.css">

<link rel="stylesheet" href="{{ asset('/') }}plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css">
<!-- summernote -->
<link rel="stylesheet" href="{{ asset('/') }}plugins/summernote/summernote-bs4.css">
<!-- Google Font: Source Sans Pro -->
<style>
    body {
        margin: 0;
        padding: 0;
    }

    #map {
        position: absolute;
        top: 0;
        bottom: 0;
        width: 85%;
        height: 820px;
        margin-top: 5%;
    }
</style>

<body class="hold-transition sidebar-mini layout-fixed">

<div class="wrapper">

    <!-- Navbar -->
@include('layouts.navbar')
<!-- /.navbar -->
    <!-- Main Sidebar Container -->
@include('layouts.sidebar')
<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <!-- /.content-header -->
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- SELECT2 EXAMPLE -->
                <div id='map'></div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    @include('layouts.footer')
</div>
<!-- ./wrapper -->
<!-- jQuery -->
<script src="{{ asset('/') }}plugins/jquery/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        window.value = '';
        get_data();
        mapboxgl.accessToken = 'pk.eyJ1IjoiYWJpcmRhczUwIiwiYSI6ImNrMzN3NTduYjAzNnozaHBlYmJzd3Y3bmQifQ.OcXyAvX8p52Atkv9BUqvOA';
        var map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/light-v10',
            center: [-96, 37.8],
            zoom: 3
        });
        map.on('load', function () {
            map.addLayer({
                "id": "points",
                "type": "symbol",
                "source": {
                    "type": "geojson",
                    "data": {
                        "type": "FeatureCollection",
                        "features": window.value,
                    }
                },
                "layout": {
                    "icon-image": ["concat", ["get", "icon"], "-15"],
                    "text-field": ["get", "title"],
                    "text-font": ["Open Sans Semibold", "Arial Unicode MS Bold"],
                    "text-offset": [0, 0.6],
                    "text-anchor": "top"
                }
            });

        });

        function get_data() {
            $.ajax({
                type: 'GET',
                url: "{{ route('property.map') }}",
                success: function (data) {
                    window.value = data;
                }
            })
        }
    });
</script>

<script src="{{ asset('/') }}plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('/') }}plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('/') }}plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="{{ asset('/') }}plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="{{ asset('/') }}plugins/sparklines/sparkline.js"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('/') }}plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="{{ asset('/') }}plugins/moment/moment.min.js"></script>
<script src="{{ asset('/') }}plugins/daterangepicker/daterangepicker.js"></script>

<script src="{{ asset('/') }}plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('/') }}plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="{{ asset('/') }}plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('/') }}plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="{{ asset('/') }}dist/js/adminlte.js"></script>

@yield('scripts')
</body>

</html>
