{% extends 'layouts/inheritance/masteredit.volt' %}

{% block title %}Edit Vehicle Property{% endblock %}

{% block inputelements %}

{{ hidden_field("id") }}

{% include 'vehicleproperties/common_input.volt' %}

{{ hidden_field("id") }}

{% endblock %}
