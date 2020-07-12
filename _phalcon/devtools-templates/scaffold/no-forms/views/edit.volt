{% extends 'layouts/inheritance/masteredit.volt' %}

{% block title %}Edit $singular${% endblock %}

{% block inputelements %}

{# TODO: remove not necessary columns and this comment #}

$captureFields$

{{ hidden_field("id") }}

{% endblock %}
