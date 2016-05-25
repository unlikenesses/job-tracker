@extends('admin.layouts.layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="nav">
                Create Project
                <div class="pull-right">
                    <a href="{{ url('projects') }}" class="btn btn-default">
                    <i class="fa fa-chevron-circle-left"></i>&nbsp;&nbsp;Back</a>
                </div>
            </div>
        </div>
        <div class="panel-body">
			@include('common.errors')
	        <form action="{{ url('projects') }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
	            {{ csrf_field() }}
	            @include('admin.projects.form', ['submitButtonText' => 'Add Project'])
	        </form>
        </div>
    </div>
@endsection