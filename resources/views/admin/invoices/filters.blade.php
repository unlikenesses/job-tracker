<div class="row">

    <div class="col-md-4">

        <form action="{{ url('invoices/search') }}" method="post" class="form-inline">
            {{ csrf_field() }}
            <input type="text" name="searchTerm" placeholder="Search for an invoice" class="form-control" value="{{ old('searchTerm') }}" required>
            <input type="submit" value="Search" class="btn btn-primary">
        </form>

    </div>

    <div class="col-md-3">

        <form action="{{ url('invoices/clientFilter') }}" method="post" class="form-inline">
            <select name="invoicesClientFilter" class="form-control">
                <option value="0">Filter by client:</option>
                @foreach ($allClients as $client)
                    <option value="{{ $client->id }}">
                        {{ $client->name }}
                    </option>
                @endforeach
            </select>
        </form>

    </div>

</div>
