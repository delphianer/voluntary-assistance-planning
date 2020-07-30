
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
    <label for="fieldTotalCount" class="col-sm-5 control-label">Number available on stock</label>
    <div class="col-sm-10">
        {{ text_field("total_count", "type" : "numeric", "class" : "form-control", "id" : "fieldTotalCount") }}
    </div>
</div>

<div class="form-group">
    <label for="fieldIsRequsable" class="col-sm-2 control-label">IsReusable</label>
    <div class="col-sm-10">
        {% if dispatcher.getActionName() == 'index' %}
            {{ selectStatic(["isReusable", "class" : "form-control", "id" : "fieldIsRequsable"], ['':'Any','N':'No','Y':'Yes'] ) }}
        {% else %}
            {{ selectStatic(["isReusable", "class" : "form-control", "id" : "fieldIsRequsable"], ['N':'No','Y':'Yes'] ) }}
        {% endif %}
    </div>
</div>

