{% extends 'layouts/inheritance/mastersearch.volt' %}

{% block title %}Search result{% endblock %}

{% block datatable %}

    {% set rowIDIndex = 0 %}

    {% set tableHeadingData = [
            'Id',
            'OperationShiftId',
            'VehicleId',
            'ShortDescription',
            'LongDescription'
        ] %}

    {% for operationshifts_vehicles_link in page.items %}

        {% set rowData = [] %}

        {% set foo = arrayPush(rowData, operationshifts_vehicles_link.id) %}
        {% set foo = arrayPush(rowData, operationshifts_vehicles_link.operationShiftId) %}
        {% set foo = arrayPush(rowData, operationshifts_vehicles_link.vehicleId) %}
        {% set foo = arrayPush(rowData, operationshifts_vehicles_link.shortDescription) %}
        {% set foo = arrayPush(rowData, operationshifts_vehicles_link.longDescription) %}

        {% set foo = arrayPush(tableBodyData , rowData) %}

    {% endfor %}

{% endblock %}
