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
        <h4 class="text-themecolor">{{_lang('edit-blog')}}</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">{{_lang('edit-blog')}}</li>
            </ol>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
@stop
@section('content')

<form action="{{ route('admin.pages.submit-edit-blog') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <input type="hidden" name="blog_id" value="{{$blog->id}}">
        <div class="col-md-6">
            <label for="Heading">Heading</label>
            <input class="form-control" type="text" value="{{$blog->heading}}" name="blog_heading" placeholder="Enter heading">
        </div>
        <div class="col-md-6">
            <label for="MetaTitle">Meta_Title</label>
            <input class="form-control" type="text" value="{{$blog->meta_title}}" name="meta_title" placeholder="Enter meta_title">
        </div>
        <div class="col-md-6 my-4">
            <label for="Metakeyword">Meta_keyword</label>
            <input class="form-control" type="text" value="{{$blog->meta_keyword}}" name="meta_keyword" placeholder="Enter meta_keyword">
        </div>
        <div class="col-md-6 my-4">
            <label for="MetaDescription">Meta_Description</label>
            <input class="form-control" value="{{$blog->meta_description}}" type="text" name="meta_description">
        </div>
        <div class="col-md-12">
            <label for="Description">Description</label>
            <textarea class="form-control summernote" type="text" name="blog_description" row="3">{!! $blog->description !!}</textarea>
        </div>
        <div class="col-md-12">
            {{ Form::label('blog_image', _lang('blog_image') , ['class' => 'col-form-label']) }}
            <input type="file" name="blog_image" id="input-file-now-custom-1" class="dropify" data-default-file="{{$blog?asset('storage/pages/'.$blog->photo):''}}" />
            @if($blog && isset($blog->photo))
            <input type="hidden" name="old_blog_image" value="{{$blog->photo}}">
            @endif
        </div>
        <div class="ml-auto mt-4 mx-2">
            <button class="btn btn-block btn-lg btn-info" type="submit">Create</button>
        </div>
    </div>
</form>
@push('admin.scripts')
<script src="{{asset('js/pages.js')}}"></script>
@endpush
<!-- /basic initialization -->
@stop
