<div class="row">

    <div class="col-md-4">

        <form action="{{ url('jobs/search') }}" method="get" class="form-inline">
            <input type="text" name="searchTerm" placeholder="Search in all jobs" class="form-control" value="@if (isset($searchTerm) && $searchTerm != ''){{ $searchTerm }}@endif" required>
            <input type="submit" value="Search" class="btn btn-primary">
        </form>

    </div>

    <div class="col-md-3">
        <form action="{{ url('jobs/filter') }}" method="get" name="jobsFilter" class="form-inline">
            <select name="clientId" class="form-control">
                <option value="0">All jobs by client:</option>
                @foreach ($allClients as $client)
                    <option value="{{ $client->id }}" @if (isset($clientId) && $clientId == $client->id) selected="selected" @endif>
                        {{ $client->name }}
                    </option>
                @endforeach
            </select>
        </form>

    </div>

</div>
