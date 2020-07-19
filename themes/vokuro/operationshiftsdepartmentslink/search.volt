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
            {% do arrayPush(rowData, operationshifts_departments_link.id) %}
            {% do arrayPush(rowData, operationshifts_departments_link.operationShiftId) %}
            {% do arrayPush(rowData, operationshifts_departments_link.departmentId) %}
            {% do arrayPush(rowData, operationshifts_departments_link.shortDescription) %}
            {% do arrayPush(rowData, operationshifts_departments_link.longDescription) %}
            {% do arrayPush(rowData, operationshifts_departments_link.numberVolunteersNeeded) %}
            {% do arrayPush(rowData, operationshifts_departments_link.minimumCertificateRanking) %}

        {% do arrayPush(tableBodyData , rowData) %}

    {% endfor %}

{% endblock %}
