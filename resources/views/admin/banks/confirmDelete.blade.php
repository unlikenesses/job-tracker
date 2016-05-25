@extends('admin.layouts.layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            Delete Bank
        </div>
        <div class="panel-body">
            <p>
                {{ $row->name }}
            </p>
			<p><strong>Are you sure you want to delete this bank?</strong></p>
            <p>
                <form action="{{ url('banks/' . $row->id) }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button>Delete</button>
                </form>
            </p>
            <p>
                <a href="{{ url('banks' ) }}">Cancel</a>
            </p>
        </div>
    </div>
@endsection