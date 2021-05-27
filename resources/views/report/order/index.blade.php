@section('title', 'Report Order')
@extends('layouts.admin_layout.admin_layout')
@section('content')

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Report Order</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
              <li class="breadcrumb-item">Report</li>
              <li class="breadcrumb-item active">Report Order</li>
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
                <div class="row">
                  <div class="col-md-2">
                    <x-input.select label="Tenant" name="tenant"/>
                  </div>
                  <div class="col-md-2">
                    <x-input.date label="Start Period" name="start_period" placeholder="Input start date"/>
                  </div>
                  <div class="col-md-2">
                    <x-input.date label="End Period" name="end_period" placeholder="Input end date"/>
                  </div>
                </div>
                <div class="row">
                  <button class="btn btn-dark btn-view ml-2">View</button>
                  <button class="btn btn-success btn-download ml-2 mr-2">Download</button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive">
                <div class="table large" id="tbl-content"></div>
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

@section('header_scripts')
<style type="text/css">
  .fixed-table{
    width: 100%;
    table-layout: fixed;
    border-collapse: collapse;
  }

  .fixed-table td {
    /* css-3 */
    white-space: -o-pre-wrap; 
    word-wrap: break-word;
    white-space: pre-wrap; 
    white-space: -moz-pre-wrap; 
    white-space: -pre-wrap; 
  }

  .container-table{
    overflow: auto; 
    max-width: 100%; 
    white-space: nowrap;
    height: 50px;
  }

  .container-table-content{
    overflow: auto;
    max-width: 100%; 
    white-space: nowrap;
    height: 300px;
  }

  .container-table::-webkit-scrollbar {
    display: none;
  }

  .container-table {
    -ms-overflow-style: none;
    scrollbar-width: none;
    overflow-y: hidden;
  }
</style>
@endsection

@section('footer_scripts')
  <script type="text/javascript">
    (function () {

      let selectTenant = $('#tenant');
      let startPeriod = $("#start_period");
      let endPeriod = $("#end_period");
      let btnView = $(".btn-view");
      let btnDownload = $(".btn-download");

      init();

      function init()
      {

        selectTenant.select2({
          theme: 'bootstrap4',
          placeholder: 'Select Tenant',
          multiple: true
        });

        startPeriod.on('change', function(e) {
          endPeriod.val(e.target.value);
        });

        btnView.on('click', function(e) {
          if (startPeriod.val() == '') {
            Swal.fire({
              position: 'center',
              icon: 'warning',
              title: 'Start Period is required',
              showConfirmButton: false,
              timer: 1500
            });
          } else if(endPeriod.val() == '') {
            Swal.fire({
              position: 'center',
              icon: 'warning',
              title: 'End Period is required',
              showConfirmButton: false,
              timer: 1500
            });
          } else {
            view();
          }
        });

        btnDownload.on('click', function(e) {
          if (startPeriod.val() == '') {
            Swal.fire({
              position: 'center',
              icon: 'warning',
              title: 'Start Period is required',
              showConfirmButton: false,
              timer: 1500
            });
          } else if(endPeriod.val() == '') {
            Swal.fire({
              position: 'center',
              icon: 'warning',
              title: 'End Period is required',
              showConfirmButton: false,
              timer: 1500
            });
          } else {
            download();
          }
        });

        tenant();

      }

      function view()
      {
        let tenant = selectTenant.val();
        let start = startPeriod.val();
        let end = endPeriod.val();

        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        $.ajax({
          type:"POST",
          dataType: "html",
          beforeSend : function() {
            Swal.fire({
              title: 'Please Wait !',
              html: 'Data on load',// add html attribute if you want or remove
              allowOutsideClick: false,
              onBeforeOpen: () => {
                Swal.showLoading()
              },
            });
          },
          url: '{{route('report.order.view')}}',
          data : "start="+start+"&end="+end+"&tenant="+tenant,
          success:function(res){
            Swal.hideLoading()
            response = res;
            $('#tbl-content').html(response);
          },
          error:function(){
            Swal.fire({
              position: 'center',
              icon: 'error',
              title: 'Load failed',
              showConfirmButton: false,
              timer: 1500
            });
          }
        });
      }

      function download()
      {
        let tenant = selectTenant.val();
        let start = startPeriod.val();
        let end = endPeriod.val();

        window.location.href = '{{route('report.order.export')}}?'+'start='+start+'&end='+end+"&tenant="+tenant;
      }

      function tenant() {
            
        $.ajax({
          type:"GET",
          dataType: "json",
          beforeSend : function() {
          },
          url: '{{route('report.order.tenant')}}',
          success:function(res){
            selectTenant.empty().select2({
              theme: 'bootstrap4',
              placeholder: 'Select Tenant',
              data: $.map(res.data, function (o) {
                  o.id = o.id;
                  o.text = o.name;
                  return o;
              }),
            });
            selectTenant.val(null).trigger('change');
          },
          error:function(){

          }
        });
        }
    })();
  </script>
@endsection