
{% if operationShift is defined %}
<div class="row p-4 bg-light">
    <div class="col">
        <h3>
        Operation:   <b>{{ operationShift.Operations.shortDescription }} </b>
        </h3>
    </div>
</div>
<div class="row p-4 bg-light">
    <div class="col">
        <h4>
        Shift:   {{ operationShift.shortDescription }}
        </h4>
    </div>
</div>
<div class="row p-4 mb-4 bg-light">
    <div class="col-sm-1 text-right">
        start:
    </div>
    <div class="col-sm-4  text-center">
        <b>{{ operationShift.start }}</b>
    </div>
    <div class="col-sm-1 text-right">
        end:
    </div>
    <div class="col-sm-4 text-center">
        <b>{{ operationShift.end }}</b>
    </div>
</div>
{% endif %}

<div class="form-group">
    <label for="shortDescription" class="col-sm-2 control-label">short description</label>
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
    <label for="opDepNeedId" class="col-sm-2 control-label">Needs of Department</label>
    <div class="col-sm-10">
        {{ form.render('opDepNeedId') }}
        {{ form.render('opDepNeedIdDisabled') }}

    </div>
</div>

<div class="form-group">
    <label for="fieldEndid" class="col-sm-2 control-label">Volunteer</label>
    <div class="col-sm-10">
        {{ form.render('volunteersId') }}
        {{ form.render('volunteersIdDisabled') }}
    </div>
</div>


<div class="form-group">
    <label for="fieldEndid" class="col-sm-2 control-label">Role</label>
    <div class="col-sm-10">
        {{ form.render('volCurrentMaximumCertRank') }}
    </div>
</div>

