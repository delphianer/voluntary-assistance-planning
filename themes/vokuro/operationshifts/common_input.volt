
<div class="form-group">
    <label for="fieldOperationid" class="col-sm-12 control-label">
    {% if selectedOperation is defined %}
        Add shift for Operation:   <b>{{ selectedOperation['shortDescription'] }} </b>
    {% else %}
        Operation:
    {% endif %}
    </label>
    <div class="col-sm-10">
        {{ form.render('operationId') }}
    </div>
</div>

<div class="form-group">
    <label for="fieldLocationid" class="col-sm-2 control-label">Location:</label>
    <div class="col-sm-10">
        {{ form.render('locationId') }}
    </div>
</div>


<div class="form-group">
    <label for="fieldShortdescription" class="col-sm-2 control-label">short description</label>
    <div class="col-sm-10">
        {{ form.render('shortDescription') }}
    </div>
</div>

<div class="form-group">
    <label for="fieldLongdescription" class="col-sm-2 control-label">long description</label>
    <div class="col-sm-10">
        {{ form.render('longDescription') }}
    </div>
</div>

<div class="form-group">
    <label for="fieldStartid" class="col-sm-2 control-label">start</label>
    <div class="col-sm-10">
        {{ form.render('start') }}
    </div>
</div>

<div class="form-group">
    <label for="fieldEndid" class="col-sm-2 control-label">end</label>
    <div class="col-sm-10">
        {{ form.render('end') }}
    </div>
</div>
