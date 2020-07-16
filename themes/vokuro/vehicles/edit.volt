{% extends 'layouts/inheritance/masteredit.volt' %}

{% block title %}Edit  Vehicle{% endblock %}


{% block startOfTablist %}

    <ul class="nav nav-tabs" id="user-edit-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="basic-tab" data-toggle="tab" href="#basic" role="tab" aria-controls="basic" aria-selected="true">Main</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="additional-tab" data-toggle="tab" href="#additional" role="tab" aria-controls="additional" aria-selected="false">Additional</a>
        </li>
    </ul>


    <div class="tab-content mt-3">
        <div class="tab-pane fade show active" id="basic" role="tabpanel" aria-labelledby="basic-tab">

{% endblock %}



{% block inputelements %}

{{ hidden_field("id") }}

{% include 'vehicles/common_input.volt' %}

{% endblock %}



{% block endOfTablist %}

        </div>

        <div class="tab-pane fade" id="additional" role="tabpanel" aria-labelledby="additional-tab">

            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Property</th>
                    <th>Value</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                {% set isAllowedToEdit = (userRole is defined and acl.isAllowed( userRole, dispatcher.getControllerName(), "edit")) %}
                {% set isAllowedToDelete = (userRole is defined and acl.isAllowed( userRole, dispatcher.getControllerName(), "edit")) %}

                {% for property in vehicle.Vehicleproperties %}
                    <tr>
                        <td>{{ property.label }}</td>

                        {% if property.is_numeric == 'Y' %}

                        <td>{{ numberFormat(property.value_numeric) }}</td>

                        {% else %}

                        <td>{{ property.value_string }}</td>

                        {% endif %}

                        {% if isAllowedToEdit %}
                        <td class="td-width-12">
                            <button type="submit" class="btn btn-sm btn-outline-warning"
                                    name="submitAction"
                                    value="edit{{property.id}}">
                                    <i class="icon-pencil"></i> Edit
                            </button>
                        </td>
                        {% endif %}

                        {% if isAllowedToDelete %}
                        <td class="td-width-12">
                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                    name="submitAction"
                                    value="del{{property.id}}">
                                    <i class="icon-pencil"></i> delete
                            </button>
                        </td>
                        {% endif %}

                    </tr>
                {% else %}
                    <tr>
                        <td colspan="4" class="text-center">No additional properties found</td>
                    </tr>
                {% endfor %}
                </tbody>
            </table>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-sm btn-primary"
                            name="submitAction" value="goToProperty">Add new property</button>
                </div>
            </div>

        </div>
    </div>

{% endblock %}
