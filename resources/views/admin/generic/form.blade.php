@if (isset($row->image))
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-6">
            <img src="{{ url('uploads/' . $row->image) }}" style="width: 100px; height:auto">
        </div>
    </div>
@endif
@foreach ($fields as $field)
    <div class="form-group">
        <label for="{{ $field }}" class="col-sm-3 control-label">
            {{ ucfirst(str_replace('_', ' ', $field)) }}
        </label>

        <div class="col-sm-6">
            @if ($field == 'image' || $field == 'file')
                <input type="file" name="{{ $field }}" class="form-control">
                @if (isset($row->$field))
                    <p>Currently: {{$row->$field}}</p>
                @endif
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