<table class="table table-custom">
    <thead>
    <tr>
        <th>#</th>
        <th>PropertyGID</th>
        <th>Site Address</th>
        <th>Site City</th>
        <th>Site State</th>
        <th>Owner Name</th>
        <th class="text-center" colspan="2">Action</th>
    </tr>
    </thead>
    <tbody>
    @if(!$properties->isEmpty())
        @foreach($properties as $key=> $row)
            <tr>
                <td>
                    {{ $properties->firstItem()+ $key }}
                </td>
                <td>
                        <span class="show-value-{{ $row->Id }}">
                        {{ $row->PropertyGID }}
                        </span>
                    <span class="inline-edit-{{ $row->Id }}" style="display: none">
                            <input type="text" value="{{ $row->PropertyGID }}"
                                   class="form-control input-border PropertyGID-{{ $row->Id }}">
                            <input type="hidden" value="{{ $row->site->Id }}"
                                   class="form-control siteId-{{ $row->Id }}">
                            <input type="hidden" value="{{ $row->owner->Id }}"
                                   class="form-control input-border ownerId-{{ $row->Id }}">
                        </span>
                </td>
                <td>
                        <span class="show-value-{{ $row->Id }}">
                            {{ $row->site->SiteAddress }}
                        </span>
                    <span class="inline-edit-{{ $row->Id }}" style="display: none">
                            <input type="text" value="{{ $row->site->SiteAddress }}"
                                   class="form-control input-border SiteAddress-{{ $row->Id }}">
                        </span>
                </td>
                <td>
                        <span class="show-value-{{ $row->Id }}">
                            {{ $row->site->SiteCity }}
                        </span>
                    <span class="inline-edit-{{ $row->Id }}" style="display: none">
                            <input type="text" value="{{ $row->site->SiteCity }}"
                                   class="form-control input-border SiteCity-{{ $row->Id }}">
                        </span>
                </td>
                <td>
                        <span class="show-value-{{ $row->Id }}">
                            {{ $row->site->SiteState }}
                        </span>
                    <span class="inline-edit-{{ $row->Id }}" style="display: none">
                            <input type="text" value="{{ $row->site->SiteState }}"
                                   class="form-control input-border SiteState-{{ $row->Id }}">
                        </span>
                </td>
                <td>
                    <a target="_blank" href="{{ url('/noo-property-owner',[$row->owner->Id]) }}">
                        <span class="show-value-{{ $row->Id }}">
                            {{ $row->owner->OwnerName1 }}
                        </span>
                    </a>
                    <span class="inline-edit-{{ $row->Id }}" style="display: none">
                            <input type="text" value="{{ $row->owner->OwnerName1 }}"
                                   class="form-control input-border OwnerName1-{{ $row->Id }}">
                        </span>
                </td>
                <td class="text-center">
                    <a class="btn btn-xs btn-success mr-r-5" title="Details"
                       href="{{ url('/noo-property-details',[$row->Id]) }}"><i class="fas fa-info-circle"></i></a>
                    <a class="btn btn-xs btn-primary mr-r-5" title="Edit"
                       href="{{ url('/noo-property-edit',[$row->Id]) }}"><i class="fas fa-edit"></i></a>
                    <span class="show-value-{{ $row->Id }}">
                            <button id="{{ $row->Id }}" type="button" class="btn btn-xs btn-yellow row-edit">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                        </span>
                    <span class="inline-edit-{{ $row->Id }}" style="display: none">
                            <button id="{{ $row->Id }}" type="button" class="btn btn-xs btn-yellow row-save">
                               <i class="fas fa-check"></i>
                            </button>
                        </span>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="8" class="text-center">No Data Found.</td>
        </tr>
    @endif
    </tbody>
</table>
<div style="float: right">{{ $properties->links() }}</div>
