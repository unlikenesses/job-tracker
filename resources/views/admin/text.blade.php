@extends('admin.layouts.layout')

@section('content')
	<div class="panel panel-default">
        <div class="panel-heading">
            Edit {{ $text->name }}
        </div>

        <div class="panel-body">
			<form action="{{ url('text/' . $text->id) }}" method="POST">
		        {{ csrf_field() }}
				{{ method_field('PATCH') }}
				<div class="form-group">
				    <label for="uri" class="control-label">Body</label>
				    <textarea name="body" class="form-control" id="editArticle">{!! $text->body or '' !!}</textarea>
				</div>

				<div class="form-group">
			        <button type="submit" class="btn btn-default">
			            <i class="fa fa-plus"></i> Update Text
			        </button>
				</div>           
		    </form>
		</div>
	</div>
@endsection