@section('title', 'Tenant')
@extends('layouts.admin_layout.admin_layout')
@section('content')

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Tenant</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
              <li class="breadcrumb-item">Master</li>
              <li class="breadcrumb-item active">Tenant</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card card-secondary">
              <div class="card-header">
                <a href="{{ route('master.tenant.create') }}" class="btn btn-dark">
                  <i class="fa fa-plus"></i> Add
                </a>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive">
                <div class="table large">
                  <x-datatable.table>
                    <th data-data="id" class="font-weight-bold text-center text-uppercase">Tenant ID</th>
                    <th data-data="name" class="font-weight-bold text-center text-uppercase">Tenant Name</th>
                    <th data-data="username" class="font-weight-bold text-center text-uppercase">Username</th>
                    <th data-data="status" class="font-weight-bold text-center text-uppercase">Status</th>
                    <th data-data="action" class="font-weight-bold text-center text-uppercase" data-orderable="false" data-searchable="false" style="width: 15%">Action</th>
                  </x-datatable.table>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
<!-- /.content-wrapper -->

@endsection