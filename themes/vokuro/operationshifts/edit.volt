{% extends 'layouts/inheritance/masteredit.volt' %}

{% block title %}Edit Operation Shift{% endblock %}




{% block startOfTablist %}

    {% set activeTabKey = 'basic' %}

    {% set tabs = [
        'basic' : 'Main',
        'manpower' : 'Departments & Manpower',
        'equipment' : 'Equipment',
        'vehicles' : 'Vehicles'
    ] %}

    {% include 'layouts/includes/tablist.volt' %}

{% endblock %}





{% block inputelements %}

{% include 'operationshifts/common_input.volt' %}

{{ hidden_field("id") }}

{% endblock %}




{% block endOfTablist %}

{{ tabChangeList['manpower'] }}


todo: manpower


{{ tabChangeList['equipment'] }}



    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th class="text-center">Equipment</th>
            <th class="text-center">Short Desc</th>
            <th class="text-center">Needs</th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>

        {% for equiLink in operationshift.OperationshiftsEquipmentLink %}
            <tr>
                <td class="text-center">{{ equiLink.Equipment.label }}</td>
                <td class="text-center">{{ equiLink.shortDescription }}</td>
                <td class="text-center">{{ equiLink.need_count }}</td>

                <td class="td-width-12 text-center">
                    <button type="submit" class="btn btn-sm btn-outline-warning"
                            name="submitAction"
                            value="equiEdit{{equiLink.id}}">
                            <i class="icon-pencil"></i> edit
                    </button>
                </td>

                <td class="td-width-12 text-center">
                    <button type="submit" class="btn btn-sm btn-outline-danger"
                            name="submitAction"
                            value="equiDel{{equiLink.id}}">
                            <i class="icon-pencil"></i> remove
                    </button>
                </td>

            </tr>
        {% else %}
            <tr>
                <td colspan="5" class="text-center">No equipment set</td>
            </tr>
        {% endfor %}
        </tbody>
    </table>



    <div class="form-horizontal">
        <div class="col-sm-offset-2 col-sm-10">

            <div class="col-sm-offset-2 col-sm-10 text-center mt-4">
                <h3>Equipment Form:</h3>
            </div>

            {# hidden id if edit-mode: #}
            {{ form.render("volShEquLnkId") }}

            <div class="form-group row mt-4">
                <label for="equipment" class="col-sm-2 col-form-label">Equipment :</label>
                <div class="col-sm-offset-2 col-sm-10">
                    {{ form.render("equipment") }}
                </div>
            </div>

            <div class="form-group row mt-4">
                <label for="equipShortDesc" class="col-sm-2 col-form-label">Short Desc.:</label>
                <div class="col-sm-offset-2 col-sm-10">
                    {{ form.render("equipShortDesc") }}
                </div>
            </div>

            <div class="form-group row mt-4">
                <label for="equipNeedCount" class="col-sm-2 col-form-label">Needed :</label>
                <div class="col-sm-offset-2 col-sm-10">
                    {{ form.render("equipNeedCount") }}
                </div>
            </div>

            <div class="form-group row mt-4">
                <div class="col-sm-2 col-form-label"></div>
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary"
                                        name="submitAction" value="saveEquipDefinition">Save Equipment</button>
                </div>
            </div>
        </div>
    </div>


{{ tabChangeList['vehicles'] }}


todo: vehicles


{{ endAllTabs }}

{% endblock %}
