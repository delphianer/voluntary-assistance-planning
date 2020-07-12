{% extends 'layouts/inheritance/masteredit.volt' %}

{% block title %}Edit appointment{% endblock %}

{% block inputelements %}

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
    <label for="fieldStart" class="col-sm-2 control-label">Start</label>
    <div class="col-sm-10">
        {{ text_field("start", "size" : 30, "class" : "form-control", "id" : "fieldStart") }}
    </div>
</div>

<div class="form-group">
    <label for="fieldEnd" class="col-sm-2 control-label">End</label>
    <div class="col-sm-10">
        {{ text_field("end", "size" : 30, "class" : "form-control", "id" : "fieldEnd") }}
    </div>
</div>

<div class="form-group">
    <label for="fieldLocationid" class="col-sm-2 control-label">LocationId</label>
    <div class="col-sm-10">
        {{ text_field("locationId", "type" : "numeric", "class" : "form-control", "id" : "fieldLocationid") }}
    </div>
</div>

<div class="form-group">
    <label for="fieldMaindepartmentid" class="col-sm-2 control-label">MainDepartmentId</label>
    <div class="col-sm-10">
        {{ text_field("mainDepartmentId", "type" : "numeric", "class" : "form-control", "id" : "fieldMaindepartmentid") }}
    </div>
</div>

<div class="form-group">
    <label for="fieldClientid" class="col-sm-2 control-label">ClientId</label>
    <div class="col-sm-10">
        {{ text_field("clientId", "type" : "numeric", "class" : "form-control", "id" : "fieldClientid") }}
    </div>
</div>



    {{ hidden_field("id") }}

{% endblock %}
