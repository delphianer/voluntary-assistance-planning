{% extends 'layouts/inheritance/mastersearch.volt' %}

{% block title %}Search result{% endblock %}

{% block datatable %}

    {% set rowIDIndex = 0 %}

    {% set tableHeadingData = [
            'Id',
            'Label',
            'Description',
            'Contact Information'
        ] %}

    {% for client in page.items %}

        {% set rowData = [] %}

        {% do arrayPush(rowData , client.id) %}
        {% do arrayPush(rowData , client.label) %}
        {% do arrayPush(rowData , client.description) %}
        {% do arrayPush(rowData , client.contactInformation) %}

        {% do arrayPush(tableBodyData , rowData) %}

    {% endfor %}

{% endblock %}
