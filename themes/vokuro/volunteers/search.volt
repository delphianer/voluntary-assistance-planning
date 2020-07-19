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

        {% do arrayPush(rowData, volunteer.id) %}
        {% do arrayPush(rowData, volunteer.firstName) %}
        {% do arrayPush(rowData, volunteer.lastName) %}
        {% if volunteer.user is defined and volunteer.user is not empty %}
            {% do arrayPush(rowData, volunteer.user.name) %}
        {% else %}
            {% do arrayPush(rowData, '-') %}
        {% endif %}
        {% if volunteer.department is defined and volunteer.department is not empty %}
            {% do arrayPush(rowData, volunteer.department.label) %}
        {% else %}
            {% do arrayPush(rowData, '-') %}
        {% endif %}

        {% do arrayPush(tableBodyData , rowData) %}

    {% endfor %}

{% endblock %}
