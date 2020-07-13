{% extends 'layouts/inheritance/mastersearch.volt' %}

{% block title %}Search result{% endblock %}

{% block datatable %}

    {% set rowIDIndex = 0 %}


    {% set tableHeadingData = [
            'Id',
            'OperationShiftId',
            'DepartmentId',
            'ShortDescription',
            'LongDescription',
            'NumberVolunteersNeeded',
            'MinimumCertificateRanking'
        ] %}

    {% for operationshifts_departments_link in page.items %}

        {% set rowData = [] %}
            {% set foo = arrayPush(rowData, operationshifts_departments_link.id) %}
            {% set foo = arrayPush(rowData, operationshifts_departments_link.operationShiftId) %}
            {% set foo = arrayPush(rowData, operationshifts_departments_link.departmentId) %}
            {% set foo = arrayPush(rowData, operationshifts_departments_link.shortDescription) %}
            {% set foo = arrayPush(rowData, operationshifts_departments_link.longDescription) %}
            {% set foo = arrayPush(rowData, operationshifts_departments_link.numberVolunteersNeeded) %}
            {% set foo = arrayPush(rowData, operationshifts_departments_link.minimumCertificateRanking) %}

        {% set foo = arrayPush(tableBodyData , rowData) %}

    {% endfor %}

{% endblock %}
