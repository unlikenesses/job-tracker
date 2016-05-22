@extends('admin.layouts.layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            {{ ucfirst($table) }}
        </div>

        <div class="panel-body">
			@if (isset($page_id))
        		<a href="{{ url('/admin/' . $table . '/create/' . $page_id) }}" class="btn btn-default">
        	@else 
        		<a href="{{ url('/admin/' . $table . '/create') }}" class="btn btn-default">
        	@endif
	            <i class="fa fa-plus"></i> Add {{ $item }}
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
										<div>
											<a href="{{ url('/admin/' . $table . '/'.$row->id.'/edit') }}">
												@if ($field == 'image')
													<img src="{{ url('uploads/' . $row->image) }}" style="width: 100px; height:auto">
												@else
													{{ $row->$field }}
												@endif
											</a>
										</div>
									</td>
	                        	@endforeach
	                            <td>
	                            	<a href="{{ url('/admin/' . $table . '/'.$row->id.'/edit') }}" class="btn btn-default">
							            <i class="fa fa-plus"></i> Edit
							        </a>
	                            </td>
	                            <td>
	                                <a href="{{ url('admin/' . $table . '/' . $row->id . '/delete') }}" class="btn btn-default"><i class="fa fa-trash"></i> Delete</a>
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