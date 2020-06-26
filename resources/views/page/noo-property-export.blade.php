<table>
    <tr>
        <th>PropertyGID</th>
        <th>OwnerName1</th>
        <th>OwnerName2</th>
        <th>ParcelID</th>
        <th>ParcelCity</th>
        <th>SiteAddress</th>
        <th>SiteUnit</th>
        <th>SiteCity</th>
        <th>SiteCounty</th>
        <th>SiteState</th>
        <th>SiteZipCode</th>
        <th>LegalDesc</th>
        <th>X_DD</th>
        <th>Y_DD</th>
        <th>GeoType</th>
        <th>PropertyUse</th>
        <th>ActiveFlag</th>
        <th>CommCommunityID</th>
        <th>OwnerAddress</th>
        <th>OwnerCity</th>
        <th>OwnerState</th>
        <th>OwnerZipcode</th>
        <th>NumberofUnits</th>
        <th>Image</th>
        <th>Image URL</th>
    </tr>
    @foreach($property as $row)
        <tr>
            <td>{{ $row->PropertyGID }}</td>
            <td>{{ $row->owner->OwnerName1 }}</td>
            <td>{{ $row->owner->OwnerName2 }}</td>
            <td>{{ $row->ParcelID }}</td>
            <td>{{ $row->ParcelCity }}</td>
            <td>{{ $row->site->SiteAddress }}</td>
            <td>{{ $row->site->SiteUnit }}</td>
            <td>{{ $row->site->SiteCity }}</td>
            <td>{{ $row->site->SiteCounty }}</td>
            <td>{{ $row->site->SiteState }}</td>
            <td>{{ $row->site->SiteZipCode }}</td>
            <td>{{ $row->LegalDesc }}</td>
            <td>{{ $row->X_DD }}</td>
            <td>{{ $row->Y_DD }}</td>
            <td>{{ $row->GeoType }}</td>
            <td>{{ $row->PropertyUse }}</td>
            <td>{{ $row->ActiveFlag }}</td>
            <td>{{ $row->CommCommunityID }}</td>
            <td>{{ $row->owner->OwnerAddress }}</td>
            <td>{{ $row->owner->OwnerCity }}</td>
            <td>{{ $row->owner->OwnerState }}</td>
            <td>{{ $row->owner->OwnerZipcode }}</td>
            <td>{{ $row->NumberofUnits }}</td>
            <td>{{ $row->image ? public_path($row->image):'' }}</td>
            <td>{{ $row->image ? url($row->image):'' }}</td>
        </tr>
    @endforeach
</table>
