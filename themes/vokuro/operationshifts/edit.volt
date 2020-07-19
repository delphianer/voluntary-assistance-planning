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
        {% set foo = arrayPush(rowData , [ 'data' : collectData.minimumCertificateRankingLabel] ) %}

        {% if isAllowedToEdit %}
            {% set buttonData = '<button type="submit" class="btn btn-sm btn-outline-warning" name="submitAction"value="depEdit' ~ collectData.id ~ '"> <i class="icon-pencil"></i> change </button>' %}
            {% set foo = arrayPush(rowData ,  [ 'data' : buttonData, 'class' : 'td-width-12 text-center'] ) %}
        {% endif %}

        {% if isAllowedToDelete %}
            {% set buttonData = '<button type="submit" class="btn btn-sm btn-outline-danger" name="submitAction"value="depDel' ~ collectData.id ~ '"> <i class="icon-remove"></i> remove </button>' %}
            {% set foo = arrayPush(rowData ,  [ 'data' : buttonData, 'class' : 'td-width-12 text-center'] ) %}
        {% endif %}

        {% set foo = arrayPush(tableBodyData , rowData) %}

    {% else %}
        {% set tableBodyDataDefaultText = 'No departments found' %}
    {% endfor %}

    {% include 'layouts/includes/dataastable.volt' %}

    {#---------- end table.volt insert part --------#}





    <div class="form-horizontal">
        <div class="col-sm-offset-2 col-sm-10">

            <div class="col-sm-offset-2 col-sm-10 text-center mt-4">
                <h3>Manpower Needed Form:</h3>
            </div>

            {# hidden id for edit-mode: #}
            {{ form.render("opShDepLnkId") }}

            <div class="form-group row mt-4">
                <label for="department" class="col-sm-2 col-form-label">Department :</label>
                <div class="col-sm-offset-2 col-sm-10">
                    {{ form.render("department") }}
                </div>
            </div>

            <div class="form-group row mt-4">
                <label for="depShortDesc" class="col-sm-2 col-form-label">Short Description:</label>
                <div class="col-sm-offset-2 col-sm-10">
                    {{ form.render("depShortDesc") }}
                </div>
            </div>

            <div class="form-group row mt-4">
                <label for="depVolNeeded" class="col-sm-2 col-form-label">Needed :</label>
                <div class="col-sm-offset-2 col-sm-10">
                    {{ form.render("depVolNeeded") }}
                </div>
            </div>

            <div class="form-group row mt-4">
                <label for="depMinCertRank" class="col-sm-2 col-form-label">Minimum Certification :</label>
                <div class="col-sm-offset-2 col-sm-10">
                    {{ form.render("depMinCertRank") }}
                </div>
            </div>

            <div class="form-group row mt-4">
                <div class="col-sm-2 col-form-label"></div>
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary"
                                        name="submitAction" value="saveDepDefinition">Save Manpower Needed</button>
                </div>
            </div>
        </div>
    </div>









{{ tabChangeList['equipment'] }}


    {#---------- start table.volt insert part --------#}

    {#---------- basic defines for acl-check ---------#}

    {% set isAllowedToEdit = (userRole is defined and acl.isAllowed( userRole, 'operationshiftsequipmentlink', "edit")) %}
    {% set isAllowedToDelete = (userRole is defined and acl.isAllowed( userRole, 'operationshiftsequipmentlink', "delete")) %}


    {#---------- table header definition -------------#}

    {% set tableHeadingData = [
            ['title' : 'Equipment'],
            ['title' : 'Short Description'],
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
            {% set buttonData = '<button type="submit" class="btn btn-sm btn-outline-warning" name="submitAction"value="equiEdit' ~ collectData.id ~ '"> <i class="icon-pencil"></i> change </button>' %}
            {% set foo = arrayPush(rowData ,  [ 'data' : buttonData, 'class' : 'td-width-12 text-center'] ) %}
        {% endif %}

        {% if isAllowedToDelete %}
            {% set buttonData = '<button type="submit" class="btn btn-sm btn-outline-danger" name="submitAction"value="equiDel' ~ collectData.id ~ '"> <i class="icon-remove"></i> remove </button>' %}
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

            {# hidden id for edit-mode: #}
            {{ form.render("opShEquLnkId") }}

            <div class="form-group row mt-4">
                <label for="equipment" class="col-sm-2 col-form-label">Equipment :</label>
                <div class="col-sm-offset-2 col-sm-10">
                    {{ form.render("equipment") }}
                </div>
            </div>

            <div class="form-group row mt-4">
                <label for="equipShortDesc" class="col-sm-2 col-form-label">Short Description:</label>
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

    {# { dump(operationshift.OperationshiftsVehiclesLink) } #}

    {% for collectData in operationshift.OperationshiftsVehiclesLink %}

        {% set rowData = [] %}

        {% set foo = arrayPush(rowData , [ 'data' : collectData.Vehicles.label] ) %}
        {% set foo = arrayPush(rowData , [ 'data' : collectData.shortDescription] ) %}

        {% if isAllowedToEdit %}
            {% set buttonData = '<button type="submit" class="btn btn-sm btn-outline-warning" name="submitAction" value="vehiEdit' ~ collectData.id ~ '"> <i class="icon-pencil"></i> change </button>' %}
            {% set foo = arrayPush(rowData ,  [ 'data' : buttonData, 'class' : 'td-width-12 text-center'] ) %}
        {% endif %}

        {% if isAllowedToDelete %}
            {% set buttonData = '<button type="submit" class="btn btn-sm btn-outline-danger" name="submitAction" value="vehiDel' ~ collectData.id ~ '"> <i class="icon-remove"></i> remove </button>' %}
            {% set foo = arrayPush(rowData ,  [ 'data' : buttonData, 'class' : 'td-width-12 text-center'] ) %}
        {% endif %}

        {% set foo = arrayPush(tableBodyData , rowData) %}

    {% else %}
        {% set tableBodyDataDefaultText = 'No vehicles found' %}
    {% endfor %}

    {% include 'layouts/includes/dataastable.volt' %}

    {#---------- end table.volt insert part --------#}



    <div class="form-horizontal">
        <div class="col-sm-offset-2 col-sm-10">

            <div class="col-sm-offset-2 col-sm-10 text-center mt-4">
                <h3>Vehicle Form:</h3>
            </div>

            {# hidden id for edit-mode: #}
            {{ form.render("opShVehLnkId") }}

            <div class="form-group row mt-4">
                <label for="equipment" class="col-sm-2 col-form-label">Vehicle :</label>
                <div class="col-sm-offset-2 col-sm-10">
                    {{ form.render("vehicle") }}
                </div>
            </div>

            <div class="form-group row mt-4">
                <label for="equipShortDesc" class="col-sm-2 col-form-label">Short Description:</label>
                <div class="col-sm-offset-2 col-sm-10">
                    {{ form.render("vehicShortDesc") }}
                </div>
            </div>

            <div class="form-group row mt-4">
                <div class="col-sm-2 col-form-label"></div>
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary"
                                        name="submitAction" value="saveVehicleDefinition">Save Vehicle</button>
                </div>
            </div>
        </div>
    </div>




{{ endAllTabs }}

{% endblock %}
