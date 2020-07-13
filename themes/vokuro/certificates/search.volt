{% extends 'layouts/inheritance/mastersearch.volt' %}

{% block title %}Search result{% endblock %}

{% block datatable %}

    {% set rowIDIndex = 0 %}

    {% set tableHeadingData = [
            'Id',
            'Label',
            'Description'
        ] %}

    {% for certificate in page.items %}

        {% set rowData = [] %}

        {% set foo = arrayPush(rowData , certificate.id) %}
        {% set foo = arrayPush(rowData , certificate.label) %}
        {% set foo = arrayPush(rowData , certificate.description) %}

        {% set foo = arrayPush(tableBodyData , rowData) %}

    {% endfor %}

{% endblock %}
