@extends('admin.layouts.layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="nav">
                Edit {{ $item }}
                <div class="pull-right">
                    @if (isset($page_id))
                        <a href="{{ url('admin/' . $table . '/' . $row->page_id) }}" class="btn btn-default">
                    @else
                        <a href="{{ url('admin/' . $table) }}" class="btn btn-default">
                    @endif
                    <i class="fa fa-chevron-circle-left"></i>&nbsp;&nbsp;Back</a>
                </div>
            </div>
        </div>
        <div class="panel-body">
			@include('common.errors')
	        <form action="{{ url('admin/' . $table . '/' . $row->id) }}" enctype="multipart/form-data" method="POST" class="form-horizontal">
	            {{ csrf_field() }}
				{{ method_field('PATCH') }}
				@include('admin.generic.form', ['submitButtonText' => 'Update ' . $item])            
	        </form>
        </div>
    </div>
@endsection