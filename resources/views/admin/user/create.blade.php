@extends('layouts.app', ['title' => 'User', 'modal' => false])
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
    <h4 class="text-themecolor">{{_lang('user')}}</h4>
  </div>
  <div class="col-md-7 align-self-center text-right">
    <div class="d-flex justify-content-end align-items-center">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item active">{{_lang('user')}}</li>
      </ol>
    </div>
  </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->

@stop
@section('content')

<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-info">
        <h4 class="m-b-0 text-white">Other Sample form</h4>
      </div>
      <div class="card-body">
        {!! Form::open(['route' => 'admin.user.create', 'id'=>'content_form','files' => true, 'method' => 'POST']) !!}
        <fieldset class="mb-3" id="form_field">
         <div class="row">
          <div class="col-md-5">
            <div class="form-group">
              {{ Form::label('name', __('Name') , ['class' => 'col-form-label required']) }}
              {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Name'),'required'=>'']) }}
            </div>
          </div>

          <div class="col-md-5">
            <div class="form-group">
              {{ Form::label('phone', __('Phone Number') , ['class' => 'col-form-label required']) }}

              {{ Form::number('phone', null, ['class' => 'form-control', 'placeholder' => __('Phone Number'),'required'=>'']) }}
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              {{ Form::label('email', __('Email') , ['class' => 'col-form-label required']) }}

              {{ Form::text('email', null, ['class' => 'form-control', 'placeholder' => __('Email'),'required'=>'']) }}
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group">
              {{ Form::label('role', __('Role Name') , ['class' => 'col-form-label required']) }}
              {!! Form::select('role', $role, null, ['class' => 'form-control select', 'data-placeholder' => 'Select A Role', 'style' => 'width: 100%;']); !!}
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group">
              {{ Form::label('agency_name', __('Agency name') , ['class' => 'col-form-label required']) }}

              {{ Form::text('agency_name', null, ['class' => 'form-control', 'placeholder' => __('Agency name'),'required'=>'']) }}
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              {{ Form::label('password', __('Password') , ['class' => 'col-form-label required']) }}

              {{ Form::password('password', ['class' => 'form-control', 'placeholder' => __('Password'),'required'=>'']) }}
            </div>
          </div>

          <div class="col-md-6">
           <div class="form-group">
            {{ Form::label('password_confirmation', __('Confirm Password') , ['class' => 'col-form-label required']) }}

            {{ Form::password('password_confirmation',['class' => 'form-control', 'placeholder' => __('Confirm Password'),'required'=>'']) }}
          </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group w-100">
                {{ Form::label('photo', _lang('Agency Photo') , ['class' => 'col-form-label']) }}
                <input type="file" name="photo" id="input-file-now-custom-1" class="dropify" data-default-file="{{isset($model)?asset('storage/packege/'.$model->photo):''}}" />
            </div>
        </div>
    </div>
      @can('user.create')
      <div class="text-right">
        <button type="submit" class="btn btn-primary"  id="submit">{{__('Create User')}}<i class="icon-arrow-right14 position-right"></i></button>
        <button type="button" class="btn btn-link" id="submiting" style="display: none;">{{__('Processing')}} <img src="{{ asset('ajaxloader.gif') }}" width="80px"></button>

      </div>
      @endcan
      <fieldset class="mb-3" id="form_field">
        {!!Form::close()!!}
      </div>
    </div>
  </div>
</div>
<!-- Row -->
<!-- /basic initialization -->
@stop
@push('admin.scripts')
<script src="{{asset('js/user.js')}}"></script>

<!-- start - This is for export functionality only -->
@endpush