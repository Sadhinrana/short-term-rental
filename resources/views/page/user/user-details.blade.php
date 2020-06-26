@extends('layouts.app')
@section('title')
    User
@endsection
@section('content')
    <style>
        #map {
            width: 98%;
            height: 500px;
        }
    </style>
    <section class="content" id="changed">
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-7">
                    <div class="card">
                        <div class="">
                            <ul class="nav nav-tabs">
                                <li>
                                    <a href="#timeline" class="active" data-toggle="tab">Timeline</a>
                                </li>
                                <li>
                                    <a href="#details" data-toggle="tab">Details</a>
                                </li>
                                <li>
                                    <a href="#analytics-view" data-toggle="tab">analytics view</a>
                                </li>
                                {{--                                <li>--}}
                                {{--                                    <a href="#settings" data-toggle="tab">FlipKey</a>--}}
                                {{--                                </li>--}}
                            </ul>
                        </div>

                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="timeline">
                                    <!-- The timeline -->
                                    <div class="timeline timeline-inverse">
                                        <!-- timeline time label -->
                                        @foreach($voteDate as $key => $date)
                                            @php($votes = \App\MatchProperty::whereDate('created_at',$date->date)->where('user_id',$date->user_id)->get())
                                            @if($key % 2==0)
                                                @php($class="bg-primary")
                                            @elseif($key % 3 == 0)
                                                @php($class="bg-success")
                                            @else
                                                @php($class="bg-danger")
                                            @endif
                                            <div class="time-label">
                                            <span class="{{ $class }}">
                                              {{ date('d M, Y',strtotime($date->date)) }}
                                            </span>
                                            </div>
                                            <!-- /.timeline-label -->
                                            <!-- timeline item -->
                                            @foreach($votes as $row)
                                                <div>
                                                    @if($row->vote==3)
                                                        <i class="fas fa-vote-yea bg-success"></i>
                                                    @elseif($row->vote==1)
                                                        <i class="fas fa-times bg-danger"></i>
                                                    @elseif($row->vote==2)
                                                        <i class="fas fa-times bg-warning"></i>
                                                    @endif
                                                    <div class="timeline-item">
                                                        <span class="time"><i class="far fa-clock"></i> {{ date('H:i',strtotime($row->created_at)) }}</span>

                                                        <h3 class="timeline-header"><a href="#">Master
                                                                property</a> {{ $row->masterPropertyTitle }}</h3>
                                                        <div class="timeline-body">
                                                            <div class="row">
                                                                <div class="col-md-11">
                                                                    {{ $row->masterPropertyTitle }}
                                                                    @if($row->vote==3)
                                                                        <strong>Yes Vote</strong>
                                                                        to  {{ $row->nooPropertyTitle }}
                                                                    @elseif($row->vote==1)
                                                                        <strong>No Vote
                                                                            </strong> to {{ $row->nooPropertyTitle }}
                                                                    @elseif($row->vote==2)
                                                                        <strong>Unsure Vote</strong> to {{ $row->nooPropertyTitle }}
                                                                    @endif
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <span style="float: right">
                                                                        <a @click="VoteChange({{ $row->id }})" title="Change Vote" class="change-vote" href="javascript:void(0)" data-toggle="modal" data-target="#exampleModalCenter"><i class="fas fa-exchange-alt"></i></a>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        @endforeach
                                    @endforeach
                                    <!-- END timeline item -->
                                        <!-- timeline time label -->
                                    </div>
                                </div>

                                <div class="tab-pane" id="details">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <strong>Name</strong><a class="float-right">{{ $userDetails->name }}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Email</strong><a class="float-right">{{ $userDetails->email }}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Role</strong><a class="float-right">{{ $userDetails->role ? 'Admin' : 'User' }}</a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="tab-pane" id="analytics-view">
                                       <div class="card">
                                           <div class="card-body">
                                            <ul class="list-group">
                                                <li class="list-group-item">
                                                    <strong>Total Vote</strong><a class="float-right">{{$userDetails->all_vote->count()}}</a>
                                                </li>
                                                <li class="list-group-item">
                                                    <strong>Matched Vote</strong><a class="float-right">{{$userDetails->match_vote->count()}}</a>
                                                </li>
                                                <li class="list-group-item">
                                                    <strong>Unatched Vote</strong><a class="float-right"> {{$userDetails->missmatch_vote->count()}} </a>
                                                </li>
                                            </ul>
                                           </div>
                                       </div>
                                </div>

                                <div class="tab-pane" id="settings">
                                    N/A
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile" id='map'>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Change Your Vote</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-5 align-self-center">
                                <div class="justify-content-center">
                                    <h5 style="margin-left: 3%;margin-top: 3%">
                                        <strong>@{{ property.MasterPropertyTitle }}</strong>
                                    </h5>
                                </div>
                                <div class="row justify-content-center">
                                    <img :src="property.MasterPropertyImage" height="300" width="400">
                                </div>
                                <div class="row justify-content-center">
                                    <h4>@{{ property.name }}</h4>
                                </div>
                                <div class="row justify-content-center">
                                    <h4>@{{ property.roomType }}</h4>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="h6">@{{  property.num_bedroom }}
                                        Bedrooms @{{  property.no_of_bathroom }} Bathrooms
                                    </div>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="row justify-content-center h1">Match?</div>
                                <div class="row justify-content-center" @click="VoteYes(property.id)" v-if="property.vote != 3" style="margin-top: 100px">
                                    <button class="btn btn-success" >Yes</button>
                                </div>
                                <div class="row justify-content-center" v-if="property.vote != 1" style="margin-top: 40px">
                                    <button class="btn btn-danger"  @click="VoteNo(property.id)" >No</button>
                                </div>
                                <div class="row justify-content-center" @click="VoteUnsure(property.id)" v-if="property.vote != 2" style="margin-top: 40px">
                                    <button class="btn btn-warning" >Unsure</button>
                                </div>
                            </div>
                            <div class="col-5" style="padding-left: 10px">
                                <div class="row justify-content-center">
                                    <h1>@{{property.NooPropertyTitle}}</h1>
                                </div>
                                <div class="row justify-content-center">
                                    <img :src="property.NooPropertyImage" height="300" width="400">
                                </div>
                                <div class="row justify-content-center">
                                    <h2>Owner Information</h2>
                                </div>
                                <div class="row justify-content-center">
                                    @{{property.OwnerName1}}
                                </div>
                                <div  class="row justify-content-center">
                                    @{{property.OwnerAddress}}
                                </div>
                                <div  class="row justify-content-center">
                                    @{{property.OwnerCity}}, @{{property.OwnerState}} @{{property.OwnerZipcode}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
@section('scripts')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        const vueApp = new Vue({
            el: '#changed',
            data:{
                property:''
            },
            methods: {
                VoteChange(id){
                    axios.get('/api/match-property-by-id/'+id).then(response=>{
                        this.property = response.data;
                    });
                },
                VoteYes(id){
                    axios.get('/api/update-vote/'+id+'/3').then(response=>{
                        window.location.reload();
                    })
                },
                VoteNo(id){
                    axios.get('/api/update-vote/'+id+'/1').then(response=>{
                        window.location.reload();
                    })
                },
                VoteUnsure(id){
                    axios.get('/api/update-vote/'+id+'/2').then(response=>{
                        window.location.reload();
                    })
                }
            }
        })
        $(document).ready(function(){
            let mapData = [];
            get_data();
            mapboxgl.accessToken = 'pk.eyJ1IjoiYWJpcmRhczUwIiwiYSI6ImNrMzN3NTduYjAzNnozaHBlYmJzd3Y3bmQifQ.OcXyAvX8p52Atkv9BUqvOA';
            var map = new mapboxgl.Map({
                container: 'map',
                style: 'mapbox://styles/mapbox/light-v10',
                center: [-81.03668, 29.28888],
                zoom: 10
            });

            function show_map(){
                map.addSource('clusters', {
                        type: "geojson",
                        data: {
                            "type": "FeatureCollection",
                            "features": mapData
                        }
                    }
                );
                map.addLayer({
                    "id": "clusters1",
                    "source": "clusters",
                    'type': 'circle',
                    'paint': {
                        'circle-radius': 6,
                        'circle-color': '#B42222'
                    },
                    "filter": ["==", "modelId", 1],
                });
                map.addLayer({
                    "id": "clusters2",
                    "source": "clusters",
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
                    url: "/user-property-map/"+"{{ $id }}",
                    success: function (response) {
                        mapData = response.data;
                        let avglng = response.avglng;
                        let avglat = response.avglat;
                        show_map();
                    }
                })
            }
        });
    </script>
@endsection
