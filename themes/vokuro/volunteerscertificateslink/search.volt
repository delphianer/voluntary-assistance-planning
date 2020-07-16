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

        {% set foo = arrayPush(rowData, volunteers_certificates_link.id) %}
        {% set foo = arrayPush(rowData, volunteers_certificates_link.volunteersId) %}
        {% set foo = arrayPush(rowData, volunteers_certificates_link.certificatesId) %}
        {% set foo = arrayPush(rowData, volunteers_certificates_link.validUntil) %}

        {% set foo = arrayPush(tableBodyData , rowData) %}

    {% endfor %}

{% endblock %}
