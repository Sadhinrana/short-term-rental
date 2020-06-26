<table class="table table-bordered table-hover table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Type</th>
            <th>Latitude</th>
            <th>Longitude</th>
            <th>Host Name</th>
            <th>Source</th>
            <th>Price</th>
            <th class="text-center">Action</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    @if(!$regions->isEmpty())
        @foreach($regions as $key=> $row)
            <tr>
                <td>{{ $regions->firstItem()+$key }}</td>
                <td>
                    <span class="show-value-{{ $row->id }}">
                        {{ $row->region->name }}
                    </span>
                    <span class="inline-edit-{{ $row->id }}" style="display: none">
                        <input type="hidden" value="{{ $row->region->id }}"
                               class="form-control region-id-{{ $row->id }}">
                        <input type="text" value="{{ $row->region->name }}" class="form-control name-{{ $row->id }}">
                    </span>
                </td>
                <td>
                    <span class="show-value-{{ $row->id }}">
                    {{ $row->region->type }}
                    </span>
                    <span class="inline-edit-{{ $row->id }}" style="display: none">
                        <input type="text" value="{{ $row->region->type }}" class="form-control type-{{ $row->id }}">
                    </span>
                </td>
                <td>
                    <span class="show-value-{{ $row->id }}">
                    {{ $row->latitude }}
                    </span>
                    <span class="inline-edit-{{ $row->id }}" style="display: none">
                        <input type="text" value="{{ $row->latitude }}"
                               class="form-control latitude-{{ $row->id }}">
                    </span>
                </td>
                <td>
                    <span class="show-value-{{ $row->id }}">
                    {{ $row->longitude }}
                    </span>
                    <span class="inline-edit-{{ $row->id }}" style="display: none">
                        <input type="text" value="{{ $row->longitude }}"
                               class="form-control longitude-{{ $row->id }}">
                    </span>
                </td>
                <td>
                    <span class="show-value-{{ $row->id }}">
                    {{ $row->hostName }}
                    </span>
                    <span class="inline-edit-{{ $row->id }}" style="display: none">
                        <input type="text" value="{{ $row->hostName }}" class="form-control hostName-{{ $row->id }}">
                    </span>
                </td>
                <td>
                    <span class="show-value-{{ $row->id }}">
                    {{ $row->source }}
                    </span>
                    <span class="inline-edit-{{ $row->id }}" style="display: none">
                        <input type="text" value="{{ $row->source }}" class="form-control source-{{ $row->id }}">
                    </span>
                </td>
                <td>
                    <span class="show-value-{{ $row->id }}">
                    {{ number_format($row->price,2) }}
                    </span>
                    <span class="inline-edit-{{ $row->id }}" style="display: none">
                        <input type="text" value="{{ $row->price }}" class="form-control price-{{ $row->id }}">
                    </span>
                </td>
                <td class="text-center">
                    <a class="btn btn-xs btn-success" title="Details"
                       href="{{ route('region.details',[$row->id]) }}"><i class="fas fa-info-circle"></i></a>
                </td>
                <td>
                    <span class="show-value-{{ $row->id }}">
                        <button id="{{ $row->id }}" type="button" class="btn btn-sm btn-default row-edit">
                            <i class="fas fa-pencil-alt"></i>
                        </button>
                    </span>
                    <span class="inline-edit-{{ $row->id }}" style="display: none">
                        <button id="{{ $row->id }}" type="button" class="btn btn-sm btn-default row-save">
                           <i class="fas fa-check"></i>
                        </button>
                    </span>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="10" class="text-center">No Data Found.</td>
        </tr>
    @endif
    </tbody>
</table>
<div style="float: right">{{ $regions->links() }}</div>
