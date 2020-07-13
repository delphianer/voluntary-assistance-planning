{% extends 'layouts/inheritance/mastersearch.volt' %}

{% block title %}Search result{% endblock %}

{% block datatable %}

    {% set rowIDIndex = 0 %}

    {% set tableHeadingData = [
            'Id',
            'ClientId',
            'ShortDescription',
            'LongDescription',
            'MainDepartmentId'
        ] %}

    {% for operation in page.items %}

        {% set rowData = [] %}

            {% set foo = arrayPush(rowData, operation.id) %}
            {% set foo = arrayPush(rowData, operation.clientId) %}
            {% set foo = arrayPush(rowData, operation.shortDescription) %}
            {% set foo = arrayPush(rowData, operation.longDescription) %}
            {% set foo = arrayPush(rowData, operation.mainDepartmentId) %}

        {% set foo = arrayPush(tableBodyData , rowData) %}

    {% endfor %}

{% endblock %}
