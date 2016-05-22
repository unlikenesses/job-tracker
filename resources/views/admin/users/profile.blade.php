@extends('admin.layouts.layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="nav">
                Edit Profile
            </div>
        </div>
        <div class="panel-body">
			@include('common.errors')
	        <form action="{{ url('admin/profile') }}" method="POST" class="form-horizontal" autocomplete="off">
	            {{ csrf_field() }}
				{{ method_field('PATCH') }}
				@include('admin.users.form', ['submitButtonText' => 'Update profile'])            
	        </form>
        </div>
    </div>
@endsection