{% extends 'layouts/inheritance/masteredit.volt' %}

{% block title %}Edit $plural${% endblock %}

{% block inputelements %}

{# TODO: remove not necessary columns and this comment #}

$captureFields$

{{ hidden_field("id") }}

{% endblock %}
