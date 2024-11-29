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

          {!! Form::open(['route' => 'admin.customer.update', 'id'=>'content_form','files' => true, 'method' => 'POST']) !!}
          @method('PUT');
          <input type="hidden" name="id" value="{{$user->id}}">
          <fieldset class="mb-3" id="form_field">
           <div class="row">
            <div class="col-md-5">
              <div class="form-group">
                {{ Form::label('user_name', _lang('user_name') , ['class' => 'col-form-label ']) }}

                {{ Form::text('user_name', $user->name, ['class' => 'form-control', 'placeholder' => _lang('user_name'),'required'=>'']) }}
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                {{ Form::label('email', _lang('email') , ['class' => 'col-form-label ']) }}

                {{ Form::text('email', $user->email, ['class' => 'form-control', 'placeholder' => _lang('email'),'disabled' => 'disabled']) }}
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group">
                {{ Form::label('status', _lang('status') , ['class' => 'col-form-label ']) }}
                {!! Form::select('status', $statuses, $user->status ?? 'inactive', ['class' => 'form-control select', 'style' => 'width: 100%;', 'data-placeholder' => _lang('status')]); !!}
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group">
                {{ Form::label('phone', _lang('phone') , ['class' => 'col-form-label ']) }}

                {{ Form::text('phone', $user->phone, ['class' => 'form-control', 'placeholder' => _lang('Phone'),'required'=>'']) }}
              </div>
            </div>
          </div>
          @can('user.update')
          <div class="text-right">
            <button type="submit" class="btn btn-primary"  id="submit">{{_lang('update')}}<i class="icon-arrow-right14 position-right"></i></button>
            <button type="button" class="btn btn-link" id="submiting" style="display: none;">{{_lang('Processing')}} <img src="{{ asset('ajaxloader.gif') }}" width="80px"></button>

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