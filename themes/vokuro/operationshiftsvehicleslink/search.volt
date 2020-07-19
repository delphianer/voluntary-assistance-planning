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

        {% do arrayPush(rowData, operationshifts_vehicles_link.id) %}
        {% do arrayPush(rowData, operationshifts_vehicles_link.operationShiftId) %}
        {% do arrayPush(rowData, operationshifts_vehicles_link.vehicleId) %}
        {% do arrayPush(rowData, operationshifts_vehicles_link.shortDescription) %}
        {% do arrayPush(rowData, operationshifts_vehicles_link.longDescription) %}

        {% do arrayPush(tableBodyData , rowData) %}

    {% endfor %}

{% endblock %}
