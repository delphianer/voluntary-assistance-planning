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
        {% do arrayPush(rowData, appointment.id ) %}
        {% do arrayPush(rowData, appointment.label ) %}
        {% do arrayPush(rowData, appointment.description ) %}
        {% do arrayPush(rowData, appointment.start ) %}
        {% do arrayPush(rowData, appointment.end ) %}
        {% do arrayPush(rowData, appointment.locationId ) %}
        {% do arrayPush(rowData, appointment.mainDepartmentId ) %}
        {% do arrayPush(rowData, appointment.clientId ) %}
        {% do arrayPush(rowData, appointment.create_time ) %}
        {% do arrayPush(rowData, appointment.update_time ) %}

        {% do arrayPush(tableBodyData , rowData) %}

    {% endfor %}

{% endblock %}
