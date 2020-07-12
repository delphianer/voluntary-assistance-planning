{% extends 'layouts/inheritance/mastersearch.volt' %}

{% block title %}Search result{% endblock %}

{% block datatable %}

    {% set rowIDIndex = 0 %}

    {% set tableHeadingData = [
                     'Id',
                     'Label',
                     'Description',
                     'TechnicalInspection',
                     'SeatCount',
                     'IsAmbulance',
                     'HasFlashingLights',
                     'HasRadioCom',
                     'HasDigitalRadioCom'
        ] %}

    {% for vehicle in page.items %}

        {% set rowData = [] %}

            {% set foo = arrayPush(rowData , vehicle.id) %}
            {% set foo = arrayPush(rowData , vehicle.label) %}
            {% set foo = arrayPush(rowData , vehicle.description) %}
            {% set foo = arrayPush(rowData , vehicle.technicalInspection) %}
            {% set foo = arrayPush(rowData , vehicle.seatCount) %}
            {% set foo = arrayPush(rowData , vehicle.isAmbulance) %}
            {% set foo = arrayPush(rowData , vehicle.hasFlashingLights) %}
            {% set foo = arrayPush(rowData , vehicle.hasRadioCom) %}
            {% set foo = arrayPush(rowData , vehicle.hasDigitalRadioCom) %}

        {% set foo = arrayPush(tableBodyData , rowData) %}

    {% endfor %}

{% endblock %}
