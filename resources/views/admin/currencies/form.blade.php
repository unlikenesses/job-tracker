@foreach ($fields as $field)
    <div class="form-group">
        <label for="{{ $field }}" class="col-sm-3 control-label">
            {{ ucfirst(str_replace('_', ' ', $field)) }}
        </label>

        <div class="col-sm-6">
            <input type="text" name="{{ $field }}" class="form-control" value="{{ $row->$field or old($field) }}">
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
