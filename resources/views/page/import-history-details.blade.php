@extends('layouts.app')
@section('title')
    Datafiniti Property Details
@endsection
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- SELECT2 EXAMPLE -->
            <div class="card card-default">
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-sm-12">
                                    <ul class="list-group list-group-unbordered">
                                        <li class="list-group-item">
                                            <strong>ID</strong>
                                            <span class="float-right">{{ $rentDetails->rent_id }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Address</strong>
                                            <span
                                                class="float-right">{{ $rentDetails->address ? $rentDetails->address:'---'  }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Available Date</strong>
                                            <span
                                                class="float-right">{{ $rentDetails->available_date ? $rentDetails->available_date:'---'  }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Brokers</strong>
                                            <span
                                                class="float-right">{{ $rentDetails->brokers ? $rentDetails->brokers:'---'  }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Building Name</strong>
                                            <span
                                                class="float-right">{{ $rentDetails->building_name ? $rentDetails->building_name:'---'  }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>City</strong>
                                            <span
                                                class="float-right">{{ $rentDetails->city_id ? $rentDetails->city->city_name:'---'  }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Country</strong>
                                            <span
                                                class="float-right">{{ $rentDetails->country_id ? $rentDetails->country->country_name:'---'  }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Date Added</strong>
                                            <span
                                                class="float-right">{{ $rentDetails->date_added ? $rentDetails->date_added:'---'  }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Date Updated</strong>
                                            <span
                                                class="float-right">{{ $rentDetails->date_updated ? $rentDetails->date_updated:'---'  }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Geo Location</strong>
                                            <span
                                                class="float-right">{{ $rentDetails->geo_location ? $rentDetails->geo_location:'---'  }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Hours</strong>
                                            <span
                                                class="float-right">{{ $rentDetails->hours ? $rentDetails->hours:'---'  }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="card">
                        <div class="card-header border-transparent">
                            <h3 class="card-title">Description</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-sm-12">
                                    <div class="">
                                        <table class="table table-custom">
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
                                                                <a target="_blank"
                                                                   href="{{ $url }}">{{ $url  }}</a> {{ $i==0 ? '':', '   }}
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="card">
                        <div class="card-header border-transparent">
                            <h3 class="card-title">Feature</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-sm-12">
                                    <div class="">
                                        <table class="table table-custom">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th width="15%">Key</th>
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-sm-12">
                                    <ul class="list-group list-group-unbordered">
                                        <li class="list-group-item">
                                            <strong>Key</strong>
                                            <span class="float-right"><a
                                                    href="{{ $rentDetails->key  }}">{{ $rentDetails->key ? $rentDetails->key:'---'  }}</a></span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Language Spoken</strong>
                                            <span
                                                class="float-right">{{ $rentDetails->languages_spoken ? $rentDetails->languages_spoken:'---'  }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Latitude</strong>
                                            <span
                                                class="float-right">{{ $rentDetails->latitude ? $rentDetails->latitude:'---'  }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Leasing Terms</strong>
                                            <span
                                                class="float-right">{{ $rentDetails->leasing_terms ? $rentDetails->leasing_terms:'---'  }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Leasing Name</strong>
                                            <span
                                                class="float-right">{{ $rentDetails->listing_name ? $rentDetails->listing_name:'---'  }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Longitude</strong>
                                            <span
                                                class="float-right">{{ $rentDetails->longitude ? $rentDetails->longitude:'---'  }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Lot Size Value</strong>
                                            <span
                                                class="float-right">{{ $rentDetails->lot_size_value ? $rentDetails->lot_size_value:'---'  }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Lot Size Unit</strong>
                                            <span
                                                class="float-right">{{ $rentDetails->lot_size_unit ? $rentDetails->lot_size_unit:'---'  }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Managed By</strong>
                                            <span
                                                class="float-right">{{ $rentDetails->managed_by ? $rentDetails->managed_by:'---'  }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Most Recent Status</strong>
                                            <span
                                                class="float-right">{{ $rentDetails->most_recent_status ? $rentDetails->most_recent_status:'---'  }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Most Recent Status Date</strong>
                                            <span
                                                class="float-right">{{ $rentDetails->most_recent_status_date ? $rentDetails->most_recent_status_date:'---'  }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>MLS Number</strong>
                                            <span
                                                class="float-right">{{ $rentDetails->mls_number ? $rentDetails->mls_number:'---'  }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Near By School</strong>
                                            <span
                                                class="float-right">{{ $rentDetails->near_by_school ? $rentDetails->near_by_school:'---'  }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Neighborhoods</strong>
                                            <span
                                                class="float-right">{{ $rentDetails->neighborhood ? $rentDetails->neighborhood:'---'  }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Number of Bathroom</strong>
                                            <span
                                                class="float-right">{{ $rentDetails->num_bathroom ? $rentDetails->num_bathroom:'---'  }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Number of Bedroom</strong>
                                            <span
                                                class="float-right">{{ $rentDetails->num_bedroom ? $rentDetails->num_bedroom:'---'  }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Number of Floor</strong>
                                            <span
                                                class="float-right">{{ $rentDetails->num_floor ? $rentDetails->num_floor:'---'  }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Number of People</strong>
                                            <span
                                                class="float-right">{{ $rentDetails->num_people ? $rentDetails->num_people:'---'  }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Number of Room</strong>
                                            <span
                                                class="float-right">{{ $rentDetails->num_room ? $rentDetails->num_room:'---'  }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Number of Unit</strong>
                                            <span
                                                class="float-right">{{ $rentDetails->num_unit ? $rentDetails->num_unit:'---'  }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Parking</strong>
                                            <span
                                                class="float-right">{{ $rentDetails->parking ? $rentDetails->parking:'---'  }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Payment Type</strong>
                                            <span
                                                class="float-right">{{ $rentDetails->payment_type ? $rentDetails->payment_type:'---'  }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Pet Policy</strong>
                                            <span
                                                class="float-right">{{ $rentDetails->pet_policy ? $rentDetails->pet_policy:'---'  }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Phone</strong>
                                            <span
                                                class="float-right">{{ $rentDetails->phones ? $rentDetails->phones:'---'  }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Postal Code</strong>
                                            <span
                                                class="float-right">{{ $rentDetails->postal_code ? $rentDetails->postal_code:'---'  }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="card">
                        <div class="card-header border-transparent">
                            <h3 class="card-title">People</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-sm-12">
                                    <div class="">
                                        <table class="table table-custom">
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="card">
                        <div class="card-header border-transparent">
                            <h3 class="card-title">Prices</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-sm-12">
                                    <div class="">
                                        <table class="table table-custom">
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-sm-12">
                                    <ul class="list-group list-group-unbordered">
                                        <li class="list-group-item">
                                            <strong>Property Tax</strong>
                                            <span class="float-right">{{ $rentDetails->property_tax ? $rentDetails->property_tax:'' }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Property Type</strong>
                                            <span class="float-right">{{ $rentDetails->property_type ? $rentDetails->property_type:'' }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Province</strong>
                                            <span class="float-right">{{ $rentDetails->province ? $rentDetails->province:'' }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Rules</strong>
                                            <span class="float-right">{{ $rentDetails->rules ? $rentDetails->rules:'' }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="card">
                        <div class="card-header border-transparent">
                            <h3 class="card-title">Review</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-sm-12">
                                    <div class="">
                                        <table class="table table-custom">
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
                                                                <a target="_blank"
                                                                   href="{{ $url }}">{{ $url  }}</a> {{ $i==0 ? '':', '   }}
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="card">
                        <div class="card-header border-transparent">
                            <h3 class="card-title">Status</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-sm-12">
                                    <div class="">
                                        <table class="table table-custom">
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
                                                                <a target="_blank"
                                                                   href="{{ $url }}">{{ $url  }}</a> {{ $i==0 ? '':', '   }}
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-sm-12">
                                    <ul class="list-group list-group-unbordered">
                                        <li class="list-group-item">
                                            <strong>Source URL</strong>
                                            <span class="float-right">{{ $rentDetails->source_URL }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Tax ID</strong>
                                            <span class="float-right">{{ $rentDetails->tax_ID }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Unavailable Dates</strong>
                                            <span class="float-right">{{ $rentDetails->unavailable_date }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Website IDs</strong>
                                            <span class="float-right">{{ $rentDetails->website_id }}</span>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- /.card-header -->
                            <div class="row">
                                <div class="col-12 col-sm-12">
                                    <!-- /.card -->
                                </div>

                                <div class="col-12 col-sm-12">
                                    <div class="card">
                                        <div class="card-header border-transparent">
                                            <h3 class="card-title">Feature</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                @foreach($rentDetails->image as $key=> $row)
                                                    <div class="col-md-2 col-12">
                                                        <a href="javascript:void(0)"
                                                           style="background-image: url('{{ asset($row->image) }}')"
                                                           class="image img-description" id="{{ $key }}"
                                                           data-toggle="modal" data-target="#exampleModalCenter">

                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{--                                <div class="col-sm-12">--}}
                                {{--                                <div class="info-box bg-light">--}}
                                {{--                                    <div class="info-box-content">--}}
                                {{--                                        <span class="info-box-text text-center text-muted">Property Image</span>--}}
                                {{--                                        <span class="info-box-number text-muted mb-0">--}}
                                {{--                                                <span class="row">--}}
                                {{--                                                     @foreach($rentDetails->image as $key=> $row)--}}
                                {{--                                                        <span class="col-md-2 col-12">--}}
                                {{--                                                            <a data-toggle="modal" href="javascript:void(0)" class="image" id="{{ $key }}" data-target="#exampleModalCenter">--}}
                                {{--                                                                <img src="{{ asset($row->image) }}" class="img-rounded" alt="Responsive Image"/>--}}
                                {{--                                                            </a>--}}
                                {{--                                                        </span>--}}
                                {{--                                                    @endforeach--}}
                                {{--                                                </span>--}}
                                {{--                                        </span>--}}
                                {{--                                    </div>--}}
                                {{--                                </div>--}}
                                {{--                            </div>--}}
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
@section('scripts')
    <script>
        $(document).on('click', '.image', function () {
            let id = "{{ $rentDetails->id }}";
            let image_id = $(this).attr('id');
            $.ajax({
                url: "/datafiniti-image",
                type: "GET",
                datatype: "html",
                data: {
                    "image_id": image_id,
                    "id": id
                }
            }).done(function (data) {
                console.log(data);
                $(".modal-body").html(data);
            });
        });
    </script>
@endsection
