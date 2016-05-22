@extends('admin.layouts.layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="nav">
                Create Invoice
                <div class="pull-right">
                    <a href="{{ url('admin/invoices') }}" class="btn btn-default">
                    <i class="fa fa-chevron-circle-left"></i>&nbsp;&nbsp;Back</a>
                </div>
            </div>
        </div>
        <div class="panel-body">
			@include('common.errors')
	        <form action="{{ url('admin/invoices') }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
	            {{ csrf_field() }}
	            @include('admin.invoices.form', ['submitButtonText' => 'Add Invoice'])
	        </form>
        </div>
    </div>
@endsection