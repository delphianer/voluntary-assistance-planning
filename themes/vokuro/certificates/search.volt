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
            'Description'
        ] %}

    {% for certificate in page.items %}

        {% set rowData = [] %}

        {% set foo = arrayPush(rowData , certificate.id) %}
        {% set foo = arrayPush(rowData , certificate.label) %}
        {% set foo = arrayPush(rowData , certificate.description) %}

        {% set foo = arrayPush(tableBodyData , rowData) %}

    {% endfor %}

{% endblock %}
