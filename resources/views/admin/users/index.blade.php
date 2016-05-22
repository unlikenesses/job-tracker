@extends('admin.layouts.layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            Users
        </div>

        <div class="panel-body">

        	<a href="{{ url('/admin/users/create/') }}" class="btn btn-default">
	            <i class="fa fa-plus"></i> Add User
	        </a>

		 	@if (count($users) > 0)

	            <table class="table table-striped task-table">

	                <!-- Table Headings -->
	                <thead>
	                    <th>Name</th>
	                    <th>Email</th>
	                    <th>&nbsp;</th>
	                </thead>

	                <!-- Table Body -->
	                <tbody>
	                    @foreach ($users as $user)
	                        <tr>
								<td class="table-text">
	                                <div>{{ $user->name }}</div>
	                            </td>
								<td class="table-text">
	                                <div>{{ $user->email }}</div>
	                            </td>
	                            <td>
	                            	<a href="{{ url('/admin/users/'.$user->id.'/edit') }}" class="btn btn-default">
							            <i class="fa fa-plus"></i> Edit
							        </a>
	                            </td>
	                            <td>
							        <a href="{{ url('admin/users/' . $user->id . '/delete') }}" class="btn btn-default"><i class="fa fa-trash"></i> Delete</a>
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