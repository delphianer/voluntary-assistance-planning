{% extends 'layouts/inheritance/masteredit.volt' %}

{% block title %}Edit Volunteer{% endblock %}


{% block startOfTablist %}

    <ul class="nav nav-tabs" id="user-edit-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="basic-tab" data-toggle="tab" href="#basic" role="tab" aria-controls="basic" aria-selected="true">Main</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="additional-tab" data-toggle="tab" href="#additional" role="tab" aria-controls="additional" aria-selected="false">Certificates</a>
        </li>
    </ul>

    <div class="tab-content mt-3">
        <div class="tab-pane fade show active" id="basic" role="tabpanel" aria-labelledby="basic-tab">

{% endblock %}



{% block inputelements %}

{% include 'volunteers/common_input.volt' %}

{{ form.render("id") }}

{% endblock %}




{% block endOfTablist %}

        </div>

        <div class="tab-pane fade" id="additional" role="tabpanel" aria-labelledby="additional-tab">

            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Certificate</th>
                    <th>valid until</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                {% for certLink in volunteer.VolunteersCertificatesLink %}
                    <tr>
                        <td>{{ certLink.Certificates.label }}</td>

                        <td>{{ certLink.validUntil }}</td>

                        <td class="td-width-12">
                            <button type="submit" class="btn btn-sm btn-outline-warning"
                                    name="submitAction"
                                    value="edit{{certLink.id}}">
                                    <i class="icon-pencil"></i> change
                            </button>
                        </td>

                        <td class="td-width-12">
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
                            name="submitAction" value="saveCertDefinition">Add Certificate</button>
                </div>
            </div>

        </div>
    </div>

{% endblock %}
