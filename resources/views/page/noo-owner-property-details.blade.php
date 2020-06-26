@extends('layouts.app')
@section('title')
    Noo Property Owner Details
@endsection
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- SELECT2 EXAMPLE -->
            <div class="card card-default">
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-12">
                            <ul class="list-group list-group-unbordered">
                                <li class="list-group-item">
                                    <strong>Name One</strong>
                                    <span class="float-right">{{ $owner->OwnerName1 }}</span>
                                </li>
                                <li class="list-group-item">
                                    <strong>Name Two</strong>
                                    <span class="float-right">{{ $owner->OwnerName2 }}</span>
                                </li>
                                <li class="list-group-item">
                                    <strong>Address</strong>
                                    <span class="float-right">{{ $owner->OwnerAddress }}</span>
                                </li>
                                <li class="list-group-item">
                                    <strong>City</strong>
                                    <span class="float-right">{{ $owner->OwnerCity }}</span>
                                </li>
                                <li class="list-group-item">
                                    <strong>State</strong>
                                    <span class="float-right">{{ $owner->OwnerState }}</span>
                                </li>
                                <li class="list-group-item">
                                    <strong>Zip-code</strong>
                                    <span class="float-right">{{ $owner->OwnerZipcode }}</span>
                                </li>
                                <li class="list-group-item">
                                    <strong>Street Pre Dir</strong>
                                    <span class="float-right">{{ $owner->OwnerStreetPreDir }}</span>
                                </li>
                                <li class="list-group-item">
                                    <strong>Street Name</strong>
                                    <span class="float-right">{{ $owner->OwnerStreetName }}</span>
                                </li>
                                <li class="list-group-item">
                                    <strong>Street Type</strong>
                                    <span class="float-right">{{ $owner->OwnerStreetType }}</span>
                                </li>
                                <li class="list-group-item">
                                    <strong>Street Post Dir</strong>
                                    <span class="float-right">{{ $owner->OwnerStreetPostDir }}</span>
                                </li>
                                <li class="list-group-item">
                                    <strong>Unit</strong>
                                    <span class="float-right">{{ $owner->OwnerUnit }}</span>
                                </li>
                                <li class="list-group-item">
                                    <strong>Occupied Flag</strong>
                                    <span class="float-right">{{ $owner->OwnerOccupiedFlag }}</span>
                                </li>
                                <li class="list-group-item">
                                    <strong>Occupied Code</strong>
                                    <span class="float-right">{{ $owner->OwnerOccupiedCode }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>

            <!-- Owner Property List -->
            <div class="card card-default">
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-12">
                            <table class="table table-custom">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>PropertyGID</th>
                                    <th>Site Address</th>
                                    <th>Site City</th>
                                    <th>Site State</th>
                                </tr>
                                </thead>
                                <tbody id="accordionExample">
                                @if(!$owner->NOOProperties->isEmpty())
                                    @foreach($owner->NOOProperties as $key=> $row)
                                        <tr data-toggle="collapse" data-target="#collapse-{{$row->Id}}"
                                            aria-expanded="true" aria-controls="collapseOne" id="heading-{{$row->Id}}"
                                            style="cursor: pointer;{{($key+=1)%2==0?'background-color: #ffffff;':''}}">
                                            <td>
                                                {{ $key }}
                                            </td>
                                            <td>
                                                <a href="{{ route('property.detail', $row->Id) }}">{{ $row->PropertyGID }}</a>
                                            </td>
                                            <td>
                                                {{ $row->site->SiteAddress }}
                                            </td>
                                            <td>
                                                {{ $row->site->SiteCity }}
                                            </td>
                                            <td>
                                                {{ $row->site->SiteState }}
                                            </td>
                                        </tr>
                                        <tr id="collapse-{{$row->Id}}" class="collapse"
                                            aria-labelledby="heading-{{$row->Id}}" data-parent="#accordionExample">
                                            <td colspan="8">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <div class="col-md-12 text-center">
                                                                @if($row->image)
                                                                    <img src="{{ asset($row->image) }}"
                                                                         style="text-align: center"
                                                                         width="600">
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <ul class="list-group list-group-unbordered">
                                                            <li class="list-group-item">
                                                                <span class="info-box-text text-center text-muted"><b>PropertyGID</b></span>
                                                                <span
                                                                    class="float-right info-box-number text-center text-muted mb-0">{{ $row->PropertyGID ? $row->PropertyGID:'--' }} </span>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <span class="info-box-text text-center text-muted"><b>OwnerName1</b></span>
                                                                <span
                                                                    class="float-right info-box-number text-center text-muted mb-0">{{ $row->owner->OwnerName1 ? $row->owner->OwnerName1:'--' }} </span>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <span class="info-box-text text-center text-muted"><b>OwnerName2</b></span>
                                                                <span
                                                                    class="float-right info-box-number text-center text-muted mb-0">{{ $row->owner->OwnerName2 ? $row->owner->OwnerName2:'--' }} </span>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <span class="info-box-text text-center text-muted"><b>ParcelID</b></span>
                                                                <span
                                                                    class="float-right info-box-number text-center text-muted mb-0">{{ $row->ParcelID ? $row->ParcelID:'--' }} </span>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <span class="info-box-text text-center text-muted"><b>ParcelLong</b></span>
                                                                <span
                                                                    class="float-right info-box-number text-center text-muted mb-0">{{ $row->ParcelLong ? $row->ParcelLong:'--' }} </span>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <span class="info-box-text text-center text-muted"><b>TaxAccount</b></span>
                                                                <span
                                                                    class="float-right info-box-number text-center text-muted mb-0">{{ $row->TaxAccount ? $row->TaxAccount:'--' }} </span>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <span class="info-box-text text-center text-muted"><b>ParcelCity</b></span>
                                                                <span
                                                                    class="float-right info-box-number text-center text-muted mb-0">{{ $row->ParcelCity ? $row->ParcelCity:'--' }} </span>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <span class="info-box-text text-center text-muted"><b>SiteAddress</b></span>
                                                                <span
                                                                    class="float-right info-box-number text-center text-muted mb-0">{{ $row->site->SiteAddress ? $row->site->SiteAddress:'--' }} </span>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <span class="info-box-text text-center text-muted"><b>SiteUnit</b></span>
                                                                <span
                                                                    class="float-right info-box-number text-center text-muted mb-0">{{ $row->site->SiteUnit ? $row->site->SiteUnit:'--' }} </span>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <span class="info-box-text text-center text-muted"><b>SiteCity</b></span>
                                                                <span
                                                                    class="float-right info-box-number text-center text-muted mb-0">{{ $row->site->SiteCity ? $row->site->SiteCity:'--' }} </span>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <span class="info-box-text text-center text-muted"><b>SiteState</b></span>
                                                                <span
                                                                    class="float-right info-box-number text-center text-muted mb-0">{{ $row->site->SiteState ? $row->site->SiteState:'--' }} </span>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <span class="info-box-text text-center text-muted"><b>SiteZipCode</b></span>
                                                                <span
                                                                    class="float-right info-box-number text-center text-muted mb-0">{{ $row->site->SiteZipCode ? $row->site->SiteZipCode:'--' }} </span>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <span class="info-box-text text-center text-muted"><b>SiteNeighborhood</b></span>
                                                                <span
                                                                    class="float-right info-box-number text-muted mb-0">{{ $row->site->SiteNeighborhood ? $row->site->SiteNeighborhood:'--' }} </span>
                                                            </li>
                                                        </ul>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <ul class="list-group list-group-unbordered">
                                                            <li class="list-group-item">
                                                                <span class="info-box-text text-center text-muted"><b>LegalDesc</b></span>
                                                                <span
                                                                    class="float-right info-box-number  text-muted mb-0">{{ $row->LegalDesc ? $row->LegalDesc:'--' }} </span>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <span class="info-box-text text-center text-muted"><b>X_DD</b></span>
                                                                <span
                                                                    class="float-right info-box-number text-center text-muted mb-0">{{ $row->X_DD ? $row->X_DD:'--' }} </span>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <span class="info-box-text text-center text-muted"><b>Y_DD</b></span>
                                                                <span
                                                                    class="float-right info-box-number text-center text-muted mb-0">{{ $row->Y_DD ? $row->Y_DD:'--' }} </span>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <span class="info-box-text text-center text-muted"><b>GeoType</b></span>
                                                                <span
                                                                    class="float-right info-box-number text-center text-muted mb-0">{{ $row->GeoType ? $row->GeoType:'--' }} </span>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <span class="info-box-text text-center text-muted"><b>PropertyUse</b></span>
                                                                <span
                                                                    class="float-right info-box-number text-center text-muted mb-0">{{ $row->PropertyUse ? $row->PropertyUse:'--' }} </span>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <span class="info-box-text text-center text-muted"><b>ActiveFlag</b></span>
                                                                <span
                                                                    class="float-right info-box-number text-center text-muted mb-0">{{ $row->ActiveFlag ? $row->ActiveFlag:'--' }} </span>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <span class="info-box-text text-center text-muted"><b>SiteStreetNumber</b></span>
                                                                <span
                                                                    class="float-right info-box-number text-center text-muted mb-0">{{ $row->site->SiteStreetNumber ? $row->site->SiteStreetNumber:'--' }} </span>
                                                            </li>
                                                            <li class="list-group-item">
                                            <span
                                                class="info-box-text text-center text-muted"><b>SiteStreetPreDir</b></span>
                                                                <span
                                                                    class="float-right info-box-number text-center text-muted mb-0">{{ $row->site->SiteStreetPreDir ? $row->site->SiteStreetPreDir:'--' }} </span>
                                                            </li>
                                                            <li class="list-group-item">
                                            <span
                                                class="info-box-text text-center text-muted"><b>SiteStreetName</b></span>
                                                                <span
                                                                    class="float-right info-box-number text-center text-muted mb-0">{{ $row->site->SiteStreetName ? $row->site->SiteStreetName:'--' }} </span>
                                                            </li>
                                                            <li class="list-group-item">
                                            <span
                                                class="info-box-text text-center text-muted"><b>SiteStreetType</b></span>
                                                                <span
                                                                    class="float-right info-box-number text-center text-muted mb-0">{{ $row->site->SiteStreetType ? $row->site->SiteStreetType:'--' }} </span>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <span class="info-box-text text-center text-muted"><b>SiteStreetPostDir</b></span>
                                                                <span
                                                                    class="float-right info-box-number text-center text-muted mb-0">{{ $row->site->SiteStreetPostDir ? $row->site->SiteStreetPostDir:'--' }} </span>
                                                            </li>
                                                            <li class="list-group-item">
                                            <span
                                                class="info-box-text text-center text-muted"><b>CommCommunityID</b></span>
                                                                <span
                                                                    class="float-right info-box-number text-center text-muted mb-0">{{ $row->CommCommunityID ? $row->CommCommunityID:'--' }} </span>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <span class="info-box-text text-center text-muted"><b>IDX_Address</b></span>
                                                                <span
                                                                    class="float-right info-box-number text-center text-muted mb-0">{{ $row->IDX_Address ? $row->IDX_Address:'--' }} </span>
                                                            </li>
                                                            <li class="list-group-item">
                                            <span
                                                class="info-box-text text-center text-muted"><b>OwnerAddress</b></span>
                                                                <span
                                                                    class="float-right info-box-number text-center text-muted mb-0">{{ $row->owner->OwnerAddress ? $row->owner->OwnerAddress:'--' }} </span>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <span class="info-box-text text-center text-muted"><b>OwnerCity</b></span>
                                                                <span
                                                                    class="float-right info-box-number text-center text-muted mb-0">{{ $row->owner->OwnerCity ? $row->owner->OwnerCity:'--' }} </span>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <span class="info-box-text text-center text-muted"><b>OwnerState</b></span>
                                                                <span
                                                                    class="float-right info-box-number text-center text-muted mb-0">{{ $row->owner->OwnerState ? $row->owner->OwnerState:'--' }} </span>
                                                            </li>
                                                            <li class="list-group-item">
                                            <span
                                                class="info-box-text text-center text-muted"><b>OwnerZipcode</b></span>
                                                                <span
                                                                    class="float-right info-box-number text-center text-muted mb-0">{{ $row->owner->OwnerZipcode ? $row->owner->OwnerZipcode:'--' }} </span>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <span class="info-box-text text-center text-muted"><b>OwnerStreetNumber</b></span>
                                                                <span
                                                                    class="float-right info-box-number text-center text-muted mb-0">{{ $row->owner->OwnerStreetNumber ? $row->owner->OwnerStreetNumber:'--' }} </span>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <span class="info-box-text text-center text-muted"><b>OwnerStreetPreDir</b></span>
                                                                <span
                                                                    class="float-right info-box-number text-center text-muted mb-0">{{ $row->owner->OwnerStreetPreDir ? $row->owner->OwnerStreetPreDir:'--' }} </span>
                                                            </li>
                                                            <li class="list-group-item">
                                            <span
                                                class="info-box-text text-center text-muted"><b>OwnerStreetName</b></span>
                                                                <span
                                                                    class="float-right info-box-number text-center text-muted mb-0">{{ $row->owner->OwnerStreetName ? $row->owner->OwnerStreetName:'--' }} </span>
                                                            </li>
                                                            <li class="list-group-item">
                                            <span
                                                class="info-box-text text-center text-muted"><b>OwnerStreetType</b></span>
                                                                <span
                                                                    class="float-right info-box-number text-center text-muted mb-0">{{ $row->owner->OwnerStreetType ? $row->owner->OwnerStreetType:'--' }} </span>
                                                            </li>
                                                            <li class="list-group-item">
                                            <span
                                                class="info-box-text text-center text-muted"><b>NumberofUnits</b></span>
                                                                <span
                                                                    class="float-right info-box-number text-center text-muted mb-0">{{ $row->owner->NumberofUnits ? $row->owner->NumberofUnits:'--' }} </span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <!-- /.card-body -->
                                                </div>
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
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div><!-- /.Owner Property List -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

