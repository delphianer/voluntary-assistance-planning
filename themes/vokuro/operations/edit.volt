{% extends 'layouts/inheritance/masteredit.volt' %}

{% block title %}Edit operation{% endblock %}



{% block startOfTablist %}

    {% set activeTabKey = 'basic' %}

    {% set tabs = [
        'basic' : 'Main',
        'shifts' : 'Shifts'
    ] %}

    {% include 'layouts/includes/tablist.volt' %}

{% endblock %}




{% block inputelements %}

{% include 'operations/common_input.volt' %}

{{ hidden_field("id") }}

{% endblock %}






{% block endOfTablist %}

{{ tabChangeList['shifts'] }}


    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>nr</th>
            <th>location</th>
            <th>short descr.</th>
            <th>start</th>
            <th>end</th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        {% set isAllowedToEdit = (userRole is defined and acl.isAllowed( userRole, dispatcher.getControllerName(), "edit")) %}
        {% set isAllowedToDelete = (userRole is defined and acl.isAllowed( userRole, dispatcher.getControllerName(), "edit")) %}

        {% set rowNumber = 0 %}
        {% for shift in operation.Operationshifts %}
            <tr>
                {% set rowNumber = rowNumber+1 %}
                <td>{{ rowNumber }}</td>

                <td>{{ shift.Locations.label }}</td>

                <td>{{ shift.shortDescription }}</td>

                <td>{{ shift.start }}</td>

                <td>{{ shift.end }}</td>

                {% if isAllowedToEdit %}
                <td class="td-width-12">
                    <button type="submit" class="btn btn-sm btn-outline-warning"
                            name="submitAction"
                            value="edit{{shift.id}}">
                            <i class="icon-pencil"></i> Edit
                    </button>
                </td>
                {% endif %}

                {% if isAllowedToDelete %}
                <td class="td-width-12">
                    <button type="submit" class="btn btn-sm btn-outline-danger"
                            name="submitAction"
                            value="del{{shift.id}}">
                            <i class="icon-remove"></i> delete
                    </button>
                </td>
                {% endif %}

            </tr>
        {% else %}
            <tr>
                <td colspan="7" class="text-center">No shift set up</td>
            </tr>
        {% endfor %}
        </tbody>
    </table>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-sm btn-primary"
                    name="submitAction" value="goToShift">Add new shift</button>
        </div>
    </div>

{{ endAllTabs }}

{% endblock %}
