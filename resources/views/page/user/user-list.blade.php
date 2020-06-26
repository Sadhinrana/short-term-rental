@extends('layouts.app')
@section('title')
    User List
@endsection
@section('content')
    <section class="content">
        <div class="container-fluid">
            <!-- SELECT2 EXAMPLE -->
            @if(\Session::has('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fas fa-check"></i> Success!</h5>
                    {{ \Session::get('success') }}
                </div>
            @endif
            <div class="card card-default">
                <div class="card-header">
                    <a href="{{ route('users.create') }}" class="btn btn-success" style="float: right"><i class="fa fa-plus-circle"></i> Create user</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-custom">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>User Name</th>
                                    <th class="text-center">Match Vote</th>
                                    <th class="text-center">Mismatches Vote</th>
                                    <th class="text-center">Unsure Vote</th>
                                    <th>Community</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($users)
                                    @foreach($users as $key=>$row)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $row->name }}</td>
                                            <td class="text-center">{{ count($row->match_vote) > 0 ? count($row->match_vote):'' }}</td>
                                            <td class="text-center">{{ count($row->missmatch_vote) > 0 ? count($row->missmatch_vote):'' }}</td>
                                            <td class="text-center">{{ count($row->unsure_vote) >0  ? count($row->unsure_vote):'' }}</td>
                                            <td>
                                                @foreach($row->communities as $k => $community)
                                                    {{ ($k!=0)?', ' : '' }}
                                                    {{ $community->community }}
                                                @endforeach
                                            </td>
                                            <td class="text-center">
                                                <form action="{{ route('users.destroy', $row->id) }}" method="post">
                                                    <a class="btn btn-primary btn-xs"
                                                       href="{{ route('user.details',[$row->id]) }}" title="Details"><i
                                                            class="fas fa-info"></i></a>
                                                    <a class="btn btn-success btn-xs"
                                                       onclick="AssignCommunity({{ $row->id }})" data-toggle="modal"
                                                       data-target="#exampleModal"
                                                       href="{{ route('user.details',[$row->id]) }}"
                                                       title="Assign Community"><i class="fab fa-atlassian"></i></a>
                                                    <a class="btn btn-xs btn-yellow" title="Edit" href="{{ route('users.edit', $row->id) }}"><i class="fas fa-edit"></i></a>
                                                    @csrf
                                                    @method('delete')
                                                    <a class="btn btn-xs btn-danger" title="Delete" href="javascript:void(0)" onclick="deleteUser(this)"><i class="fas fa-trash"></i></a>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5">No Data Found</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                        <div style="float: left">{{ $users->links() }}</div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('assign.community') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Assign Community</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <lable class="col-md-4">Select City</lable>
                            <div class="col-md-8">
                                <input type="hidden" class="user-id" name="user_id">
                                <select class="form-control select2" multiple name="city[]">
                                    @foreach($masterProperty as $row)
                                        <option value="{{ $row->name }}">{{ $row->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i>
                            Assign
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        function AssignCommunity(id) {
            $('.user-id').val(id);
        }

        function deleteUser(_this) {
            swal({
                title: "Are you sure?",
                text: "You will not be able to recover!",
                icon: "warning",
                buttons: [
                    'No, cancel it!',
                    'Yes, I am sure!'
                ],
                dangerMode: true,
            }).then(function(isConfirm) {
                if (isConfirm) {
                    $(_this).closest("form").submit(); // <--- submit form programmatically
                }
            })
        }
    </script>
@endsection
