@extends('admin.layouts.layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            Delete Invoice
        </div>
        <div class="panel-body">
            <p><strong>Client:</strong> {{ $client }}</p>
            <p><strong>Invoice:</strong> {{ $row->name }}</p>
            <p><strong>Date:</strong> {{ $row->invoiced }}</p>
			<p><strong>Are you sure you want to delete this invoice?</strong></p>
            <p>
                <form action="{{ url('invoices/' . $row->id) }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button>Delete</button>
                </form>
            </p>
            <p>
                <a href="{{ url('invoices' ) }}">Cancel</a>
            </p>
        </div>
    </div>
@endsection
