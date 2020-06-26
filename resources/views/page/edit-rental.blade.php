@extends('layouts.app')
@section('title')
    Edit Datafiniti Property
@endsection
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- SELECT2 EXAMPLE -->
            <form method="POST" action="{{ url('/edit-rental') }}" id="edit_rental_form">
                {{ csrf_field() }}
                <div class="card card-default">
{{--                    <div class="card-header">--}}
{{--                        --}}
{{--                    </div>--}}
                <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <!-- /.card-header -->
                                <div class="row">
                                    <div class="col-12 col-sm-3">
                                        <div class="form-group">
                                            <label class="">ID</label>
                                            <input type="hidden" value="{{ $rentDetails->id }}" name="id">
                                            <input type="text" name="rent_id" value="{{ $rentDetails->rent_id }}" class="form-control input-border input-border">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="form-group">
                                            <label class="">Address</label>
                                            <textarea class="form-control input-border" name="address">{{ $rentDetails->address ? $rentDetails->address:''  }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="form-group">
                                            <label class="">Available Date</label>
                                            <input type="text" name="available_date" class="form-control input-border datetimepicker" value="{{ $rentDetails->available_date }}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="form-group">
                                            <label class="">Brokers</label>
                                            <input type="text" name="brokers" class="form-control input-border" value="{{ $rentDetails->brokers }}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="form-group">
                                            <label class="">Building Name</label>
                                            <input type="text" value="{{ $rentDetails->building_name }}" class="form-control input-border" name="building_name">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="form-group">
                                            <label class="">City</label>
                                            <select class="form-control input-border" name="city_id">
                                                @foreach($cities as $row)
                                                    <option value="{{ $row->id }}" {{ $rentDetails->city_id==$row->id ? 'selected':'' }}>{{ $row->city_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="form-group">
                                            <label class="">Country</label>
                                            <select class="form-control input-border" name="country_id">
                                                @foreach($countries as $row)
                                                    <option value="{{ $row->id }}" {{ $rentDetails->country_id==$row->id ? 'selected':'' }}>{{ $row->country_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="form-group">
                                            <label class="">Date Added</label>
                                            <input type="text" name="date_added" class="form-control input-border" value="{{ $rentDetails->date_added }}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="form-group">
                                            <label class="">Date Updated</label>
                                            <input type="text" value="{{ $rentDetails->date_updated }}" name="date_updated" class="form-control input-border">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="form-group">
                                            <label class="">Geo Location</label>
                                            <input type="text" value="{{ $rentDetails->geo_location }}" name="geo_location" class="form-control input-border">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="form-group">
                                            <label class="">Hours</label>
                                            <input type="text" value="{{ $rentDetails->hours }}" name="hours" class="form-control input-border">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12">
                                        <div class="margin-10"></div>
                                        <div class="margin-10"></div>
                                        <div class="margin-10"></div>
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title">Deposit</h3>
                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body ">
                                                <div class="table-responsive">
                                                    <table class="table  table-custom deposit-table">
                                                        <thead>
                                                        <tr>
                                                            <th>Currency</th>
                                                            <th>Amount</th>
                                                            <th>Date Seen</th>
                                                            <th>Source URLs</th>
                                                            <th class="text-center">Action</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @if(!$deposit->isEmpty())
                                                            @foreach($deposit as $key => $row)
                                                                <tr>
                                                                    <td><input type="text" value=" {{ $row->currency }} " name="deposit_currency[]" class="form-control input-border"></td>
                                                                    <td><input type="text" value="{{ $row->amount }}" name="deposit_amount[]" class="form-control input-border"></td>
                                                                    <td>
                                                                        @php($date_seen = json_decode($row->date_seen))
                                                                        @php($sourceURLs = json_decode($row->source_URL))
                                                                        <input type="text" value=" {{ implode(", ", $date_seen) }} " name="deposit_date_seen[]" class="form-control input-border">
                                                                    </td>
                                                                    <td>
                                                                        @php($i=0)
                                                                        @foreach($sourceURLs as $url)
                                                                            <input type="text" value=" {{ $url }} " name="deposit_source_url[]" class="form-control input-border">
                                                                            @php($i++)
                                                                        @endforeach
                                                                    </td>
                                                                    <td class="text-center"><button type="button" class="btn btn-danger btn-xs delete-btn"><i class="fas fa-times"></i></button></td>
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
                                        <div class="margin-10"></div>
                                        <div class="margin-10"></div>
                                        <div class="margin-10"></div>
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title">Description</h3>
                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body ">
                                                <div class="table-responsive">
                                                    <table class="table  table-custom description-table">
                                                        <thead>
                                                        <tr>
                                                            <th width="60%">Value</th>
                                                            <th>Source URLs</th>
                                                            <th>Date Seen</th>
                                                            <th class="text-center">Action</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @if(!$description->isEmpty())
                                                            @foreach($description as $key => $row)
                                                                @php($sourceURLs = json_decode($row->source_URL))
                                                                <tr>
                                                                    <td><textarea class="form-control input-border" rows="3" name="description_value[]">{{ $row->value }}</textarea></td>
                                                                    <td>
                                                                        @php($i=0)
                                                                        @foreach($sourceURLs as $url)
                                                                            <input type="text" value=" {{ $url }} " name="description_source_url[]" class="form-control input-border">
                                                                            @php($i++)
                                                                        @endforeach
                                                                    </td>
                                                                    <td><input type="text" class="form-control input-border" name="description_date_seen[]" value="{{ $row->date_seen }}"></td>
                                                                    <td class="text-center"><button type="button" class="btn btn-danger btn-xs delete-btn"><i class="fas fa-times"></i></button></td>
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
                                        <div class="margin-10"></div>
                                        <div class="margin-10"></div>
                                        <div class="margin-10"></div>
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title">Feature</h3>
                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body ">
                                                <div class="table-responsive">
                                                    <table class="table table-custom feature-table">
                                                        <thead>
                                                        <tr>
                                                            <th>Key</th>
                                                            <th>Value</th>
                                                            <th class="text-center">Action</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @if(!$feature->isEmpty())
                                                            @foreach($feature as $key => $row)
                                                                @php($value = json_decode($row->value))
                                                                <tr>
                                                                    <td><input type="text" value="{{ $row->key }}" class="form-control input-border" name="feature_key[]"></td>
                                                                    <td><input type="text" value="{{ implode(",",$value) }}" name="feature_value[]" class="form-control input-border"></td>
                                                                    <td class="text-center"><button type="button" class="btn btn-danger btn-xs delete-btn"><i class="fas fa-times"></i></button></td>
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
                                        <div class="margin-10"></div>
                                        <div class="margin-10"></div>
                                        <div class="margin-10"></div>
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title">Fees</h3>
                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body ">
                                                <div class="table-responsive">
                                                    <table class="table table-custom fees-table">
                                                        <thead>
                                                        <tr>
                                                            <th>Type</th>
                                                            <th>Date Seen</th>
                                                            <th>Source URLs</th>
                                                            <th>Currency</th>
                                                            <th>Amount Min</th>
                                                            <th>Amount Max</th>
                                                            <th class="text-center">Action</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @if(!$fees->isEmpty())
                                                            @foreach($fees as $key => $row)
                                                                @php($date_seen = json_decode($row->date_seen))
                                                                @php($sourceURLs = json_decode($row->source_URL))
                                                                <tr>
                                                                    <td><input type="text" value="{{ $row->type }}" name="fees_type[]" class="form-control input-border"></td>
                                                                    <td><input type="text" class="form-control input-border" value="{{ implode(",", $date_seen) }}" name="fees_date_seen[]"></td>
                                                                    <td>
                                                                        @php($i=0)
                                                                        @foreach($sourceURLs as $url)
                                                                            <input type="text" value="{{ $url }}" name="fees_source_url[]" class="form-control input-border">
                                                                            @php($i++)
                                                                        @endforeach
                                                                    </td>
                                                                    <td><input type="text" value="{{ $row->currency }}" name="fees_currency[]" class="form-control input-border"></td>
                                                                    <td><input type="text" value="{{ $row->amount_min }}" name="fees_amount_min[]" class="form-control input-border"></td>
                                                                    <td><input type="text" value="{{ $row->amount_max }}" name="fees_amount_max[]" class="form-control input-border"></td>
                                                                    <td class="text-center"><button type="button" class="btn btn-danger btn-xs delete-btn"><i class="fas fa-times"></i></button></td>
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
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <label class="">Images URLs</label>
                                            <textarea class="form-control input-border" rows="5" name="image_url">{{ $rentDetails->image_url }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <label class="">Key</label>
                                            <input type="text" value="{{ $rentDetails->key }}" class="form-control input-border" name="key">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="">
                                            <div class="form-group">
                                                <label class="">Language Spoken</label>
                                                <span class="info-box-number text-muted mb-0"><input type="text" class="form-control input-border" value="{{ $rentDetails->languages_spoken }}" name="languages_spoken"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="">
                                            <div class="form-group">
                                                <label class="">Latitude</label>
                                                <span class="info-box-number text-muted mb-0"><input type="text" class="form-control input-border" name="latitude" value="{{ $rentDetails->latitude }}"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="">
                                            <div class="form-group">
                                                <label class="">Leasing Terms</label>
                                                <span class="info-box-number text-muted mb-0"><input type="text" class="form-control input-border" value="{{ $rentDetails->leasing_terms }}" name="leasing_terms"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="">
                                            <div class="form-group">
                                                <label class="">Listing Name</label>
                                                <span class="info-box-number text-muted mb-0"><input type="text" name="listing_name" value="{{ $rentDetails->listing_name }}" class="form-control input-border"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="">
                                            <div class="form-group">
                                                <label class="">Longitude</label>
                                                <span class="info-box-number text-center text-muted mb-0"><input type="text" value="{{ $rentDetails->longitude }}" class="form-control input-border" name="longitude"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="">
                                            <div class="form-group">
                                                <label class="">Lot Size Value</label>
                                                <span class="info-box-number  text-muted mb-0"><input type="text" value="{{ $rentDetails->lot_size_value }}" name="lot_size_value" class="form-control input-border"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="">
                                            <div class="form-group">
                                                <label class="">Lot Size Unit</label>
                                                <span class="info-box-number text-muted mb-0"><input type="text" value="{{ $rentDetails->lot_size_unit }}" name="lot_size_unit" class="form-control input-border"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="">
                                            <div class="form-group">
                                                <label class="">Managed By</label>
                                                <span class="info-box-number text-muted mb-0"><input type="text" value="{{ $rentDetails->managed_by }}" name="managed_by" class="form-control input-border"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="">
                                            <div class="form-group">
                                                <label class="">Most Recent Status</label>
                                                <span class="info-box-number text-muted mb-0"><input type="text" value="{{ $rentDetails->most_recent_status }}" class="form-control input-border" name="most_recent_status"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="">
                                            <div class="form-group">
                                                <label class="">Most Recent Status Date</label>
                                                <input type="text" value="{{ $rentDetails->most_recent_status_date }}" class="form-control input-border" name="most_recent_status_date">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="">
                                            <div class="form-group">
                                                <label class="">MLS Number</label>
                                                <input type="text" value="{{ $rentDetails->mls_number }}" name="mls_number" class="form-control input-border">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="">
                                            <div class="form-group">
                                                <label class="">Near By School</label>
                                                <input type="text" value="{{ $rentDetails->near_by_school }}" name="near_by_school" class="form-control input-border">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="">
                                            <div class="form-group">
                                                <label class="">Neighborhoods</label>
                                                <input type="text" name="neighborhood" class="form-control input-border" value="{{ $rentDetails->neighborhood }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="">
                                            <div class="form-group">
                                                <label class="info-box-text  text-muted">Number of Bathroom</label>
                                                <input type="text" name="num_bathroom" class="form-control input-border" value="{{ $rentDetails->num_bathroom }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="">
                                            <div class="form-group">
                                                <label class="info-box-text  text-muted">Number of Bedroom</label>
                                                <input type="text" class="form-control input-border" value="{{ $rentDetails->num_bedroom }}" name="num_bedroom">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="">
                                            <div class="form-group">
                                                <label class="">Number of Floor</label>
                                                <input type="text" class="form-control input-border" value="{{ $rentDetails->num_floor }}" name="num_floor">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="">
                                            <div class="form-group">
                                                <label class="">Number of People</label>
                                                <input type="text" class="form-control input-border" value="{{  $rentDetails->num_people }}" name="num_people">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="">
                                            <div class="form-group">
                                                <label class="">Number of Room</label>
                                                <input type="text" class="form-control input-border" value="{{ $rentDetails->num_room }}" name="num_room">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="">
                                            <div class="form-group">
                                                <label class="">Number Unit</label>
                                                <input type="text" value="{{ $rentDetails->num_unit }}" class="form-control input-border" name="num_unit">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="">
                                            <div class="form-group">
                                                <label class="">Parking</label>
                                                <input type="text" class="form-control input-border" value="{{ $rentDetails->parking }}" name="parking">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="">
                                            <div class="form-group">
                                                <label class="">Payment Type</label>
                                                <input type="text" class="form-control input-border" value="{{ $rentDetails->payment_type }}" name="payment_type">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="">
                                            <div class="form-group">
                                                <label class="">Pet Policy</label>
                                                <input type="text" class="form-control input-border" value="{{ $rentDetails->pet_policy }}" name="pet_policy">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="">
                                            <div class="form-group">
                                                <label class="">Phone</label>
                                                <input type="text" class="form-control input-border" value="{{ $rentDetails->phones }}" name="phones">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="">
                                            <div class="form-group">
                                                <label class="">Postal Code</label>
                                                <input type="text" class="form-control input-border" name="postal_code" value="{{ $rentDetails->postal_code }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title">People</h3>
                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body ">
                                                <div class="table-responsive">
                                                    <table class="table table-custom people-table">
                                                        <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Title</th>
                                                            <th>Date Seen</th>
                                                            <th class="text-center">Action</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @if(!$people->isEmpty())
                                                            @foreach($people as $key => $row)
                                                                <tr>
                                                                    <td><input type="text" class="form-control input-border" value="{{ $row->name }}" name="people_name[]"></td>
                                                                    <td><input type="text" class="form-control input-border" value="{{ $row->title }}" name="people_title[]"></td>
                                                                    <td><input type="text" class="form-control input-border" value="{{ $row->date_seen }}" name="people_date_seen[]"></td>
                                                                    <td class="text-center"><button type="button" class="btn btn-danger btn-xs delete-btn"><i class="fas fa-times"></i></button></td>
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
                                        <div class="margin-10"></div>
                                        <div class="margin-10"></div>
                                        <div class="margin-10"></div>
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title">Prices</h3>
                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body ">
                                                <div class="table-responsive">
                                                    <table class="table table-custom price-table">
                                                        <thead>
                                                        <tr>
                                                            <th>Amount Max</th>
                                                            <th>Amount Min</th>
                                                            <th>Currency</th>
                                                            <th>Date Seen</th>
                                                            <th>Is Sale</th>
                                                            <th>Source URL</th>
                                                            <th class="text-center">Action</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @if(!$price->isEmpty())
                                                            @foreach($price as $key => $row)
                                                                @php($date_seen = json_decode($row->date_seen))
                                                                <tr>
                                                                    <td><input type="text" class="form-control input-border" value="{{ $row->amount_max }}" name="price_amount_max[]"></td>
                                                                    <td><input type="text" class="form-control input-border" value="{{ $row->amount_min }}" name="price_amount_min[]"></td>
                                                                    <td><input type="text" class="form-control input-border" value="{{ $row->currency }}" name="price_currency[]"></td>
                                                                    <td><input type="text" class="form-control input-border" value="{{ implode(",",$date_seen) }}" name="price_date_seen[]"></td>
                                                                    <td><input type="text" class="form-control input-border" value="{{ $row->is_sale }}" name="price_is_sale[]"></td>
                                                                    <td>
                                                                        @php($i=0)
                                                                        @foreach($sourceURLs as $url)
                                                                            <input type="text" value="{{ $url }}" name="price_source_url[]" class="form-control input-border">
                                                                            @php($i++)
                                                                        @endforeach
                                                                    </td>
                                                                    <td class="text-center"><button type="button" class="btn btn-xs btn-danger delete-btn"><i class="fas fa-times"></i></button></td>
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
                                    <div class="col-12 col-sm-4">
                                        <div class="">
                                            <div class="form-group">
                                                <label class="">Property Tax</label>
                                                <span class="info-box-number text-muted mb-0"><input type="text" value="{{ $rentDetails->property_tax }}" name="property_tax" class="form-control input-border"></span>
                                            </div>
                                            <div class="form-group">
                                                <label class="">Property Type</label>
                                                <span class="info-box-number text-muted mb-0"><input type="text" value="{{ $rentDetails->property_type }}" class="form-control input-border" name="property_type"></span>
                                            </div>
                                            <div class="form-group">
                                                <label class="">Province</label>
                                                <span class="info-box-number text-muted mb-0"><input type="text" class="form-control input-border" value="{{ $rentDetails->province }}" name="province"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-8">
                                        <div class="">
                                            <div class="form-group">
                                                <label class="">Rules</label>
                                                <span class="info-box-number text-muted mb-0"><textarea class="form-control input-border" rows="8" name="rules">{{  $rentDetails->rules }}</textarea></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12">
                                        <div class="margin-10"></div>
                                        <div class="margin-10"></div>
                                        <div class="margin-10"></div>
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title">Review</h3>
                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body ">
                                                <div class="table-responsive">
                                                    <table class="table table-custom review-table">
                                                        <thead>
                                                        <tr>
                                                            <th width="15%">Date</th>
                                                            <th width="15%">Date Seen</th>
                                                            <th width="10%">Rating</th>
                                                            <th width="20%">Source URLs</th>
                                                            <th width="25%">Text</th>
                                                            <th width="10%">User Name</th>
                                                            <th width="5%" class="text-center">Action</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @if(!$review->isEmpty())
                                                            @foreach($review as $key => $row)
                                                                @php($source_url = json_decode($row->source_URL))
                                                                <tr>
                                                                    <td><input type="text" class="form-control input-border" value="{{  $row->date }}" name="review_date[]"></td>
                                                                    <td><input type="text" class="form-control input-border" value="{{  $row->date_seen }}" name="review_date_seen[]"></td>
                                                                    <td><input type="text" class="form-control input-border" value="{{  $row->rating }}" name="review_rating[]"></td>
                                                                    <td>
                                                                        @php($i=0)
                                                                        @foreach($sourceURLs as $url)
                                                                            <input type="text" value="{{ $url }}" name="review_source_url[]" class="form-control input-border">
                                                                            @php($i++)
                                                                        @endforeach
                                                                    </td>
                                                                    <td><textarea class="form-control input-border"  name="review_description[]">{{ $row->description }}</textarea></td>
                                                                    <td><input type="text" class="form-control input-border" value="{{ $row->user_name }}" name="review_user_name[]"></td>
                                                                    <td class="text-center"><button class="btn btn-xs btn-danger delete-btn"><i class="fas fa-times"></i></button></td>
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
                                        <div class="margin-10"></div>
                                        <div class="margin-10"></div>
                                        <div class="margin-10"></div>
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title">Status</h3>
                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body ">
                                                <div class="table-responsive">
                                                    <table class="table table-custom status-table">
                                                        <thead>
                                                        <tr>
                                                            <th>Type</th>
                                                            <th>Date</th>
                                                            <th>Source URLs</th>
                                                            <th>Date Seen</th>
                                                            <th class="text-center">Action</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @if(!$status->isEmpty())
                                                            @foreach($status as $key => $row)
                                                                @php($source_url = json_decode($row->source_URL))
                                                                @php($date_seen = json_decode($row->date_seen))
                                                                <tr>
                                                                    <td><input type="text" class="form-control input-border" value="{{ $row->type }}" name="status_type[]"></td>
                                                                    <td><input type="text" class="form-control input-border" value="{{ $row->date }}" name="status_date[]"></td>
                                                                    <td>
                                                                        @php($i=0)
                                                                        @foreach($sourceURLs as $url)
                                                                            <input type="text" value="{{ $url }}" name="status_source_url[]" class="form-control input-border">
                                                                            @php($i++)
                                                                        @endforeach
                                                                    </td>
                                                                    <td><input type="text" value="{{ implode(",",$date_seen) }}" class="form-control input-border" name="status_date_seen[]"></td>
                                                                    <td class="text-center"><button class="btn btn-xs btn-danger delete-btn"><i class="fas fa-times"></i></button></td>
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
                                    <div class="col-12 col-sm-3">
                                        <div class="">
                                            <div class="form-group">
                                                <span class="">Source URL</span>
                                                <span class="info-box-number text-muted mb-0"><input type="text" class="form-control input-border" value="{{ $rentDetails->source_URL }}" name="source_URL"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="">
                                            <div class="form-group">
                                                <span class="">Tax ID</span>
                                                <span class="info-box-number text-muted mb-0"><input type="text" class="form-control input-border" name="tax_ID" value="{{ $rentDetails->tax_ID }}"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="">
                                            <div class="form-group">
                                                <span class="">Unavailable Dates</span>
                                                <span class="info-box-number  text-muted mb-0"><input type="text" class="form-control input-border" value="{{ $rentDetails->unavailable_date }}" name="unavailable_date"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="">
                                            <div class="form-group">
                                                <span class="info-box-text  text-muted">Website IDs</span>
                                                <span class="info-box-number text-muted mb-0"><input type="text" class="form-control input-border" name="website_id" value="{{ $rentDetails->website_id }}"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <div class="margin-10"></div>
                            <div class="margin-10"></div>
                            <div class="col-md-12 text-right">
                                <button style="float: right" type="submit" class="btn btn-primary submit-btn"><i class="fas fa-check"></i>&nbsp;Update</button>
                            </div>
                            <div class="margin-10"></div>
                        </div>
                    </div>
                <!-- /.card-body -->
            </div>
            </form>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
@section('scripts')
    <script>
        $('.deposit-table tbody tr .delete-btn').click(function(){
            var message = confirm('Do you want to remove this ?');
            if(message){
                $(this).closest('tr').remove();
                return false;
            }
        });
        $('.description-table tbody tr .delete-btn').click(function(){
            var message = confirm('Do you want to remove this ?');
            if(message){
                $(this).closest('tr').remove();
                return false;
            }
        });
        $('.feature-table tbody tr .delete-btn').click(function(){
            var message = confirm('Do you want to remove this ?');
            if(message){
                $(this).closest('tr').remove();
                return false;
            }
        });
        $('.fees-table tbody tr .delete-btn').click(function(){
            var message = confirm('Do you want to remove this ?');
            if(message){
                $(this).closest('tr').remove();
                return false;
            }
        });
        $('.people-table tbody tr .delete-btn').click(function(){
            var message = confirm('Do you want to remove this ?');
            if(message){
                $(this).closest('tr').remove();
                return false;
            }
        });
        $('.price-table tbody tr .delete-btn').click(function(){
            var message = confirm('Do you want to remove this ?');
            if(message){
                $(this).closest('tr').remove();
                return false;
            }
        });
        $('.review-table tbody tr .delete-btn').click(function(){
            var message = confirm('Do you want to remove this ?');
            if(message){
                $(this).closest('tr').remove();
                return false;
            }
        });
        $('.status-table tbody tr .delete-btn').click(function(){
            var message = confirm('Do you want to remove this ?');
            if(message){
                $(this).closest('tr').remove();
                return false;
            }
        });
        $(document).on('submit','form#edit_rental_form',function(event){
            event.preventDefault();
            let form = $(this);
            let data = new FormData($(this)[0]);
            let url = $(this).attr('action');
            $(".submit-btn").attr('disabled','disabled');
            $.ajax({
                type: form.attr('method'),
                url: url,
                data: data,
                cache: false,
                contentType:false,
                processData: false,
                success:function(data){
                    $(".submit-btn").attr('disabled',false);
                    alert('Successfully Updated.')
                    window.location = "/datafiniti-property-list"
                }
            });
        });
    </script>
@endsection
