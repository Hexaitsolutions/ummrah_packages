@extends('layouts.app', ['title' => _lang('location'), 'modal' => 'lg'])
@push('admin.css')
<link rel="stylesheet" type="text/css"
href="{{asset('assets/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css')}}">
<link rel="stylesheet" type="text/css"
href="{{asset('assets/node_modules/datatables.net-bs4/css/responsive.dataTables.min.css')}}">
<style>
    .table-responsive,.card-title{
        color:white !important;
    }
</style>
@endpush
@section('pageheader')

<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">{{_lang('location')}}</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">{{_lang('location')}}</li>
            </ol>
            <a href="{{ route('admin.add-location') }}" class="btn btn-info  d-lg-block m-l-15"><i class="ti-plus"></i> Create New</a>
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
        <h4 class="card-title">Location Information</h4>
        <div class="table-responsive m-t-40">
            <table class="table table-bordered table-striped data_managment_table">
                <thead>
                   <tr>
                    <th>{{_lang('id')}}</th>
                    <th>{{_lang('city')}}</th>
                    <th>{{_lang('country')}}</th>
                    <th>{{_lang('action')}}</th>
                   </tr>
                </thead>
                <tbody>
                    @foreach ($location as $loc)
                    <tr>
                        <td>{{$loc->id}}</td>
                        <td>{{$loc->city}}</td>
                        <td>{{$loc->country}}</td>
                        <td>
                            <a href="{{ route('admin.edit-location',$loc->id) }}" class="btn btn-info my-1" title="{{ __('Edit Permission') }}" data-popup="tooltip" data-placement="bottom"><i class=" icon-note"></i></a>
                            <a href="#" id="delete_item" data-id ="{{$loc->id}}" data-url="{{route('admin.delete-location',$loc->id) }}" class="btn btn-danger" title="{{ __('Delete Permission') }}" data-popup="tooltip" data-placement="bottom"><i class="icon-trash"></i></a>
                        </td>
                    </tr>
                    @endforeach
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
<script src="{{asset('js/package.js')}}"></script>

<!-- start - This is for export functionality only -->
@endpush
