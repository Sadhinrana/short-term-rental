<table>
    <thead>
    <tr>
        <th>Image URL</th>
        <th>Image ID</th>
        <th>Listing ID</th>
    </tr>
    </thead>
    <tbody>
    @foreach($property as $key=> $row)
        <tr>
            <td>
               {{ "https://maps.googleapis.com/maps/api/streetview?size=600x400&location=" . $row->site->SiteAddress . "," . $row->site->SiteCity . "" . $row->site->SiteState . "" .$row->site->SiteZipCode . "&key=AIzaSyDE2i7RPzDbo7CajfIwJG2XOsRna7a9n70" }}
            </td>
            <td>{{ $key+1 }}</td>
            <td>{{ $row->PropertyGID }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
