@extends('admin.layouts.layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="nav">
                Create Client
                <div class="pull-right">
                    <a href="{{ url('clients') }}" class="btn btn-default">
                    <i class="fa fa-chevron-circle-left"></i>&nbsp;&nbsp;Back</a>
                </div>
            </div>
        </div>
        <div class="panel-body">
			@include('common.errors')
	        <form action="{{ url('clients') }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
	            {{ csrf_field() }}
	            @include('admin.clients.form', ['submitButtonText' => 'Add Client'])
	        </form>
        </div>
    </div>
@endsection