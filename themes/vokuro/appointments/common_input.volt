

<div class="form-group">
    <div class="col-sm-10">
        {{ form.render('label') }}
    </div>
</div>

<div class="form-group">
    <div class="col-sm-10">
        {{ form.render('description') }}
    </div>
</div>

<div class="form-group">
    <label for="start" class="col-sm-2 control-label">Start:</label>
    <div class="col-sm-10">
        {{ form.render('start') }}
    </div>
</div>

<div class="form-group">
    <label for="end" class="col-sm-2 control-label">End:</label>
    <div class="col-sm-10">
        {{ form.render('end') }}
    </div>
</div>

<div class="form-group">
    <label for="mainDepartmentId" class="col-sm-4 control-label">Main Department:</label>
    <div class="col-sm-10">
        {{ form.render('mainDepartmentId') }}
    </div>
</div>


<div class="form-group">
    <label for="end" class="col-sm-2 control-label">Location:</label>
    <div class="col-sm-10">
        {{ form.render('locationId') }}
    </div>
</div>

<div class="form-group">
    <label for="clientId" class="col-sm-2 control-label">Client:</label>
    <div class="col-sm-10">
        {{ form.render('clientId') }}
    </div>
</div>
