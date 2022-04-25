@extends('admin.app')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        {{--                        <h1 class="m-0">Users</h1>--}}
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{URL::to('/')}}/admin/dashboard">Home</a></li>
                            <li class="breadcrumb-item active">Change Password</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Change Password</h3>
                            </div>
                            <!-- /.card-header -->
                            <form class="form-horizontal" method="post" action="{{URL::to('/')}}/admin/change-password">
                                <div class="card-body">

                                    @csrf
                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-3 col-form-label">Old Password</label>
                                        <div class="col-sm-9">
                                            <input type="password" class="form-control" id="old-password"
                                                   name="old_password" placeholder="Old Password" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-3 col-form-label">New Password</label>
                                        <div class="col-sm-9">
                                            <input type="password" class="form-control" id="new-password"
                                                   name="new_password" placeholder="New Password" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-3 col-form-label">Confirm
                                            Password</label>
                                        <div class="col-sm-9">
                                            <input type="password" class="form-control" id="confirm-password"
                                                   name="confirm_password" placeholder="Confirm Password" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-info">Change Password</button>
                                </div>
                            </form>

                            <!-- /.card-body -->
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
    </div>
@endsection
