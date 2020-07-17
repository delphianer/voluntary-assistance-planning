


<div class="form-group">
    <label for="fieldVehiclesid" class="col-sm-12 control-label">
    {% if selectedVehicle is defined %}
        Add property for:  <b>{{ selectedVehicle['label'] }}</b>
    {% else %}
        Vehicle:
    {% endif %}
    </label>
    <div class="col-sm-10">
    {{ form.render('vehiclesId') }}
    </div>
</div>

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
    <div class="col-sm-10">
        {{ form.render('is_numeric') }}
    </div>
</div>

<div class="form-group" id="toggleVisibleTxtField" class="invisible">
    <label for="fieldValueString" class="col-sm-2 control-label">Text value</label>
    <div class="col-sm-10">
        {{ form.render('value_string') }}
    </div>
</div>

<div class="form-group" id="toggleVisibleNumField" class="invisible">
    <label for="fieldValueNumeric" class="col-sm-2 control-label">Number value</label>
    <div class="col-sm-10">
        {{ form.render('value_numeric') }}
    </div>
</div>
