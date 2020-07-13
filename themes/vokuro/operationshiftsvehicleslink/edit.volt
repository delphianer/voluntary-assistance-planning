{% extends 'layouts/inheritance/masteredit.volt' %}

{% block title %}Edit Operation Shift-&gt;Vehicle{% endblock %}

{% block inputelements %}

<div class="form-group">
    <label for="fieldOperationshiftid" class="col-sm-2 control-label">OperationShiftId</label>
    <div class="col-sm-10">
        {{ text_field("operationShiftId", "type" : "numeric", "class" : "form-control", "id" : "fieldOperationshiftid") }}
    </div>
</div>

<div class="form-group">
    <label for="fieldVehicleid" class="col-sm-2 control-label">VehicleId</label>
    <div class="col-sm-10">
        {{ text_field("vehicleId", "type" : "numeric", "class" : "form-control", "id" : "fieldVehicleid") }}
    </div>
</div>

<div class="form-group">
    <label for="fieldShortdescription" class="col-sm-2 control-label">ShortDescription</label>
    <div class="col-sm-10">
        {{ text_field("shortDescription", "size" : 30, "class" : "form-control", "id" : "fieldShortdescription") }}
    </div>
</div>

<div class="form-group">
    <label for="fieldLongdescription" class="col-sm-2 control-label">LongDescription</label>
    <div class="col-sm-10">
        {{ text_field("longDescription", "size" : 30, "class" : "form-control", "id" : "fieldLongdescription") }}
    </div>
</div>



{{ hidden_field("id") }}

{% endblock %}
