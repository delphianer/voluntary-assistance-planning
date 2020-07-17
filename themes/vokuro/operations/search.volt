{% extends 'layouts/inheritance/mastersearch.volt' %}

{% block title %}Search result{% endblock %}

{% block datatable %}

    {% set rowIDIndex = 0 %}

    {% set tableHeadingData = [
            'ID',
            'Client',
            'short desc.',
            'main department'
        ] %}

    {% for operation in page.items %}

        {% set rowData = [] %}

            {% set foo = arrayPush(rowData, operation.id) %}
            {% set foo = arrayPush(rowData, operation.Clients.label) %}
            {% set foo = arrayPush(rowData, operation.shortDescription) %}
            {% if operation.department is defined and operation.department is not empty %}
                {% set foo = arrayPush(rowData, operation.department.label) %}
            {% else %}
                {% set foo = arrayPush(rowData, '-') %}
            {% endif %}

        {% set foo = arrayPush(tableBodyData , rowData) %}

    {% endfor %}

{% endblock %}
