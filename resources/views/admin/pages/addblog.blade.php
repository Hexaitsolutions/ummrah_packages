@extends('layouts.app', ['title' => _lang('blog'), 'modal' => 'lg'])
@push('admin.css')
<link href="{{asset('assets/node_modules/summernote/dist/summernote.css')}}" rel="stylesheet" />
@endpush
@section('pageheader')

<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">{{_lang('add-blog')}}</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">{{_lang('add-blog')}}</li>
            </ol>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
@stop
@section('content')

<form action="{{ route('admin.pages.submit-blog') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <label for="Heading">Heading</label>
            <input class="form-control" type="text" required name="blog_heading" placeholder="Enter heading">
        </div>
        <div class="col-md-6">
            <label for="MetaTitle">Meta_Title</label>
            <input class="form-control" type="text" required name="meta_title" placeholder="Enter meta_title">
        </div>
        <div class="col-md-6 my-4">
            <label for="Metakeyword">Meta_keyword</label>
            <input class="form-control" type="text" required name="meta_keyword" placeholder="Enter meta_keyword">
        </div>
        <div class="col-md-6 my-4">
            <label for="MetaDescription">Meta_Description</label>
            <input class="form-control" type="text" required name="meta_description" placeholder="Enter meta_description">
        </div>
        <div class="col-md-12">
            <label for="Description">Description</label>
            {{-- <input class="form-control" type="text" required name="blog_description" placeholder="Enter description"> --}}
            <textarea class="form-control summernote" name="blog_description" placeholder="Enter description" rows="3"></textarea>
            {{-- {{ Form::label('description', _lang('description') , ['class' => 'col-form-label']) }}
            {{ Form::textarea('blog_description', Null, ['class' => 'form-control summernote', 'placeholder' =>  _lang('blog_description'), 'style' => 'resize: none;', 'rows' => '3']) }} --}}
        </div>
        <div class="col-md-12 my-4">
            <label for="photo">Photo</label>
            <input type="file" required name="blog_image" class="form-control dropify" />
        </div>
        <div class="ml-auto mt-4 mx-2">
            <button class="btn btn-block btn-lg btn-info" type="submit">Create</button>
        </div>
    </div>
</form>
@push('admin.scripts')
{{-- <script src="{{asset('js/pages.js')}}"></script> --}}
<script src="{{asset('js/package.js')}}"></script>
@endpush
<!-- /basic initialization -->
@stop
