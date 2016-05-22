<div class="form-group">
    <label for="jobs" class="col-sm-3 control-label">
        Jobs
    </label>
    <div class="col-sm-6">
    @if (isset($invoice_jobs))
        @foreach ($invoice_jobs as $job)
            <input type="checkbox" name="jobs[]" id="amount{{ $job->amount }}" value="{{ $job->id }}" class="jobs_checkboxes" checked> {{ $projects[$job->project_id] . ': ' . $job->name . '(' . $currency_symbols[$job->currency_id] . $job->amount . ')' }} <br>
        @endforeach
    @endif
    @foreach ($jobs as $job)
        <input type="checkbox" name="jobs[]" id="amount{{ $job->amount }}" value="{{ $job->id }}" class="jobs_checkboxes"> {{ $projects[$job->project_id] . ': ' . $job->name . '(' . $currency_symbols[$job->currency_id] . $job->amount . ')' }} <br>
    @endforeach
    </div>
</div>
@foreach ($fields as $field)
    <div class="form-group">

        <label for="{{ $field }}" class="col-sm-3 control-label">
            {{ ucfirst(str_replace('_', ' ', $field)) }}
        </label>

        <div class="col-sm-6">

            @if ($field == 'currency_id')

                <select name="{{ $field }}" class="form-control">
                    @foreach ($currencies as $currency)
                        <option value="{{ $currency->id }}" @if (isset($row->$field) && $row->$field == $currency->id) {!! 'selected="selected"' !!} @endif>
                            {{ $currency->name }}
                        </option>
                    @endforeach
                </select>

            @elseif ($field == 'invoiced')
    
                <input type="text" name="{{ $field }}" class="form-control datepicker" value="<?php if (isset($row) && $row->$field != NULL) { echo date('d-m-Y', strtotime($row->$field)); } elseif (isset($invoiced)) { echo $invoiced; } ?>">

            @elseif ($field == 'due')

                <input type="text" name="{{ $field }}" class="form-control datepicker" value="<?php if (isset($row) && $row->$field != NULL) { echo date('d-m-Y', strtotime($row->$field)); } elseif (isset($due)) { echo $due; } ?>">

            @elseif ($field == 'paid')

                <input type="text" name="{{ $field }}" class="form-control datepicker" value="<?php if (isset($row) && $row->$field != NULL) { echo date('d-m-Y', strtotime($row->$field)); } ?>">

            @elseif ($field == 'name')
                <input type="text" name="{{ $field }}" class="form-control" value="<?php if (isset($new_invoice_number)) { echo $new_invoice_number; } elseif (isset($row)) { echo $row->$field; } ?>">
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