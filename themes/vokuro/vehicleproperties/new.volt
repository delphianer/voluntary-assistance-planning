{% extends 'layouts/inheritance/masternew.volt' %}

{% block title %}Create Vehicle Property{% endblock %}

{% block inputelements %}

<div class="form-group">
    <label for="fieldVehiclesid" class="col-sm-2 control-label">VehiclesId</label>
    <div class="col-sm-10">
        {{ text_field("vehiclesId", "type" : "numeric", "class" : "form-control", "id" : "fieldVehiclesid") }}
    </div>
</div>

<div class="form-group">
    <label for="fieldLabel" class="col-sm-2 control-label">Label</label>
    <div class="col-sm-10">
        {{ text_field("label", "size" : 30, "class" : "form-control", "id" : "fieldLabel") }}
    </div>
</div>

<div class="form-group">
    <label for="fieldDescription" class="col-sm-2 control-label">Description</label>
    <div class="col-sm-10">
        {{ text_field("description", "size" : 30, "class" : "form-control", "id" : "fieldDescription") }}
    </div>
</div>

<div class="form-group">
    <label for="fieldIsNumeric" class="col-sm-2 control-label">Is Of Numeric</label>
    <div class="col-sm-10">
        {{ text_field("is_numeric", "size" : 30, "class" : "form-control", "id" : "fieldIsNumeric") }}
    </div>
</div>

<div class="form-group">
    <label for="fieldValueString" class="col-sm-2 control-label">Value Of String</label>
    <div class="col-sm-10">
        {{ text_field("value_string", "size" : 30, "class" : "form-control", "id" : "fieldValueString") }}
    </div>
</div>

<div class="form-group">
    <label for="fieldValueNumeric" class="col-sm-2 control-label">Value Of Numeric</label>
    <div class="col-sm-10">
        {{ text_field("value_numeric", "type" : "numeric", "class" : "form-control", "id" : "fieldValueNumeric") }}
    </div>
</div>



{% endblock %}
