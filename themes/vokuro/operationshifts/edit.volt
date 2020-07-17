{% extends 'layouts/inheritance/masteredit.volt' %}

{% block title %}Edit Operation Shift{% endblock %}

{% block inputelements %}

{% include 'operationshifts/common_input.volt' %}

{{ hidden_field("id") }}

{% endblock %}
