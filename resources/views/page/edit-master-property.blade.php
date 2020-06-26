@extends('layouts.app')
@section('title')
    Edit Master Property
@endsection
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- SELECT2 EXAMPLE -->
            <div class="card card-default">
                <form action="{{ route('update.master.property') }}" method="post">
                    {{ csrf_field() }}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control input-border" name="name" value="{{ $masterProperty->name }}">
                                    <input type="hidden" class="form-control input-border" name="id" value="{{ $masterProperty->id }}">
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Latitude</label>
                                    <input type="text" class="form-control input-border" name="latitude" value="{{ $masterProperty->latitude }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Longitude</label>
                                    <input type="text" class="form-control input-border" name="longitude" value="{{ $masterProperty->longitude }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>URL</label>
                                    <input type="text" class="form-control input-border" name="URL" value="{{ $masterProperty->URL }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Listing Name</label>
                                    <input type="text" class="form-control input-border" name="listing_name" value="{{ $masterProperty->listing_name }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Room Type</label>
                                    <input type="text" class="form-control input-border" name="room_type" value="{{ $masterProperty->room_type }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Floor Size Value</label>
                                    <input type="text" class="form-control input-border" name="floor_size_value" value="{{ $masterProperty->floor_size_value }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Floor Size Unit</label>
                                    <input type="text" class="form-control input-border" name="floor_size_unit" value="{{ $masterProperty->floor_size_unit }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Price</label>
                                    <input type="text" class="form-control input-border" name="price" value="{{ $masterProperty->price }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="text" class="form-control input-border" name="address" value="{{ $masterProperty->address }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>No of People</label>
                                    <input type="text" class="form-control input-border" name="no_of_people" value="{{ $masterProperty->no_of_people }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>No of Bathroom</label>
                                    <input type="text" class="form-control input-border" name="no_of_bathroom" value="{{ $masterProperty->no_of_bathroom }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>No of Bedroom</label>
                                    <input type="text" class="form-control input-border" name="num_bedroom" value="{{ $masterProperty->num_bedroom }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>No of Floor</label>
                                    <input type="text" class="form-control input-border" name="num_floor" value="{{ $masterProperty->num_floor }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>No of Room</label>
                                    <input type="text" class="form-control input-border" name="num_room" value="{{ $masterProperty->num_room }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Data Source</label>
                                    <input type="text" class="form-control input-border" name="data_source" value="{{ $masterProperty->data_source }}">
                                </div>
                            </div>
                            <div class="col-md-12 text-right">
                                <button class="btn btn-primary"><i class="fas fa-check"></i> Update</button>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- /.card-body -->

            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
