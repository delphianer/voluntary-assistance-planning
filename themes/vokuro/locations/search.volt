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
            'Country',
            'Created On',
            'Last Updated'
        ] %}

    {% for location in page.items %}

        {% set rowData = [] %}

            {% set foo = arrayPush(rowData , location.id) %}
            {% set foo = arrayPush(rowData , location.label) %}
            {% set foo = arrayPush(rowData , location.description) %}
            {% set foo = arrayPush(rowData , location.street) %}
            {% set foo = arrayPush(rowData , location.additionalText) %}
            {% set foo = arrayPush(rowData , location.postalcode) %}
            {% set foo = arrayPush(rowData , location.city) %}
            {% set foo = arrayPush(rowData , location.country) %}
            {% set foo = arrayPush(rowData , location.create_time) %}
            {% set foo = arrayPush(rowData , location.update_time) %}

        {% set foo = arrayPush(tableBodyData , rowData) %}

    {% endfor %}

{% endblock %}
