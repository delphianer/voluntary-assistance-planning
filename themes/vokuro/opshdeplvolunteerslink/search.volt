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

        {% do arrayPush(rowData, opshdepl_volunteers_link.id) %}
        {% do arrayPush(rowData, opshdepl_volunteers_link.shortDescription) %}
        {% do arrayPush(rowData, opshdepl_volunteers_link.longDescription) %}
        {% do arrayPush(rowData, opshdepl_volunteers_link.opDepNeedId) %}
        {% do arrayPush(rowData, opshdepl_volunteers_link.volunteersId) %}
        {% do arrayPush(rowData, opshdepl_volunteers_link.volCurrentMaximumCertRank) %}

        {% do arrayPush(tableBodyData , rowData) %}

    {% endfor %}

{% endblock %}
