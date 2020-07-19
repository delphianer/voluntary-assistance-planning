{% extends 'layouts/inheritance/mastersearch.volt' %}

{% block title %}Search result{% endblock %}

{% block datatable %}

    {% set rowIDIndex = 0 %}

    {% set tableHeadingData = [
            'Id',
            'VolunteersId',
            'CertificatesId',
            'ValidUntil'
        ] %}

    {% for volunteers_certificates_link in page.items %}

        {% set rowData = [] %}

        {% do arrayPush(rowData, volunteers_certificates_link.id) %}
        {% do arrayPush(rowData, volunteers_certificates_link.volunteersId) %}
        {% do arrayPush(rowData, volunteers_certificates_link.certificatesId) %}
        {% do arrayPush(rowData, volunteers_certificates_link.validUntil) %}

        {% do arrayPush(tableBodyData , rowData) %}

    {% endfor %}

{% endblock %}
