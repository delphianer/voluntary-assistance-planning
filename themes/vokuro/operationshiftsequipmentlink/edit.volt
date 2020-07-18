{% extends 'layouts/inheritance/masteredit.volt' %}

{% block title %}Edit Operation Shift-&gt;Equipment{% endblock %}

{% block inputelements %}

{% include 'operationshiftsequipmentlink/common_input.volt' %}

{{ hidden_field("id") }}

{% endblock %}
