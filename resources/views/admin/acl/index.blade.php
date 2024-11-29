@extends('layouts.app', ['title' => 'Role', 'modal' => false])
@push('admin.css')
<link rel="stylesheet" type="text/css"
href="{{asset('assets/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css')}}">
<link rel="stylesheet" type="text/css"
href="{{asset('assets/node_modules/datatables.net-bs4/css/responsive.dataTables.min.css')}}">
@endpush
@section('pageheader')

<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Dashboard 1</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Dashboard 1</li>
            </ol>
          
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
@stop
@section('content')
<!-- Basic initialization -->
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Role Permission List</h4>
        <h6 class="card-subtitle">  <a href="{{ route('admin.user.role.create') }}" class="btn btn-info m-l-15"><i class="ti-plus"></i> Create New</a></h6>
        <div class="table-responsive m-t-40">
            <table class="table table-bordered table-striped content_managment_table" data-url="{{ route('admin.user.role.datatable') }}">
                <thead>
                    <tr>
                      <th>{{__('id')}}</th>
                      <th>{{__('role_permission')}}</th>
                      <th>{{__('action')}}</th>
                  </tr>
              </thead>
              <tbody>
              </tbody>
          </table>
      </div>
  </div>
</div>
<!-- /basic initialization -->
@stop
@push('admin.scripts')
<script src="{{asset('assets/node_modules/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('js/role.js')}}"></script>

<!-- start - This is for export functionality only -->
@endpush