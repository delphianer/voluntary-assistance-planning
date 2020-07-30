
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
    <label for="technicalInspection" class="col-sm-4 control-label">next technical inspection date</label>
    <div class="col-sm-10">
        {{ form.render('technicalInspection') }}
    </div>
</div>

<div class="form-group">
    <label for="seatCount" class="col-sm-4 control-label">Seat Count</label>
    <div class="col-sm-10">
        {{ form.render('seatCount') }}
    </div>
</div>

<div class="form-group">
    <label for="isAmbulance" class="col-sm-4 control-label">Is an Ambulance</label>
    <div class="col-sm-10">
        {{ form.render('isAmbulance') }}
    </div>
</div>

<div class="form-group">
    <label for="hasFlashingLights" class="col-sm-4 control-label">Has Flashing Lights</label>
    <div class="col-sm-10">
        {{ form.render('hasFlashingLights') }}
    </div>
</div>

<div class="form-group">
    <label for="hasRadioCom" class="col-sm-4 control-label">has radio communication</label>
    <div class="col-sm-10">
        {{ form.render('hasRadioCom') }}
    </div>
</div>

<div class="form-group">
    <label for="hasDigitalRadioCom" class="col-sm-4 control-label">has digital radio com</label>
    <div class="col-sm-10">
        {{ form.render('hasDigitalRadioCom') }}
    </div>
</div>
