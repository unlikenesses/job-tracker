@extends('admin.layouts.layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="nav">
                Edit Invoice
                <div class="pull-right">
                    <a href="{{ url('invoices') }}" class="btn btn-default">
                    <i class="fa fa-chevron-circle-left"></i>&nbsp;&nbsp;Back</a>
                </div>
            </div>
        </div>
        <div class="panel-body">
			@include('common.errors')
	        <form action="{{ url('invoices/' . $row->id) }}" enctype="multipart/form-data" method="POST" class="form-horizontal">
	            {{ csrf_field() }}
				{{ method_field('PATCH') }}
				@include('admin.invoices.form', ['submitButtonText' => 'Update Invoice'])
	        </form>
        </div>
    </div>
@endsection