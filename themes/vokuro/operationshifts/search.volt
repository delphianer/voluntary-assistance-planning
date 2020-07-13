{% extends 'layouts/inheritance/mastersearch.volt' %}

{% block title %}Search result{% endblock %}

{% block datatable %}

    {% set rowIDIndex = 0 %}

    {% set tableHeadingData = [
            'Id',
            'OperationId',
            'LocationId',
            'ShortDescription',
            'LongDescription',
            'Start',
            'End'
        ] %}

    {% for operationshift in page.items %}

        {% set rowData = [] %}

        {% set foo = arrayPush(rowData, operationshift.operationId) %}
        {% set foo = arrayPush(rowData, operationshift.locationId) %}
        {% set foo = arrayPush(rowData, operationshift.shortDescription) %}
        {% set foo = arrayPush(rowData, operationshift.longDescription) %}
        {% set foo = arrayPush(rowData, operationshift.start) %}
        {% set foo = arrayPush(rowData, operationshift.end) %}

        {% set foo = arrayPush(tableBodyData , rowData) %}

    {% endfor %}

{% endblock %}
