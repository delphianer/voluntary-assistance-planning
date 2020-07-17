{% extends 'layouts/inheritance/masteredit.volt' %}

{% block title %}Edit Volunteer{% endblock %}


{% block startOfTablist %}

    {% set activeTabKey = 'basic' %}

    {% set tabs = [
        'basic' : 'Main',
        'certificates' : 'Certificates'
    ] %}

    {% include 'layouts/includes/tablist.volt' %}

{% endblock %}



{% block inputelements %}

    {% include 'volunteers/common_input.volt' %}

{{ form.render("id") }}

{% endblock %}



{% block endOfTablist %}

{{ tabChangeList['certificates'] }}


    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th class="text-center">Certificate</th>
            <th class="text-center">valid until</th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>

        {% for certLink in volunteer.VolunteersCertificatesLink %}
            <tr>
                <td class="text-center">{{ certLink.Certificates.label }}</td>

                {% if certLink.validUntil is empty or certLink.validUntil == '0000-00-00' %}
                <td class="text-center">-</td>
                {% else %}
                <td class="text-center">{{ certLink.validUntil }}</td>
                {% endif %}

                <td class="td-width-12 text-center">
                    <button type="submit" class="btn btn-sm btn-outline-warning"
                            name="submitAction"
                            value="edit{{certLink.id}}">
                            <i class="icon-pencil"></i> change
                    </button>
                </td>

                <td class="td-width-12 text-center">
                    <button type="submit" class="btn btn-sm btn-outline-danger"
                            name="submitAction"
                            value="del{{certLink.id}}">
                            <i class="icon-pencil"></i> remove
                    </button>
                </td>

            </tr>
        {% else %}
            <tr>
                <td colspan="4" class="text-center">No certificates found</td>
            </tr>
        {% endfor %}
        </tbody>
    </table>

    <div class="form-inline">
        <div class="col-sm-offset-2 col-sm-10">

            {{ form.render("volCertLnkId") }}

            {{ form.render("certificate") }}

            {{ form.render("certValidUntil") }}

            <button type="submit" class="btn btn-sm btn-primary"
                    name="submitAction" value="saveCertDefinition">Save Certificate</button>
        </div>
    </div>

{{ endAllTabs }}

{% endblock %}
