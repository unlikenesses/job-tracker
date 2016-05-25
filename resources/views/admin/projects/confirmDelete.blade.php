@extends('admin.layouts.layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            Delete Project
        </div>
        <div class="panel-body">
            <p>
                {{ $row->name }}
            </p>
			<p><strong>Are you sure you want to delete this project?</strong></p>
            <p>
                <form action="{{ url('projects/' . $row->id) }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button>Delete</button>
                </form>
            </p>
            <p>
                <a href="{{ url('projects' ) }}">Cancel</a>
            </p>
        </div>
    </div>
@endsection