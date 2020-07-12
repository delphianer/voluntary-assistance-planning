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

        {% set foo = arrayPush(rowData , department.id) %}
        {% set foo = arrayPush(rowData , department.label) %}
        {% set foo = arrayPush(rowData , department.description) %}

        {% set foo = arrayPush(tableBodyData , rowData) %}

    {% endfor %}

{% endblock %}
