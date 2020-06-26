<div class="table-responsive">
    <table class="table table-bordered table-hover table-striped">
        <thead>
        <tr>
            <th>#</th>
            <th>Reviewer Photo</th>
            <th>Reviewer</th>
            <th>Comment</th>
            <th>Comment Response Date</th>
            <th>Review Date</th>
        </tr>
        </thead>
        <tbody>
        @foreach($reviews as $key=> $row)
        <tr>
            <td>{{ $key+1 }}</td>
            @if($row->reviewerPhoto)
            <td><img src="{{ asset($row->reviewerPhoto) }}" style="border-radius: 50%" height="50" width="50"></td>
            @else
            <td></td>
            @endif
            <td>{{ $row->reviewer }}</td>
            <td>{{ $row->comments }}</td>
            <td>{{ $row->commentsResponseDate }}</td>
            <td>{{ $row->reviewDate }}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
<span id="review">{{ $reviews->links() }}</span>
