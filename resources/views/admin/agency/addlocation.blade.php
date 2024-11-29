@php
$route = 'admin.package.';
@endphp
@extends('layouts.app', ['title' => _lang('location'), 'modal' => 'lg'])
@push('admin.css')
<link href="{{asset('assets/node_modules/summernote/dist/summernote.css')}}" rel="stylesheet" />
@endpush
@section('pageheader')

<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">{{_lang('add-location')}}</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">{{_lang('add-location')}}</li>
            </ol>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
@stop
@section('content')

<form action="{{ route('admin.submit-location') }}">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <label for="city">City</label>
            <input class="form-control" type="text" name="city" placeholder="Enter city">
        </div>
        <div class="col-md-6">
            <label for="country">Country</label>
            <input class="form-control" type="text" name="country" placeholder="Enter country">
        </div>
        <div class="ml-auto mt-4 mx-2">
            <button class="btn btn-block btn-lg btn-info" type="submit">Create</button>
        </div>
    </div>
</form>

<!-- /basic initialization -->
@stop
