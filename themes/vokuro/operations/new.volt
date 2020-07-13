{% extends 'layouts/inheritance/masternew.volt' %}

{% block title %}Create operation{% endblock %}

{% block inputelements %}


<div class="form-group">
    <label for="fieldUpdateUserid" class="col-sm-2 control-label">Update Of UserId</label>
    <div class="col-sm-10">
        {{ text_field("update_userId", "type" : "numeric", "class" : "form-control", "id" : "fieldUpdateUserid") }}
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
    <label for="fieldMaindepartmentid" class="col-sm-2 control-label">MainDepartmentId</label>
    <div class="col-sm-10">
        {{ text_field("mainDepartmentId", "type" : "numeric", "class" : "form-control", "id" : "fieldMaindepartmentid") }}
    </div>
</div>



{% endblock %}
