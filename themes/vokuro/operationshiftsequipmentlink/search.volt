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

        {% set foo = arrayPush(rowData, operationshifts_equipment_link.id) %}
        {% set foo = arrayPush(rowData, operationshifts_equipment_link.operationShiftId) %}
        {% set foo = arrayPush(rowData, operationshifts_equipment_link.equipmentId) %}
        {% set foo = arrayPush(rowData, operationshifts_equipment_link.shortDescription) %}
        {% set foo = arrayPush(rowData, operationshifts_equipment_link.longDescription) %}
        {% set foo = arrayPush(rowData, operationshifts_equipment_link.need_count) %}

        {% set foo = arrayPush(tableBodyData , rowData) %}

    {% endfor %}

{% endblock %}
