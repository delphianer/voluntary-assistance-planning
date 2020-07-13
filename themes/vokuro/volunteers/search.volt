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
        {% set foo = arrayPush(rowData, volunteer.userId) %}
        {% set foo = arrayPush(rowData, volunteer.departmentId) %}

        {% set foo = arrayPush(tableBodyData , rowData) %}

    {% endfor %}

{% endblock %}
