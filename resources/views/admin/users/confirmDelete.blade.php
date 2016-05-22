@extends('admin.layouts.layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            Delete Contact
        </div>
        <div class="panel-body">
            <p>{{ $contact->location }}</p>
			<p><strong>Are you sure you want to delete this contact?</strong></p>
            <p>
                <form action="{{ url('admin/contacts/' . $contact->id) }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button>Delete</button>
                </form>
            </p>
            <p><a href="{{ url('admin/contacts') }}">Cancel</a></p>
        </div>
    </div>
@endsection