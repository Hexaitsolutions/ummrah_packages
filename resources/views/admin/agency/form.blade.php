@php
$route = 'admin.package.';
@endphp
@extends('layouts.app', ['title' => _lang('agency'), 'modal' => 'lg'])
@push('admin.css')
<link href="{{asset('assets/node_modules/summernote/dist/summernote.css')}}" rel="stylesheet" />
@endpush
@section('pageheader')

<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">{{_lang('agency')}}</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">{{_lang('agency')}}</li>
            </ol>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
@stop
@section('content')
@if(isset($model))
{!! Form::model($model, ['route' => ['admin.agency.update', $model->id], 'class' => 'form-validate-jquery', 'id' => 'content_form1', 'method' => 'PUT', 'files' => true]) !!}
@else
{!! Form::open(['route' => 'admin.agency.store', 'class' => 'form-validate-jquery', 'id' => 'content_form1', 'files' => true, 'method' => 'POST']) !!}
@endif
<div class="row">
 <div class="col-lg-6">
    <div class="form-group">
        {{ Form::label('name', _lang('name') , ['class' => 'col-form-label required']) }}
        {{ Form::text('name', Null, ['class' => 'form-control', 'placeholder' =>  _lang('name'), 'required' => '']) }}
    </div>
</div>

 <div class="col-lg-6">
    <div class="form-group">
        {{ Form::label('phone', _lang('phone') , ['class' => 'col-form-label required']) }}
        {{ Form::text('phone', Null, ['class' => 'form-control', 'placeholder' =>  _lang('phone'), 'required' => '']) }}
    </div>
</div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            {{ Form::label('photo', _lang('photo') , ['class' => 'col-form-label']) }}
            <input type="file" name="photo" id="input-file-now-custom-1" class="dropify" data-default-file="{{isset($model)?asset($model->img):''}}" />
        </div>
        @if(isset($model) && isset($model->img))
        <input type="hidden" name="oldphoto" value="{{$model->img}}">
        @endif

    </div>

</div>

<div class="form-group row">
    <div class="col-lg-4 offset-lg-4">
      <button type="submit" class="btn btn-block btn-lg btn-info"  id="submit">{{isset($model)? _lang('Update'):_lang('Create')}}<i class="icon-arrow-right14 position-right"></i></button>
      <button type="button" class="btn btn-link" id="submiting" style="display: none;">{{__('Processing')}} <img src="{{ asset('ajaxloader.gif') }}" width="80px"></button>
  </div>
</div>


{!! Form::close() !!}
<!-- /basic initialization -->
@stop
@push('admin.scripts')

<script src="{{asset('js/package.js')}}"></script>

<!-- start - This is for export functionality only -->
@endpush
