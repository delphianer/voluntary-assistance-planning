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

        {% do arrayPush(rowData, vehiclepropertie.id) %}
        {% do arrayPush(rowData, vehiclepropertie.vehiclesId) %}
        {% do arrayPush(rowData, vehiclepropertie.label) %}
        {% do arrayPush(rowData, vehiclepropertie.description) %}
        {% do arrayPush(rowData, vehiclepropertie.is_numeric) %}
        {% do arrayPush(rowData, vehiclepropertie.value_string) %}
        {% do arrayPush(rowData, vehiclepropertie.value_numeric) %}

        {% do arrayPush(tableBodyData , rowData) %}

    {% endfor %}

{% endblock %}
