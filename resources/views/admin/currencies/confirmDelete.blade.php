@extends('admin.layouts.layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            Delete Currency
        </div>
        <div class="panel-body">
            <p>
                {{ $row->name }}
            </p>
			<p><strong>Are you sure you want to delete this currency?</strong></p>
            <p>
                <form action="{{ url('currencies/' . $row->id) }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button>Delete</button>
                </form>
            </p>
            <p>
                <a href="{{ url('currencies' ) }}">Cancel</a>
            </p>
        </div>
    </div>
@endsection