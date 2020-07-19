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

        {% do arrayPush(rowData , equipment.id) %}
        {% do arrayPush(rowData , equipment.label) %}
        {% do arrayPush(rowData , equipment.description) %}
        {% do arrayPush(rowData , equipment.total_count) %}
        {% do arrayPush(rowData , equipment.isReusable) %}
        {% do arrayPush(tableBodyData , rowData) %}

    {% endfor %}

{% endblock %}
