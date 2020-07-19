{% extends 'layouts/inheritance/mastersearch.volt' %}

{% block title %}Search result{% endblock %}

{% block datatable %}

    {% set rowIDIndex = 0 %}

    {% set tableHeadingData = [
            'Id',
            'OperationId',
            'LocationId',
            'ShortDescription',
            'Start',
            'End'
        ] %}

    {% for operationshift in page.items %}

        {% set rowData = [] %}

        {% do arrayPush(rowData, operationshift.id) %}
        {% do arrayPush(rowData, operationshift.operationId) %}
        {% do arrayPush(rowData, operationshift.locationId) %}
        {% do arrayPush(rowData, operationshift.shortDescription) %}
        {% do arrayPush(rowData, operationshift.start) %}
        {% do arrayPush(rowData, operationshift.end) %}

        {% do arrayPush(tableBodyData , rowData) %}

    {% endfor %}

{% endblock %}
