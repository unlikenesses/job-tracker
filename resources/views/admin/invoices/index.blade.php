@extends('admin.layouts.layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            @if (isset($title)) {{ $title }} @endif Invoices ({{ $values }})
        </div>

        <div class="panel-body">

			@include('admin.invoices.filters')

			<a href="{{ url('/invoices/create') }}" class="btn btn-default">
	            <i class="fa fa-plus"></i> Add Invoice
	        </a>

		 	@if (count($rows) > 0)

	            <table class="table table-striped task-table">

	                <!-- Table Headings -->
	                <thead>
	                    @foreach ($fields as $field)
	                    	<th>
	                    		@if (array_key_exists($field, $nomenclature))
	                    			{{ $nomenclature[$field] }}
	                    		@else
	                    			{{ ucfirst(str_replace('_', ' ', $field)) }}
	                    		@endif
	                    	</th>
	                    @endforeach
	                    <th>&nbsp;</th>
	                </thead>

	                <!-- Table Body -->
	                <tbody>
	                    @foreach ($rows as $row)
	                        <tr>
	                        	@foreach ($fields as $field)
									<td class="table-text">
										<a href="{{ url('/invoices/' . $row->id . '/edit') }}">
											@if ($field == 'amount')
												{{ $currencySymbols[$row->currency_id] }}
											@endif
											@if ($field == 'client_id')
												{{ $clients[$row->$field] }}
											@elseif ($field == 'project_id')
												{{ $projects[$row->$field] }}
											@else
												{{ $row->$field }}
											@endif
										</a>
									</td>
	                        	@endforeach
	                            <td>
	                            	<a href="{{ url('/invoices/'.$row->id.'/edit') }}" class="btn btn-default">
							            <i class="fa fa-plus"></i> Edit
							        </a>
	                                <a href="{{ url('invoices/' . $row->id . '/delete') }}" class="btn btn-default">
	                                	<i class="fa fa-trash"></i> Delete
	                                </a>
	                                <a href="{{ url('invoices/' . $row->id . '/export') }}" class="btn btn-default">
	                                	<i class="fa fa-file-pdf-o"></i> Export to PDF
	                                </a>
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
