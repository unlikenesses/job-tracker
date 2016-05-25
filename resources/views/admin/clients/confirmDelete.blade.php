@extends('admin.layouts.layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            Delete Client
        </div>
        <div class="panel-body">
            <p>
                {{ $row->name }}
            </p>
			<p><strong>Are you sure you want to delete this client?</strong></p>
            <p>
                <form action="{{ url('clients/' . $row->id) }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button>Delete</button>
                </form>
            </p>
            <p>
                <a href="{{ url('clients' ) }}">Cancel</a>
            </p>
        </div>
    </div>
@endsection