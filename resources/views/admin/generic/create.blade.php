@extends('admin.layouts.layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="nav">
                Create {{ $item }}
                <div class="pull-right">
                    @if (isset($page_id))
                        <a href="{{ url('admin/' . $table . '/' . $page_id) }}" class="btn btn-default">
                    @else
                        <a href="{{ url('admin/' . $table) }}" class="btn btn-default">
                    @endif
                    <i class="fa fa-chevron-circle-left"></i>&nbsp;&nbsp;Back</a>
                </div>
            </div>
        </div>
        <div class="panel-body">
			@include('common.errors')
	        <form action="{{ url('admin/' . $table) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
                @if (isset($page_id))
                    <input type="hidden" name="page_id" value="{{ $page_id }}">
                @endif
	            {{ csrf_field() }}
	            @include('admin.generic.form', ['submitButtonText' => 'Add ' . $item])
	        </form>
        </div>
    </div>
@endsection