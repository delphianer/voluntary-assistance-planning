{% extends 'layouts/inheritance/masterindex.volt' %}

{% block title %}Search equipment{% endblock %}

{% block inputelements %}

<div class="form-group">
    <label for="fieldId" class="col-sm-2 control-label">Id</label>
    <div class="col-sm-10">
        {{ text_field("id", "type" : "numeric", "class" : "form-control", "id" : "fieldId") }}
    </div>
</div>

{% include 'equipment/common_input.volt' %}

{% endblock %}
