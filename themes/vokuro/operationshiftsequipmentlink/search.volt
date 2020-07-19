{% extends 'layouts/inheritance/mastersearch.volt' %}

{% block title %}Search result{% endblock %}

{% block datatable %}

    {% set rowIDIndex = 0 %}

    {% set tableHeadingData = [
            'Id',
            'OperationShiftId',
            'EquipmentId',
            'ShortDescription',
            'LongDescription',
            'Need Count'
        ] %}

    {% for operationshifts_equipment_link in page.items %}

        {% set rowData = [] %}

        {% do arrayPush(rowData, operationshifts_equipment_link.id) %}
        {% do arrayPush(rowData, operationshifts_equipment_link.operationShiftId) %}
        {% do arrayPush(rowData, operationshifts_equipment_link.equipmentId) %}
        {% do arrayPush(rowData, operationshifts_equipment_link.shortDescription) %}
        {% do arrayPush(rowData, operationshifts_equipment_link.longDescription) %}
        {% do arrayPush(rowData, operationshifts_equipment_link.need_count) %}

        {% do arrayPush(tableBodyData , rowData) %}

    {% endfor %}

{% endblock %}
