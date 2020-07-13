{% extends 'layouts/inheritance/mastersearch.volt' %}

{% block title %}Search result{% endblock %}

{% block datatable %}

    {% set rowIDIndex = 0 %}

    {% set tableHeadingData = [
            'Id',
            'ShortDescription',
            'LongDescription',
            'OpDepNeedId',
            'VolunteersId',
            'VolCurrentMaximumCertRank'
        ] %}

    {% for opshdepl_volunteers_link in page.items %}

        {% set rowData = [] %}

        {% set foo = arrayPush(rowData, opshdepl_volunteers_link.id) %}
        {% set foo = arrayPush(rowData, opshdepl_volunteers_link.shortDescription) %}
        {% set foo = arrayPush(rowData, opshdepl_volunteers_link.longDescription) %}
        {% set foo = arrayPush(rowData, opshdepl_volunteers_link.opDepNeedId) %}
        {% set foo = arrayPush(rowData, opshdepl_volunteers_link.volunteersId) %}
        {% set foo = arrayPush(rowData, opshdepl_volunteers_link.volCurrentMaximumCertRank) %}

        {% set foo = arrayPush(tableBodyData , rowData) %}

    {% endfor %}

{% endblock %}
