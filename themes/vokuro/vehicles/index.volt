{% extends 'layouts/inheritance/masterindex.volt' %}

{% block title %}Search vehicles{% endblock %}

{% block inputelements %}

<div class="form-group">
    <div class="col-sm-10">
        {{ text_field("id", "type" : "numeric", "class" : "form-control", "placeholder" : "Id", "id" : "fieldId") }}
    </div>
</div>

{% include 'vehicles/common_input.volt' %}

{% endblock %}
