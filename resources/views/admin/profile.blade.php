@extends('admin.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Profile</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{URL::to('/')}}/admin/dashboard">Home</a></li>
              <li class="breadcrumb-item active">Profile</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
          <div class="row">
              <div class="col-12">
                  <div class="card">
                      <div class="card-header">
                          <h3 class="card-title">Update Profile</h3>
                      </div>
                      <!-- /.card-header -->
                      <div class="card-body">
                              @csrf
                              <input type="hidden" id="id" value="{{$admin->id}}">
                              <div class="form-group row">
                                  <label for="inputPassword3" class="col-sm-3 col-form-label">Email</label>
                                  <div class="col-sm-9">
                                      <input type="text" class="form-control" id="email" name="email" disabled placeholder="Email" required="" value="{{$admin->email}}">
                                  </div>
                              </div>
                              <div class="form-group row">
                                  <label for="inputPassword3" class="col-sm-3 col-form-label">Name</label>
                                  <div class="col-sm-9">
                                      <input type="text" class="form-control" id="name" name="name" placeholder="Name" required="" value="{{$admin->name}}">
                                  </div>
                              </div>
                              <div class="form-group row">
                                  <button type="button" class="btn btn-primary"  onclick="updateProfile()">Save changes</button>
                              </div>
                          </div>
                      <!-- /.card-body -->
                  </div>
              </div>
          </div><!-- /.container-fluid -->
      </div><!-- /.container-fluid -->

    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection
