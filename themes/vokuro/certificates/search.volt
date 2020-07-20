{% extends 'layouts/inheritance/mastersearch.volt' %}

{% block title %}Search result{% endblock %}

{% block datatable %}

    {% set rowIDIndex = 0 %}

    {% set tableHeadingData = [ 'Id', 'Label', 'Description'] %}

    {% for certificate in page.items %}

        {% set rowData = [] %}

        {% do arrayPush(rowData , certificate.id) %}
        {% do arrayPush(rowData , certificate.label) %}
        {% do arrayPush(rowData , certificate.description) %}

        {% do arrayPush(tableBodyData , rowData) %}

    {% endfor %}

{% endblock %}
