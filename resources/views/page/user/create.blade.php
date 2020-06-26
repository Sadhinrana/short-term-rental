@extends('layouts.app')
@section('title')
    Create User
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
                    Store user
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="post" action="{{ route('users.store') }}">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <label class="col-md-2">Name</label>
                                <div class="form-group col-md-4">
                                    <input type="text" name="name" class="form-control input-border @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Enter name">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <label class="col-md-2">Email address</label>
                                <div class="form-group col-md-4">
                                    <input type="email" name="email" class="form-control input-border  @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Enter email">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <label class="col-md-2">Select Role</label>
                                <div class="form-group col-md-4">
                                    <select class="form-control input-border @error('role') is-invalid @enderror" name="role">
                                        <option value="">Select Role</option>
                                        <option value="0">User</option>
                                        <option value="1">Admin</option>
                                    </select>
                                    @error('role')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <label class="col-md-2">Select City</label>
                                <div class="form-group col-md-4">
                                    <select class="form-control select2 @error('city') is-invalid @enderror" multiple name="city[]">
                                        @foreach($masterProperty as $row)
                                            <option value="{{ $row->name }}">{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <label class="col-md-2">Password</label>
                                <div class="form-group col-md-4">
                                    <input type="password" name="password" class="form-control input-border @error('password') is-invalid @enderror" placeholder="Password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <label class="col-md-2">Confirm Password</label>
                                <div class="form-group col-md-4">
                                    <input type="password" name="password_confirmation" class="form-control input-border" placeholder="Confirm password">
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i>  Submit</button>
                        </div>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <style>
        .invalid-feedback{
            display: block;
        }
    </style>
@endsection
