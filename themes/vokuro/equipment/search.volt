{% extends 'layouts/inheritance/mastersearch.volt' %}

{% block title %}Search result{% endblock %}

{% block datatable %}

    {% set rowIDIndex = 0 %}

    {% set tableHeadingData = [
            'Id',
            'Label',
            'Description',
            'Number on stock',
            'Is Reusable'
        ] %}

    {% for equipment in page.items %}

        {% set rowData = [] %}

        {% set foo = arrayPush(rowData , equipment.id) %}
        {% set foo = arrayPush(rowData , equipment.label) %}
        {% set foo = arrayPush(rowData , equipment.description) %}
        {% set foo = arrayPush(rowData , equipment.total_count) %}
        {% set foo = arrayPush(rowData , equipment.isReusable) %}
        {% set foo = arrayPush(tableBodyData , rowData) %}

    {% endfor %}

{% endblock %}
