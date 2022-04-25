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
                            <li class="breadcrumb-item active">Users</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Urls List</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="user-datatable" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>S. No.</th>
                                        <th>Original Url</th>
                                        <th>Short Url</th>
                                        <th>Expiry</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>S. No.</th>
                                        <th>Original Url</th>
                                        <th>Short Url</th>
                                        <th>Expiry</th>
                                        <th>Action</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
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

    <div class="modal" tabindex="-1" role="dialog" id="update-url-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update URL</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                        <div class="card-body">

                            @csrf
                            <input type="hidden" id="id">
                            <div class="form-group row">
                                <label for="inputPassword3" class="col-sm-3 col-form-label">Original URL</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="original_url" name="original_url" placeholder="Original URL" required="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputPassword3" class="col-sm-3 col-form-label">Short URL</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="short_url" name="short_url" placeholder="Short URL" required="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputPassword3" class="col-sm-3 col-form-label">Expiry</label>
                                <div class="col-sm-9">
                                    <input type="date" min="{{date('Y-m-d')}}" class="form-control" id="expiry" name="expiry" placeholder="Expiry" required="">
                                </div>
                            </div>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary"  onclick="updateUrl()">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
