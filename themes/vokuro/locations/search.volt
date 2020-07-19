{% extends 'layouts/inheritance/mastersearch.volt' %}

{% block title %}Search result{% endblock %}

{% block datatable %}

    {% set rowIDIndex = 0 %}

    {% set tableHeadingData = [
            'Id',
            'Label',
            'Description',
            'Street',
            'AdditionalText',
            'Postalcode',
            'City',
            'Country'
        ] %}

    {% for location in page.items %}

        {% set rowData = [] %}

            {% do arrayPush(rowData , location.id) %}
            {% do arrayPush(rowData , location.label) %}
            {% do arrayPush(rowData , location.description) %}
            {% do arrayPush(rowData , location.street) %}
            {% do arrayPush(rowData , location.additionalText) %}
            {% do arrayPush(rowData , location.postalcode) %}
            {% do arrayPush(rowData , location.city) %}
            {% do arrayPush(rowData , location.country) %}

        {% do arrayPush(tableBodyData , rowData) %}

    {% endfor %}

{% endblock %}
