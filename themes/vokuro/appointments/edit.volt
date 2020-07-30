{% extends 'layouts/inheritance/masteredit.volt' %}

{% block title %}Edit appointment{% endblock %}

{% block inputelements %}

{% include 'appointments/common_input.volt' %}

    {{ hidden_field("id") }}

{% endblock %}
