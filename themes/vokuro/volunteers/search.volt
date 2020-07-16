{% extends 'layouts/inheritance/mastersearch.volt' %}

{% block title %}Search result{% endblock %}

{% block datatable %}

    {% set rowIDIndex = 0 %}

    {% set tableHeadingData = [
            'Id',
            'FirstName',
            'LastName',
            'UserId',
            'DepartmentId'
        ] %}

    {% for volunteer in page.items %}

        {% set rowData = [] %}

        {% set foo = arrayPush(rowData, volunteer.id) %}
        {% set foo = arrayPush(rowData, volunteer.firstName) %}
        {% set foo = arrayPush(rowData, volunteer.lastName) %}
        {% if volunteer.user is defined and volunteer.user is not empty %}
            {% set foo = arrayPush(rowData, volunteer.user.name) %}
        {% else %}
            {% set foo = arrayPush(rowData, '-') %}
        {% endif %}
        {% if volunteer.department is defined and volunteer.department is not empty %}
            {% set foo = arrayPush(rowData, volunteer.department.label) %}
        {% else %}
            {% set foo = arrayPush(rowData, '-') %}
        {% endif %}

        {% set foo = arrayPush(tableBodyData , rowData) %}

    {% endfor %}

{% endblock %}
