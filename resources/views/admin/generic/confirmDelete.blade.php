@extends('admin.layouts.layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            Delete {{ ucfirst($item) }}
        </div>
        <div class="panel-body">
            <p>
                @if ($displayField == 'image')
                    <img src="{{ url('uploads/' . $row->image) }}" style="width: 100px; height:auto">
                @else
                    {{ $row->$displayField }}
                @endif
            </p>
			<p><strong>Are you sure you want to delete this {{ $item }}?</strong></p>
            <p>
                <form action="{{ url('admin/' . $table . '/' . $row->id) }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button>Delete</button>
                </form>
            </p>
            <p>
                @if (isset($page_id))
                    <a href="{{ url('admin/' . $table . '/' . $page_id ) }}">Cancel</a>
                @else
                    <a href="{{ url('admin/' . $table ) }}">Cancel</a>
                @endif
            </p>
        </div>
    </div>
@endsection