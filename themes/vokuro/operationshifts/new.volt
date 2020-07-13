{% extends 'layouts/inheritance/masternew.volt' %}

{% block title %}Create Operation Shift{% endblock %}

{% block inputelements %}

<div class="form-group">
    <label for="fieldOperationid" class="col-sm-2 control-label">OperationId</label>
    <div class="col-sm-10">
        {{ text_field("operationId", "type" : "numeric", "class" : "form-control", "id" : "fieldOperationid") }}
    </div>
</div>

<div class="form-group">
    <label for="fieldLocationid" class="col-sm-2 control-label">LocationId</label>
    <div class="col-sm-10">
        {{ text_field("locationId", "type" : "numeric", "class" : "form-control", "id" : "fieldLocationid") }}
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



{% endblock %}
