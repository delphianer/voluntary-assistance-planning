{% extends 'layouts/inheritance/mastersearch.volt' %}

{% block title %}Search result{% endblock %}

{% block datatable %}

    {% set rowIDIndex = 0 %}


    {% set tableHeadingData = [
            'Id',
            'VehiclesId',
            'Label',
            'Description',
            'Is Of Numeric',
            'Value Of String',
            'Value Of Numeric'
        ] %}

    {% for vehiclepropertie in page.items %}

        {% set rowData = [] %}

        {% set foo = arrayPush(rowData, vehiclepropertie.id) %}
        {% set foo = arrayPush(rowData, vehiclepropertie.vehiclesId) %}
        {% set foo = arrayPush(rowData, vehiclepropertie.label) %}
        {% set foo = arrayPush(rowData, vehiclepropertie.description) %}
        {% set foo = arrayPush(rowData, vehiclepropertie.is_numeric) %}
        {% set foo = arrayPush(rowData, vehiclepropertie.value_string) %}
        {% set foo = arrayPush(rowData, vehiclepropertie.value_numeric) %}

        {% set foo = arrayPush(tableBodyData , rowData) %}

    {% endfor %}

{% endblock %}
