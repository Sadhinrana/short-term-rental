<table  class="table table-custom" id="editableTable">
    <thead>
        <tr>
            <th>#</th>
            <th>Country</th>
            <th>City</th>
            <th>Date Added</th>
            <th>Date Updated</th>
            <th>Geo Location</th>
            <th>Latitude</th>
            <th>Longitude</th>
            <th class="text-center" colspan="2">Action</th>
        </tr>
    </thead>
    <tbody>
        @if(!$importHistories->isEmpty())
        @foreach($importHistories as $key => $row)
        <tr>
            <td>{{ $importHistories->firstItem() + $key }} </td>
            <td>
                <span class="show-value-{{ $row->id }}">
                    {{ $row->country->country_name }}
                </span>
                <span class="inline-edit-{{ $row->id }}" style="display: none">
                    <select class="form-control input-small input-border country-id-{{ $row->id }}" >
                        @foreach($countries as $country)
                        <option value="{{ $country->id }}" {{ $country->id==$row->country_id ? 'selected':'' }}>{{ $country->country_name }}</option>
                        @endforeach
                    </select>
                </span>
            </td>
            <td>
                <span class="show-value-{{ $row->id }}">
                    {{ $row->city->city_name }}
                </span>
                <span class="inline-edit-{{ $row->id }}" style="display: none">
                    <select class="form-control input-small input-border city-id-{{ $row->id }}" >
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}" {{ $city->id==$row->city_id ? 'selected':'' }}>{{ $city->city_name }}</option>
                        @endforeach
                    </select>
                </span>
            </td>
            <td>
                <span class="show-value-{{ $row->id }}">
                    {{ $row->date_added }}
                </span>
                <span class="inline-edit-{{ $row->id }}" style="display: none">
                    <input type="text" class="form-control input-border input-small date-added-{{ $row->id }}" value="{{  $row->date_added }}">
                </span>
            </td>
            <td>
                 <span class="show-value-{{ $row->id }}">
                    {{ $row->date_updated }}
                 </span>
                <span class="inline-edit-{{ $row->id }}" style="display: none">
                    <input type="text" class="form-control input-border input-small date-updated-{{ $row->id }}" value="{{  $row->date_updated }}">
                </span>
            </td>
            <td>
                <span class="show-value-{{ $row->id }}">
                    {{ $row->geo_location }}
                </span>
                <span class="inline-edit-{{ $row->id }}" style="display: none">
                    <input type="text" class="form-control input-border input-small geo-location-{{ $row->id }}" value="{{  $row->geo_location }}">
                </span>
            </td>
            <td>
                <span class="show-value-{{ $row->id }}">
                    {{ $row->latitude }}
                </span>
                <span class="inline-edit-{{ $row->id }}" style="display: none">
                    <input type="text" class="form-control input-border input-small latitude-{{ $row->id }}" value="{{  $row->latitude }}">
                </span>
            </td>
            <td>
                <span class="show-value-{{ $row->id }}">
                    {{ $row->longitude }}
                </span>
                <span class="inline-edit-{{ $row->id }}" style="display: none">
                    <input type="text" class="form-control input-border input-small longitude-{{ $row->id }}" value="{{  $row->longitude }}">
                </span>
            </td>
            <td class="text-center">
                <a class="btn btn-xs btn-success mr-r-5" title="Details" href="{{ url('/datafiniti-property-details',[$row->id]) }}"><i class="fas fa-info-circle"></i></a>
                <a class="btn btn-xs btn-primary mr-r-5" title="Edit" href="{{ url('/datafiniti-property-edit',[$row->id]) }}"><i class="fas fa-edit"></i></a>
                <span class=" show-value-{{ $row->id }}">
                    <button id="{{ $row->id }}"  type="button" class="btn btn-xs btn-yellow row-edit">
                        <i class="fas fa-pencil-alt"></i>
                    </button>
                </span>
                <span class="inline-edit-{{ $row->id }}" style="display: none">
                    <button id="{{ $row->id }}"  type="button" class="btn btn-xs btn-yellow row-save">
                       <i class="fas fa-check"></i>
                    </button>
                </span>
            </td>
{{--            <td class="text-center">--}}

{{--            </td>--}}
{{--            <td>--}}

{{--            </td>--}}
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="10" class="text-center">No Data Found.</td>
        </tr>
        @endif
    </tbody>
</table>
<div style="float: right">{{ $importHistories->links() }}</div>
