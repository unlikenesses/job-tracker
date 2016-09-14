<div class="row">

    <div class="col-md-4">

        <form action="{{ url('invoices/search') }}" method="get" class="form-inline">
            <input type="text" name="searchTerm" placeholder="Search for an invoice" class="form-control" value="{{ old('searchTerm') }}" required>
            <input type="submit" value="Search" class="btn btn-primary">
        </form>

    </div>

    <div class="col-md-3">

        <form action="{{ url('invoices/filter') }}" method="get" name="jobsFilter" class="form-inline">
            <select name="clientId" class="form-control">
                <option value="0">All invoices by client:</option>
                @foreach ($allClients as $client)
                    <option value="{{ $client->id }}" @if (isset($clientId) && $clientId == $client->id) selected="selected" @endif>
                        {{ $client->name }}
                    </option>
                @endforeach
            </select>
        </form>

    </div>

</div>
