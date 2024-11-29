@extends('layouts.app', ['title' => 'User', 'modal' => false])
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
        <h4 class="text-themecolor">User</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">{{_lang('user')}}</li>
            </ol>
            <a href="{{ route('admin.customer.create') }}" class="btn btn-info  d-lg-block m-l-15"><i class="ti-plus"></i> Create New</a>
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
        <h4 class="card-title">Customer List</h4>
        <div class="table-responsive m-t-40">
            <table class="table table-bordered table-striped content_managment_table" id="userTable">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>{{__('Name')}}</th>
                        <th>{{__('Phone')}}</th>
                        <th>{{__('Action')}}</th>
                    </tr>
                </thead>
                </tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>
                                {{ $user->id }}
                            </td>
                            <td>
                                {{ $user->name }}
                            </td>
                            <td>
                                {{ $user->phone }}
                            </td>
                            <td>
                                <a href="{{ route('admin.customer.edit', $user->id) }}" class="btn btn-primary btn-sm">
                                    <i class="ti-pencil-alt"></i> Edit
                                </a>
                                <form action="{{ route('admin.customer.delete', $user->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete?')">
                                        <i class="ti-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="float-right">
    {{$users->links()}}
</div>
<!-- /basic initialization -->
@stop
@push('admin.scripts')
<script src="{{asset('assets/node_modules/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js')}}"></script>

@endpush
