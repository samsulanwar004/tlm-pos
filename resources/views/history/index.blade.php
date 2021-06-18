@section('title', 'History')
@extends('layouts.admin_layout.admin_layout')
@section('content')

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">History</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
              <li class="breadcrumb-item active">History</li>
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
                <a href="#" class="btn btn-dark invisible">
                  <i class="fa fa-plus"></i> Add
                </a>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive">
                <div class="table large">
                  <x-datatable.table>
                    <th data-data="DT_RowIndex" class="font-weight-bold text-center text-uppercase" data-orderable="false" data-searchable="false">No</th>
                    <th data-data="id" class="font-weight-bold text-center text-uppercase">Master Order ID</th>
                    <th data-data="number_reference" class="font-weight-bold text-center text-uppercase">Number Reference</th>
                    <th data-data="status" class="font-weight-bold text-center text-uppercase">Status</th>
                    <th data-data="action" class="font-weight-bold text-center text-uppercase" data-orderable="false" data-searchable="false" style="width: 8%">Action</th>
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