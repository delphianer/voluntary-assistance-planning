{% extends 'layouts/inheritance/mastersearch.volt' %}

{% block title %}Search result{% endblock %}

{% block datatable %}

    {% set rowIDIndex = 0 %}

    {% set tableHeadingData = [
            'Id',
            'Label',
            'Description',
            'Start',
            'End',
            'LocationId',
            'MainDepartmentId',
            'ClientId',
            'Created on',
            'last updated'
        ] %}

    {% for appointment in page.items %}

        {% set rowData = [] %}
        {% set foo = arrayPush(rowData, appointment.id ) %}
        {% set foo = arrayPush(rowData, appointment.label ) %}
        {% set foo = arrayPush(rowData, appointment.description ) %}
        {% set foo = arrayPush(rowData, appointment.start ) %}
        {% set foo = arrayPush(rowData, appointment.end ) %}
        {% set foo = arrayPush(rowData, appointment.locationId ) %}
        {% set foo = arrayPush(rowData, appointment.mainDepartmentId ) %}
        {% set foo = arrayPush(rowData, appointment.clientId ) %}
        {% set foo = arrayPush(rowData, appointment.create_time ) %}
        {% set foo = arrayPush(rowData, appointment.update_time ) %}

        {% set foo = arrayPush(tableBodyData , rowData) %}

    {% endfor %}

{% endblock %}
