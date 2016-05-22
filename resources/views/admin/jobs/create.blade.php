@extends('admin.layouts.layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="nav">
                Create Job
                <div class="pull-right">
                    <a href="{{ url('admin/jobs') }}" class="btn btn-default">
                    <i class="fa fa-chevron-circle-left"></i>&nbsp;&nbsp;Back</a>
                </div>
            </div>
        </div>
        <div class="panel-body">
			@include('common.errors')
	        <form action="{{ url('admin/jobs') }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
	            {{ csrf_field() }}
	            @include('admin.jobs.form', ['submitButtonText' => 'Add Job'])
	        </form>
        </div>
    </div>
@endsection