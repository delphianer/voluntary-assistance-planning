{% extends 'layouts/inheritance/masteredit.volt' %}

{% block title %}Edit operation{% endblock %}

{% block inputelements %}

{% include 'operations/common_input.volt' %}

{{ hidden_field("id") }}

{% endblock %}
