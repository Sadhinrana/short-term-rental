@extends('layouts.app')
@section('title')
    NOO Property Edit
@endsection
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- SELECT2 EXAMPLE -->
            <form action="{{ url('/property-edit') }}" method="POST" id="property_edit_form">
                {{ csrf_field() }}
                <div class="card card-default">
{{--                    <div class="card-header">--}}
{{--                        <h5>NOO Property Edit</h5>--}}
{{--                    </div>--}}
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <!-- /.card-header -->
                                <div class="row">
                                    <div class="col-12 col-sm-3">
                                        <div class="form-group">
                                            <label class="info-box-text ">PropertyGID</label>
                                            <input type="hidden" value="{{ $property->Id }}" name="Id">
                                            <input type="hidden" value="{{ $property->owner->Id }}" name="OwnerId">
                                            <input type="hidden" value="{{ $property->site->Id }}" name="SiteId">
                                            <input type="text" value="{{  $property->PropertyGID }}" name="PropertyGID" class="form-control input-border">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="form-group">
                                            <label class="info-box-text ">OwnerName1</label>
                                            <input type="text" class="form-control input-border" value="{{ $property->owner->OwnerName1 }}" name="OwnerName1">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="form-group">
                                            <label class="info-box-text ">OwnerName2</label>
                                            <input type="text" class="form-control input-border" name="OwnerName2" value="{{ $property->owner->OwnerName2 }}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="form-group">
                                            <label class="info-box-text ">ParcelID</label>
                                            <input type="text" class="form-control input-border" value="{{ $property->ParcelID }}" name="ParcelID">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="form-group">
                                            <label class="info-box-text ">ParcelLong</label>
                                            <input type="text" name="ParcelLong" value="{{ $property->ParcelLong }}" class="form-control  input-border">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="form-group">
                                            <label class="info-box-text ">TaxAccount</label>
                                            <input type="text" class="form-control  input-border" value="{{ $property->TaxAccount }}" name="TaxAccount">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                       <div class="form-group">
                                           <label class="info-box-text ">ParcelCity</label>
                                           <input type="text" class="form-control input-border" value="{{ $property->ParcelCity }}" name="ParcelCity">
                                       </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="form-group">
                                            <label class="info-box-text ">SiteAddress</label>
                                            <input type="text" class="form-control input-border" value="{{ $property->site->SiteAddress }}" name="SiteAddress">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                       <div class="form-group">
                                           <label class="info-box-text  ">SiteUnit</label>
                                           <input type="text" class="form-control input-border" value="{{ $property->site->SiteUnit }}" name="SiteUnit">
                                       </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="form-group">
                                            <label class="info-box-text ">SiteCity</label>
                                            <input type="text" class="form-control input-border" value="{{ $property->site->SiteCity }}" name="SiteCity">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="form-group">
                                            <label class="info-box-text ">SiteState</label>
                                            <input type="text" class="form-control input-border" value="{{ $property->site->SiteState }}" name="SiteState">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                       <div class="form-group">
                                           <label class="info-box-text ">SiteZipCode</label>
                                           <input type="text" class="form-control input-border" value="{{ $property->site->SiteZipCode }}" name="SiteZipCode">
                                       </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="form-group">
                                            <label class="info-box-text ">SiteNeighborhood</label>
                                            <textarea class="form-control input-border" name="SiteNeighborhood">{{ $property->site->SiteNeighborhood }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                      <div class="form-group">
                                          <label class="info-box-text ">LegalDesc</label>
                                          <textarea class="form-control input-border" name="LegalDesc">{{ $property->LegalDesc }}</textarea>
                                      </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                      <div class="form-group">
                                          <label class="info-box-text ">X_DD</label>
                                          <input type="text" class="form-control input-border" name="X_DD" value="{{ $property->X_DD }}">
                                      </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                       <div class="form-group">
                                           <label class="info-box-text ">Y_DD</label>
                                           <input type="text" class="form-control input-border" name="Y_DD" value="{{ $property->Y_DD }}">
                                       </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="form-group">
                                            <label class="info-box-text ">GeoType</label>
                                            <input type="text" class="form-control input-border" value="{{ $property->GeoType }}" name="GeoType">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="form-group">
                                            <label class="info-box-text ">PropertyUse</label>
                                            <input type="text" class="form-control input-border" value="{{ $property->PropertyUse }}" name="PropertyUse">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                       <div class="form-group">
                                           <label class="info-box-text text-center ">ActiveFlag</label>
                                           <input type="text" class="form-control input-border" value="{{ $property->ActiveFlag }}" name="ActiveFlag">
                                       </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="form-group">
                                            <label class="info-box-text ">SiteStreetNumber</label>
                                            <input type="text" class="form-control input-border" value="{{ $property->site->SiteStreetNumber }}" name="SiteStreetNumber">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                       <div class="form-group">
                                           <label class="info-box-text ">SiteStreetPreDir</label>
                                           <input type="text" class="form-control input-border" value="{{ $property->site->SiteStreetPreDir }}" name="SiteStreetPreDir">
                                       </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="">
                                            <div class="form-group">
                                                <label class="info-box-text ">SiteStreetName</label>
                                                <input type="text" class="form-control input-border" value="{{ $property->site->SiteStreetName }}" name="SiteStreetName">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="">
                                            <div class="form-group">
                                                <label class="info-box-text ">SiteStreetType</label>
                                                <input type="text" class="form-control input-border" value="{{ $property->site->SiteStreetType }}" name="SiteStreetType">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="">
                                            <div class="form-group">
                                                <label class="info-box-text ">SiteStreetPostDir</label>
                                                <input type="text" class="form-control input-border" name="SiteStreetPostDir" value="{{ $property->site->SiteStreetPostDir }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="">
                                            <div class="form-group">
                                                <label class="info-box-text  ">CommCommunityID</label>
                                                <input type="text" class="form-control input-border" name="CommCommunityID" value="{{ $property->CommCommunityID }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="">
                                            <div class="form-group">
                                                <label class="info-box-text ">IDX_Address</label>
                                               <input type="text" name="IDX_Address" class="form-control input-border" value="{{ $property->IDX_Address }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="">
                                            <div class="form-group">
                                                <label class="info-box-text ">OwnerAddress</label>
                                                <input type="text" class="form-control input-border" value="{{ $property->owner->OwnerAddress }}" name="OwnerAddress">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="">
                                            <div class="form-group">
                                                <label class="info-box-text ">OwnerCity</label>
                                                <input type="text" class="form-control input-border" value="{{ $property->owner->OwnerCity }}" name="OwnerCity">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="">
                                            <div class="form-group">
                                                <label class="info-box-text ">OwnerState</label>
                                                <input type="text" class="form-control input-border" value="{{ $property->owner->OwnerState }}" name="OwnerState">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="">
                                            <div class="form-group">
                                                <label class="info-box-text ">OwnerZipcode</label>
                                                <input type="text" class="form-control input-border" value="{{ $property->owner->OwnerZipcode }}" name="OwnerZipcode">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="">
                                            <div class="form-group">
                                                <label class="info-box-text ">OwnerStreetNumber</label>
                                                <input type="text" class="form-control input-border" value="{{ $property->owner->OwnerStreetNumber }}" name="OwnerStreetNumber">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="">
                                            <div class="form-group">
                                                <label class="info-box-text ">OwnerStreetPreDir</label>
                                                <input type="text" class="form-control input-border" value="{{ $property->owner->OwnerStreetPreDir }}" name="OwnerStreetPreDir">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="">
                                            <div class="form-group">
                                                <label class="info-box-text ">OwnerStreetName</label>
                                                <input type="text" class="form-control input-border" name="OwnerStreetName"  value="{{ $property->owner->OwnerStreetName }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="">
                                            <div class="form-group">
                                                <label class="info-box-text ">OwnerStreetType</label>
                                                <input type="text" class="form-control input-border" value="{{ $property->owner->OwnerStreetType }}" name="OwnerStreetType">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="">
                                            <div class="form-group">
                                                <label class="info-box-text ">OwnerStreetPostDir</label>
                                                <input type="text" class="form-control input-border" value="{{ $property->owner->OwnerStreetPostDir }}" name="OwnerStreetPostDir">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="">
                                            <div class="form-group">
                                                <label class="info-box-text ">OwnerUnit</label>
                                                <input type="text" class="form-control input-border" value="{{ $property->owner->OwnerUnit }}" name="OwnerUnit">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="">
                                            <div class="form-group">
                                                <label class="info-box-text ">OwnerOccupiedFlag</label>
                                                <input type="text" class="form-control input-border" value="{{ $property->owner->OwnerOccupiedFlag }}" name="OwnerOccupiedFlag">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="">
                                            <div class="form-group">
                                                <label class="info-box-text ">OwnerOccupiedCode</label>
                                                <input type="text" class="form-control input-border" value="{{ $property->owner->OwnerOccupiedCode }}" name="OwnerOccupiedCode">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="">
                                            <div class="form-group">
                                                <label class="info-box-text ">NumberofUnits</label>
                                                <input type="text" class="form-control input-border" value="{{ $property->NumberofUnits }}" name="NumberofUnits">
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
        $(document).on('submit','form#property_edit_form',function(event){
            event.preventDefault();
            var form = $(this);
            var data = new FormData($(this)[0]);
            var url = $(this).attr('action');
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
                     alert('Successfully Updated.');
                     window.location = "/noo-property-list";
                }
            });
        });
    </script>
@endsection
