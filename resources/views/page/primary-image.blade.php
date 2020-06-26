<div class="col-md-12">
    <div class="form-group row">
        <label for="staticEmail" class="col-sm-2">Primary Image</label>
        <div class="col-sm-2">
            <input type="checkbox" class="form-control checkbox" {{ $imageDescription->primary_image==1 ? 'checked':'' }}>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6" style="overflow: hidden">
        <img class="responsive-image" src="{{ asset($imageDescription->image) }}">
    </div>
    <div class="col-md-6">
        <ul class="nav nav-pills nav-fill mb-3" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a href="#pills-object" role="tab" class="nav-link active" id="pills-object-tab" data-toggle="pill"
                   aria-controls="pills-labels" aria-selected="true">Object</a>
            </li>
            <li class="nav-item">
                <a href="#pills-labels" role="tab" class="nav-link" id="pills-labels-tab" data-toggle="pill"
                   aria-controls="pills-web" aria-selected="true">Labels</a>
            </li>
            <li class="nav-item">
                <a href="#pills-text" role="tab" class="nav-link" id="pills-text-tab" data-toggle="pill"
                   aria-controls="pills-properties" aria-selected="true">Text</a>
            </li>
        </ul>
        <hr>

    </div>
</div>
<script>
    $('.checkbox').click(function(){
        let val = $(".checkbox").is( ":checked" );
        $.ajax({
            type:'GET',
            url:'/leaseabuse-property-image',
            data:{
                "id":"{{ $imageDescription->id }}",
                "region_listing_id":"{{ $region_listins_id }}",
                "val":val
            },success:function(data){
                console.log(data);
            }
        });
    });
</script>
