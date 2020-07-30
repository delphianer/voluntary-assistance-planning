{% extends 'layouts/inheritance/masteredit.volt' %}

{% block title %}Declare Commitment{% endblock %}

{% block inputelements %}

{% include 'opshdeplvolunteerslink/common_input.volt' %}

{{ hidden_field("id") }}

{% endblock %}
