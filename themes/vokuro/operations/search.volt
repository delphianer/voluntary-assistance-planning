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

            {% do arrayPush(rowData, operation.id) %}
            {% do arrayPush(rowData, operation.Clients.label) %}
            {% do arrayPush(rowData, operation.shortDescription) %}
            {% if operation.department is defined and operation.department is not empty %}
                {% do arrayPush(rowData, operation.department.label) %}
            {% else %}
                {% do arrayPush(rowData, '-') %}
            {% endif %}
            {% set output = true %}
            {% for Operationshift in operation.Operationshifts %}
                {% if output %}
                    {% if Operationshift.minstart is defined and Operationshift.minstart is not empty %}
                        {% do arrayPush(rowData, Operationshift.minstart['minstart']) %}
                    {% else %}
                        {% do arrayPush(rowData, '-') %}
                    {% endif %}
                    {% if Operationshift.maxstart is defined and Operationshift.maxstart is not empty %}
                        {% do arrayPush(rowData, Operationshift.maxstart['maxstart']) %}
                    {% else %}
                        {% do arrayPush(rowData, '-') %}
                    {% endif %}
                    {% set output = false %}
                {% endif %}
            {% else %}
                {% do arrayPush(rowData, '-') %}
                {% do arrayPush(rowData, '-') %}
            {% endfor %}

        {% do arrayPush(tableBodyData , rowData) %}

    {% endfor %}

{% endblock %}
