{% extends 'layouts/inheritance/masteredit.volt' %}

{% block title %}Edit Operation Shift-&gt;Department{% endblock %}

{% block inputelements %}

<div class="form-group">
    <label for="fieldOperationshiftid" class="col-sm-2 control-label">OperationShiftId</label>
    <div class="col-sm-10">
        {{ text_field("operationShiftId", "type" : "numeric", "class" : "form-control", "id" : "fieldOperationshiftid") }}
    </div>
</div>

<div class="form-group">
    <label for="fieldDepartmentid" class="col-sm-2 control-label">DepartmentId</label>
    <div class="col-sm-10">
        {{ text_field("departmentId", "type" : "numeric", "class" : "form-control", "id" : "fieldDepartmentid") }}
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
    <label for="fieldNumbervolunteersneeded" class="col-sm-2 control-label">NumberVolunteersNeeded</label>
    <div class="col-sm-10">
        {{ text_field("numberVolunteersNeeded", "type" : "numeric", "class" : "form-control", "id" : "fieldNumbervolunteersneeded") }}
    </div>
</div>

<div class="form-group">
    <label for="fieldMinimumcertificateranking" class="col-sm-2 control-label">MinimumCertificateRanking</label>
    <div class="col-sm-10">
        {{ text_field("minimumCertificateRanking", "type" : "numeric", "class" : "form-control", "id" : "fieldMinimumcertificateranking") }}
    </div>
</div>



{{ hidden_field("id") }}

{% endblock %}
