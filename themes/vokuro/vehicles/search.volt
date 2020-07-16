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
                     'Fix Properties'
        ] %}

    {% for vehicle in page.items %}

        {% set rowData = [] %}

            {% set foo = arrayPush(rowData , vehicle.id) %}
            {% set foo = arrayPush(rowData , vehicle.label) %}
            {% set foo = arrayPush(rowData , vehicle.description) %}
            {% set foo = arrayPush(rowData , vehicle.technicalInspection) %}
            {% set foo = arrayPush(rowData , vehicle.seatCount) %}

            {% set propText = '' %}
                {% set comma = '' %}
                {% if vehicle.isAmbulance == 'Y' %}
                    {% set propText = propText ~ 'IsAmbulance' %}
                    {% set comma = ', ' %}
                {% endif %}

                {% if vehicle.hasFlashingLights == 'Y' %}
                    {% set propText = propText ~ comma ~ 'HasFlashingLights' %}
                    {% set comma = ', ' %}
                {% endif %}

                {% if vehicle.hasRadioCom == 'Y' %}
                    {% set propText = propText ~ comma ~ 'HasRadioCom' %}
                    {% set comma = ', ' %}
                {% endif %}

                {% if vehicle.hasDigitalRadioCom == 'Y' %}
                    {% set propText = propText ~ comma ~ 'HasDigitalRadioCom' %}
                {% endif %}

            {% set foo = arrayPush(rowData , propText) %}

        {% set foo = arrayPush(tableBodyData , rowData) %}

    {% endfor %}

{% endblock %}
