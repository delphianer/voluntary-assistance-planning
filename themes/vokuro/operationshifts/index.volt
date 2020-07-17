{% extends 'layouts/inheritance/masterindex.volt' %}

{% block title %}Search operationshifts{% endblock %}

{% block inputelements %}

<div class="form-group">
    <div class="col-sm-10">
        {{ form.render("id") }}
    </div>
</div>

{% include 'operationshifts/common_input.volt' %}


{% endblock %}
