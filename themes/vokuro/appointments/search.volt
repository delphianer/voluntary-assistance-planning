{% extends 'layouts/inheritance/mastersearch.volt' %}

{% block title %}Search result{% endblock %}

{% block datatable %}

    {% set rowIDIndex = 0 %}

    {% set tableHeadingData = [
            'Id',
            'Create Of Time',
            'Create Of UserId',
            'Update Of Time',
            'Update Of UserId',
            'Label',
            'Description',
            'Start',
            'End',
            'LocationId',
            'MainDepartmentId',
            'ClientId'
        ] %}

    {% for appointment in page.items %}

        {% set rowData = [] %}
        {% set foo = arrayPush(rowData, appointment.id ) %}
        {% set foo = arrayPush(rowData, appointment.create_time ) %}
        {% set foo = arrayPush(rowData, appointment.create_userId ) %}
        {% set foo = arrayPush(rowData, appointment.update_time ) %}
        {% set foo = arrayPush(rowData, appointment.update_userId ) %}
        {% set foo = arrayPush(rowData, appointment.label ) %}
        {% set foo = arrayPush(rowData, appointment.description ) %}
        {% set foo = arrayPush(rowData, appointment.start ) %}
        {% set foo = arrayPush(rowData, appointment.end ) %}
        {% set foo = arrayPush(rowData, appointment.locationId ) %}
        {% set foo = arrayPush(rowData, appointment.mainDepartmentId ) %}
        {% set foo = arrayPush(rowData, appointment.clientId ) %}
        {% set foo = arrayPush(tableBodyData , rowData) %}

    {% endfor %}

{% endblock %}
