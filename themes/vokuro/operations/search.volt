{% extends 'layouts/inheritance/mastersearch.volt' %}

{% block title %}Search result{% endblock %}

{% block datatable %}

    {% set rowIDIndex = 0 %}

    {% set tableHeadingData = [
            'ID',
            'Client',
            'Short Description',
            'Main Department',
            'Start',
            'End'
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
            {% set output = true %}
            {% for Operationshift in operation.Operationshifts %}
                {% if output %}
                    {% if Operationshift.minstart is defined and Operationshift.minstart is not empty %}
                        {% set foo = arrayPush(rowData, Operationshift.minstart['minstart']) %}
                    {% else %}
                        {% set foo = arrayPush(rowData, '-') %}
                    {% endif %}
                    {% if Operationshift.maxstart is defined and Operationshift.maxstart is not empty %}
                        {% set foo = arrayPush(rowData, Operationshift.maxstart['maxstart']) %}
                    {% else %}
                        {% set foo = arrayPush(rowData, '-') %}
                    {% endif %}
                    {% set output = false %}
                {% endif %}
            {% else %}
                {% set foo = arrayPush(rowData, '-') %}
                {% set foo = arrayPush(rowData, '-') %}
            {% endfor %}

        {% set foo = arrayPush(tableBodyData , rowData) %}

    {% endfor %}

{% endblock %}
