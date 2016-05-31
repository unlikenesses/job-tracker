@foreach ($fields as $field)
    <div class="form-group">

        <label for="{{ $field }}" class="col-sm-3 control-label">
            {{ ucfirst(str_replace('_', ' ', $field)) }}
        </label>

        <div class="col-sm-6">

            @if ($field == 'client_id')

                <select name="{{ $field }}" class="form-control">
                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}" @if (isset($row->$field) && $row->$field == $client->id) {!! 'selected="selected"' !!} @endif>
                            {{ $client->name }}
                        </option>
                    @endforeach
                </select>

            @elseif ($field == 'project_id')

                <select name="{{ $field }}" class="form-control">
                    @foreach ($projects as $project)
                        <option value="{{ $project->id }}" @if (isset($row->$field) && $row->$field == $project->id) {!! 'selected="selected"' !!} @endif>
                            {{ $project->name }}
                        </option>
                    @endforeach
                </select>

            @elseif ($field == 'currency_id')

                <select name="{{ $field }}" class="form-control">
                    @foreach ($currencies as $currency)
                        <option value="{{ $currency->id }}" @if (isset($row->$field) && $row->$field == $currency->id) {!! 'selected="selected"' !!} @endif>
                            {{ $currency->name }}
                        </option>
                    @endforeach
                </select>

            @else

                <input type="text" name="{{ $field }}" class="form-control @if ($field == 'started' || $field == 'completed') {{ 'datepicker' }} @endif" value="{{ $row->$field or old($field) }}">

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
