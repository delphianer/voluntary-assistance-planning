{% extends 'layouts/inheritance/mastersearch.volt' %}

{% block title %}Search result{% endblock %}

{% block datatable %}

    {% set rowIDIndex = 0 %}

    {% set tableHeadingData = [
            'Id',
            'Label',
            'Description'
        ] %}

    {% for department in page.items %}

        {% set rowData = [] %}

        {% do arrayPush(rowData , department.id) %}
        {% do arrayPush(rowData , department.label) %}
        {% do arrayPush(rowData , department.description) %}

        {% do arrayPush(tableBodyData , rowData) %}

    {% endfor %}

{% endblock %}
