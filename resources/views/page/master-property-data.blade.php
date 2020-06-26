<table class="table table-custom" id="editableTable">
    <thead>
    <tr>
        <th>#</th>
        <th>Community</th>
        <th>Latitude</th>
        <th>Longitude</th>
        <th>URL</th>
        <th>Room Type</th>
        <th class="text-center">No of Bedrooms</th>
        <th class="text-center">No of Bathrooms</th>
        <th class="text-center">Data Source</th>
        <th>Image</th>
        <th class="text-center">Action</th>
        <th>Locate Property</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @if(!$masterProperty->isEmpty())
        @foreach($masterProperty as $key => $row)
            <tr>
                <td>{{ $key + $masterProperty->firstItem() }}</td>
                <td>{{ $row->name }}</td>
                <td>{{ $row->latitude }}</td>
                <td>{{ $row->longitude }}</td>
                <td><a target="_blank" href="{{ $row->URL }}">{{ $row->URL }}</a></td>
                <td>{{ $row->room_type }}</td>
                <td class="text-center">{{ $row->num_bedroom }}</td>
                <td class="text-center">{{ $row->no_of_bathroom }}</td>
                <td class="text-center">{{ $row->data_source }}</td>
                <td>
                    <?php
                    if($row->rent_details_id){
                    $DataFinitImage = \App\RentDetail::find($row->rent_details_id);
                    if($DataFinitImage){
                    $image = explode(",", $DataFinitImage->image_url);
                    if($DataFinitImage->primary_image != null){
                        $img = $image[$DataFinitImage->primary_image];
                    ?>
                    <img src="{{ $img }}" height="60" width="80">
                    <?php }} }?>
                    <?php
                    if($row->region_listings_id){
                    $image = \App\RegionListingImage::where('region_listings_id', $row->region_listings_id)->where('primary_image', 1)->first();
                    if($image){
                    ?>
                    <img src="{{ asset($image->image) }}" height="60" width="80">
                    <?php }}?>
                </td>
                <td class="text-center">
                    <a title="Details" href="{{ route('master.property.details',[$row->id]) }}"
                       class="btn btn-success mr-r-5 btn-xs"><i class="fas fa-info-circle"></i>
                    </a>
                    <a title="Edit" href="{{ route('edit.master.property',[$row->id]) }}"
                       class="btn mr-r-5 btn-primary btn-xs"><i class="fa fa-pencil-alt"></i></a>
                </td>
                <td class="text-center">
                    <a href="{{ route('match.property',[$row->id]) }}"  class="btn btn-info btn-sm">
                        Locate
                    </a>
                </td>
                <td><a href="{{ route('master.property.view',[$row->id]) }}">View</a></td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="14" class="text-center">No Data Found.</td>
        </tr>
    @endif
    </tbody>
</table>
<div style="float: right">{{ $masterProperty->links() }}</div>
