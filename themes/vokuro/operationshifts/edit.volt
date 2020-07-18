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




    {#---------- start table.volt insert part --------#}

    {#---------- basic defines for acl-check ---------#}

    {% set isAllowedToEdit = (userRole is defined and acl.isAllowed( userRole, 'operationshiftsdepartmentslink', "edit")) %}
    {% set isAllowedToDelete = (userRole is defined and acl.isAllowed( userRole, 'operationshiftsdepartmentslink', "delete")) %}


    {#---------- table header definition -------------#}

    {% set tableHeadingData = [
            ['title' : 'Department'],
            ['title' : 'Short Desc'],
            ['title' : 'Helper Needed'],
            ['title' : 'Minimum Rank']
        ] %}

    {% if isAllowedToEdit %}
        {% set foo = arrayPush(tableHeadingData ,  ['title' : ''] ) %}
    {% endif %}

    {% if isAllowedToDelete %}
        {% set foo = arrayPush(tableHeadingData ,  ['title' : ''] ) %}
    {% endif %}


    {#---------- table body definition ---------------#}

    {% set tableBodyData = [] %}

    {% for collectData in operationshift.OperationshiftsDepartmentsLink %}

        {% set rowData = [] %}

        {% set foo = arrayPush(rowData , [ 'data' : collectData.Departments.label] ) %}
        {% set foo = arrayPush(rowData , [ 'data' : collectData.shortDescription] ) %}
        {% set foo = arrayPush(rowData , [ 'data' : collectData.numberVolunteersNeeded] ) %}
        {% set foo = arrayPush(rowData , [ 'data' : collectData.minimumCertificateRanking] ) %}

        {% if isAllowedToEdit %}
            {% set buttonData = '<button type="submit" class="btn btn-sm btn-outline-warning" name="submitAction"value="edit' ~ collectData.id ~ '"> <i class="icon-pencil"></i> change </button>' %}
            {% set foo = arrayPush(rowData ,  [ 'data' : buttonData, 'class' : 'td-width-12 text-center'] ) %}
        {% endif %}

        {% if isAllowedToDelete %}
            {% set buttonData = '<button type="submit" class="btn btn-sm btn-outline-danger" name="submitAction"value="del' ~ collectData.id ~ '"> <i class="icon-pencil"></i> remove </button>' %}
            {% set foo = arrayPush(rowData ,  [ 'data' : buttonData, 'class' : 'td-width-12 text-center'] ) %}
        {% endif %}

        {% set foo = arrayPush(tableBodyData , rowData) %}

    {% else %}
        {% set tableBodyDataDefaultText = 'No departments found' %}
    {% endfor %}

    {% include 'layouts/includes/dataastable.volt' %}

    {#---------- end table.volt insert part --------#}



todo: manpower


{{ tabChangeList['equipment'] }}


    {#---------- start table.volt insert part --------#}

    {#---------- basic defines for acl-check ---------#}

    {% set isAllowedToEdit = (userRole is defined and acl.isAllowed( userRole, 'operationshiftsequipmentlink', "edit")) %}
    {% set isAllowedToDelete = (userRole is defined and acl.isAllowed( userRole, 'operationshiftsequipmentlink', "delete")) %}


    {#---------- table header definition -------------#}

    {% set tableHeadingData = [
            ['title' : 'Equipment'],
            ['title' : 'Short Desc'],
            ['title' : 'Needs']
        ] %}

    {% if isAllowedToEdit %}
        {% set foo = arrayPush(tableHeadingData ,  ['title' : ''] ) %}
    {% endif %}

    {% if isAllowedToDelete %}
        {% set foo = arrayPush(tableHeadingData ,  ['title' : ''] ) %}
    {% endif %}


    {#---------- table body definition ---------------#}

    {% set tableBodyData = [] %}

    {% for collectData in operationshift.OperationshiftsEquipmentLink %}

        {% set rowData = [] %}

        {% set foo = arrayPush(rowData , [ 'data' : collectData.Equipment.label] ) %}
        {% set foo = arrayPush(rowData , [ 'data' : collectData.shortDescription] ) %}
        {% set foo = arrayPush(rowData , [ 'data' : collectData.need_count] ) %}

        {% if isAllowedToEdit %}
            {% set buttonData = '<button type="submit" class="btn btn-sm btn-outline-warning" name="submitAction"value="edit' ~ collectData.id ~ '"> <i class="icon-pencil"></i> change </button>' %}
            {% set foo = arrayPush(rowData ,  [ 'data' : buttonData, 'class' : 'td-width-12 text-center'] ) %}
        {% endif %}

        {% if isAllowedToDelete %}
            {% set buttonData = '<button type="submit" class="btn btn-sm btn-outline-danger" name="submitAction"value="del' ~ collectData.id ~ '"> <i class="icon-pencil"></i> remove </button>' %}
            {% set foo = arrayPush(rowData ,  [ 'data' : buttonData, 'class' : 'td-width-12 text-center'] ) %}
        {% endif %}

        {% set foo = arrayPush(tableBodyData , rowData) %}

    {% else %}
        {% set tableBodyDataDefaultText = 'No equipment found' %}
    {% endfor %}

    {% include 'layouts/includes/dataastable.volt' %}

    {#---------- end table.volt insert part --------#}





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


    {#---------- start table.volt insert part --------#}

    {#---------- basic defines for acl-check ---------#}

    {% set isAllowedToEdit = (userRole is defined and acl.isAllowed( userRole, 'operationshiftsvehicleslink', "edit")) %}
    {% set isAllowedToDelete = (userRole is defined and acl.isAllowed( userRole, 'operationshiftsvehicleslink', "delete")) %}


    {#---------- table header definition -------------#}

    {% set tableHeadingData = [
            ['title' : 'Vehicle'],
            ['title' : 'Short Desc']
        ] %}

    {% if isAllowedToEdit %}
        {% set foo = arrayPush(tableHeadingData ,  ['title' : ''] ) %}
    {% endif %}

    {% if isAllowedToDelete %}
        {% set foo = arrayPush(tableHeadingData ,  ['title' : ''] ) %}
    {% endif %}


    {#---------- table body definition ---------------#}

    {% set tableBodyData = [] %}

    {% for collectData in operationshift.OperationshiftsVehiclesLink %}

        {% set rowData = [] %}

        {% set foo = arrayPush(rowData , [ 'data' : collectData.Vehicles.label] ) %}
        {% set foo = arrayPush(rowData , [ 'data' : collectData.shortDescription] ) %}

        {% if isAllowedToEdit %}
            {% set buttonData = '<button type="submit" class="btn btn-sm btn-outline-warning" name="submitAction"value="edit' ~ collectData.id ~ '"> <i class="icon-pencil"></i> change </button>' %}
            {% set foo = arrayPush(rowData ,  [ 'data' : buttonData, 'class' : 'td-width-12 text-center'] ) %}
        {% endif %}

        {% if isAllowedToDelete %}
            {% set buttonData = '<button type="submit" class="btn btn-sm btn-outline-danger" name="submitAction"value="del' ~ collectData.id ~ '"> <i class="icon-pencil"></i> remove </button>' %}
            {% set foo = arrayPush(rowData ,  [ 'data' : buttonData, 'class' : 'td-width-12 text-center'] ) %}
        {% endif %}

        {% set foo = arrayPush(tableBodyData , rowData) %}

    {% else %}
        {% set tableBodyDataDefaultText = 'No vehicles found' %}
    {% endfor %}

    {% include 'layouts/includes/dataastable.volt' %}

    {#---------- end table.volt insert part --------#}

todo: vehicles


{{ endAllTabs }}

{% endblock %}
