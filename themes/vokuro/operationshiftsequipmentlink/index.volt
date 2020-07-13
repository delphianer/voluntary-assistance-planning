{% extends 'layouts/inheritance/masterindex.volt' %}

{% block title %}Search operationshifts_equipment_link{% endblock %}

{% block inputelements %}

<div class="form-group">
    <label for="fieldId" class="col-sm-2 control-label">Id</label>
    <div class="col-sm-10">
        {{ text_field("id", "type" : "numeric", "class" : "form-control", "id" : "fieldId") }}
    </div>
</div>

<div class="form-group">
    <label for="fieldOperationshiftid" class="col-sm-2 control-label">OperationShiftId</label>
    <div class="col-sm-10">
        {{ text_field("operationShiftId", "type" : "numeric", "class" : "form-control", "id" : "fieldOperationshiftid") }}
    </div>
</div>

<div class="form-group">
    <label for="fieldEquipmentid" class="col-sm-2 control-label">EquipmentId</label>
    <div class="col-sm-10">
        {{ text_field("equipmentId", "type" : "numeric", "class" : "form-control", "id" : "fieldEquipmentid") }}
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



{% endblock %}
