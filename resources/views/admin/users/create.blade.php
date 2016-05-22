@extends('admin.layouts.layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="nav">
                Create User
                <div class="pull-right">
                    <a href="{{ url('admin/users') }}" class="btn btn-default"><i class="fa fa-chevron-circle-left"></i>&nbsp;&nbsp;Back</a>
                </div>
            </div>
        </div>
        <div class="panel-body">
			@include('common.errors')
	        <form action="{{ url('admin/users') }}" method="POST" class="form-horizontal">
	            {{ csrf_field() }}
                <input type="hidden" name="role" value="500">
	            @include('admin.users.form', ['submitButtonText' => 'Add User'])
	        </form>
        </div>
    </div>
@endsection