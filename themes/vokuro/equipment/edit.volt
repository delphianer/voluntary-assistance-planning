{% extends 'layouts/inheritance/masteredit.volt' %}

{% block title %}Edit equipment{% endblock %}

{% block inputelements %}

{% include 'equipment/common_input.volt' %}

    {{ hidden_field("id") }}

{% endblock %}
