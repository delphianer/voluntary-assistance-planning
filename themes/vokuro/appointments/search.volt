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
            'Department',
            'Client',
            'Location'
        ] %}

    {% for appointment in page.items %}

        {% set rowData = [] %}
        {% do arrayPush(rowData, appointment.id ) %}
        {% do arrayPush(rowData, appointment.label ) %}
        {% do arrayPush(rowData, appointment.description ) %}
        {% do arrayPush(rowData, appointment.start ) %}
        {% do arrayPush(rowData, appointment.end ) %}
        {% do arrayPush(rowData, ((appointment.Departments is defined and appointment.Departments is not null) ? appointment.Departments.Label : '-') ) %}
        {% do arrayPush(rowData, ((appointment.Clients is defined and appointment.Clients is not null) ? appointment.Clients.Label : '-') ) %}
        {% do arrayPush(rowData, ((appointment.Locations is defined and appointment.Locations is not null) ? appointment.Locations.Label : '-') ) %}

        {% do arrayPush(tableBodyData , rowData) %}

    {% endfor %}

{% endblock %}
