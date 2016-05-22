<div class="form-group">
    <label for="name" class="col-sm-3 control-label">Name</label>

    <div class="col-sm-6">
        <input type="text" name="name" class="form-control" value="{{ $user->name or '' }}">
    </div>
</div>
<div class="form-group">
    <label for="email" class="col-sm-3 control-label">Email</label>

    <div class="col-sm-6">
        <input type="text" name="email" class="form-control" value="{{ $user->email or '' }}">
    </div>
</div>
<div class="form-group">
    <label for="password" class="col-sm-3 control-label">Password</label>

    <div class="col-sm-6">
        <input type="password" name="password" class="form-control" value="" autocomplete="false">
    </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-3 col-sm-6">
        <p class="alert alert-info">Leave password field blank to only update other fields.</p>
    </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-3 col-sm-6">
        <button type="submit" class="btn btn-default">
            <i class="fa fa-plus"></i> {{ $submitButtonText }}
        </button>
    </div>
</div>