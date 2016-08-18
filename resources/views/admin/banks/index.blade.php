@extends('admin.layouts.layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            Banks
        </div>

        <div class="panel-body">
			<a href="{{ url('/banks/create') }}" class="btn btn-default">
	            <i class="fa fa-plus"></i> Add Bank
	        </a>

		 	@if (count($rows) > 0)

	            <table class="table table-striped task-table">

	                <!-- Table Headings -->
	                <thead>
	                    @foreach ($fields as $field)
	                    	<th>{{ ucfirst(str_replace('_', ' ', $field)) }}</th>
	                    @endforeach
	                    <th>&nbsp;</th>
	                </thead>

	                <!-- Table Body -->
	                <tbody>
	                    @foreach ($rows as $row)
	                        <tr>
	                        	@foreach ($fields as $field)
									<td class="table-text">
										<a href="{{ url('/banks/'.$row->id.'/edit') }}">
											{{ strip_tags($row->$field) }}
										</a>
									</td>
	                        	@endforeach
	                            <td>
	                            	<a href="{{ url('/banks/'.$row->id.'/edit') }}" class="btn btn-default">
							            <i class="fa fa-edit"></i> Edit
							        </a>
	                                <a href="{{ url('banks/' . $row->id . '/delete') }}" class="btn btn-default"><i class="fa fa-trash"></i> Delete</a>
	                            </td>
	                        </tr>
	                    @endforeach
	                </tbody>
	            </table>
	        @else
	        	None
	        @endif
        </div>
    </div>
@endsection
