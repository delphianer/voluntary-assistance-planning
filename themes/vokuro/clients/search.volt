{% extends 'layouts/inheritance/mastersearch.volt' %}

{% block title %}Search result{% endblock %}

{% block datatable %}

    {% set rowIDIndex = 0 %}


    {# TODO: remove not necessary columns and this comment #}
    {# TODO: change format of header columns to an array
        example: [
                     'Id',
                     'Label',
                     'Description'
                 ]
        then remove this comment
     #}
    {% set tableHeadingData = [
            'Id',
            'Label',
            'Description',
            'Contact Information'
        ] %}

    {% for client in page.items %}

        {% set rowData = [] %}

        {% set foo = arrayPush(rowData , client.id) %}
        {% set foo = arrayPush(rowData , client.label) %}
        {% set foo = arrayPush(rowData , client.description) %}
        {% set foo = arrayPush(rowData , client.contactInformation) %}

        {% set foo = arrayPush(tableBodyData , rowData) %}

    {% endfor %}

{% endblock %}
