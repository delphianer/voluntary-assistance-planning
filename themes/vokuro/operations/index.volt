{% extends 'layouts/inheritance/masterindex.volt' %}

{% block title %}Search operations{% endblock %}

{% block inputelements %}

<div class="form-group">
    <div class="col-sm-10">
        {{ form.render("id") }}
    </div>
</div>

{% include 'operations/common_input.volt' %}

{% endblock %}
