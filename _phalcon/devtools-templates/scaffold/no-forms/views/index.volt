{% extends 'layouts/inheritance/masterindex.volt' %}

{% block title %}Search $plural${% endblock %}

{% block inputelements %}

{# TODO: remove not necessary columns and this comment #}

$captureFields$

{% endblock %}
