@extends('admin.layouts.layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            Delete Job
        </div>
        <div class="panel-body">
            <p><strong>Client:</strong> {{ $client }}</p>
            <p><strong>Project:</strong> {{ $project }}</p>
            <p><strong>Job:</strong> {{ $row->name }}</p>
			<p><strong>Are you sure you want to delete this job?</strong></p>
            <p>
                <form action="{{ url('jobs/' . $row->id) }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button>Delete</button>
                </form>
            </p>
            <p>
                <a href="{{ url('jobs' ) }}">Cancel</a>
            </p>
        </div>
    </div>
@endsection
