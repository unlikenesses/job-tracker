@foreach ($fields as $field)

    <div class="form-group">
        <label for="{{ $field }}" class="col-sm-3 control-label">
            @if (array_key_exists($field, $nomenclature))
                {{ $nomenclature[$field] }}
            @else
                {{ ucfirst(str_replace('_', ' ', $field)) }}
            @endif
        </label>

        <div class="col-sm-6">

            @if ($field == 'client_id')

                <select name="{{ $field }}" class="form-control">
                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}" @if (isset($row->$field) && $row->$field == $client->id) {{ 'selected="selected"' }} @endif>
                            {{ $client->name }}
                        </option>
                    @endforeach
                </select>

            @else

                <input type="text" name="{{ $field }}" class="form-control" value="{{ $row->$field or '' }}">

            @endif

        </div>
    </div>
@endforeach
<div class="form-group">
    <div class="col-sm-offset-3 col-sm-6">
        <button type="submit" class="btn btn-default">
            <i class="fa fa-plus"></i> {{ $submitButtonText }}
        </button>
    </div>
</div>
