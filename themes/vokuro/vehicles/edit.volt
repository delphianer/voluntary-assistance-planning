{% extends 'layouts/inheritance/masteredit.volt' %}

{% block title %}Edit  Vehicle{% endblock %}


{% block startOfTablist %}


    {% set activeTabKey = 'basic' %}

    {% set tabs = [
        'basic' : 'Main',
        'additional' : 'Additional'
    ] %}

    {% include 'layouts/includes/tablist.volt' %}

{% endblock %}



{% block inputelements %}

{{ hidden_field("id") }}

{% include 'vehicles/common_input.volt' %}

{% endblock %}



{% block endOfTablist %}


{{ tabChangeList['additional'] }}


    {#---------- start table.volt insert part --------#}

    {#---------- basic defines for acl-check ---------#}

    {% set isAllowedToEdit = (userRole is defined and acl.isAllowed( userRole, 'volunteerscertificateslink', "edit")) %}
    {% set isAllowedToDelete = (userRole is defined and acl.isAllowed( userRole, 'volunteerscertificateslink', "delete")) %}


    {#---------- table header definition -------------#}

    {% set tableHeadingData = [
            ['title' : 'Property', 'class':'text-center'],
            ['title' : 'Value', 'class':'text-center']
        ] %}

    {% if isAllowedToEdit %}
        {% set foo = arrayPush(tableHeadingData ,  ['title' : ''] ) %}
    {% endif %}

    {% if isAllowedToDelete %}
        {% set foo = arrayPush(tableHeadingData ,  ['title' : ''] ) %}
    {% endif %}


    {#---------- table body definition ---------------#}

    {% set tableBodyData = [] %}

    {% for property in vehicle.Vehicleproperties %}

        {% set rowData = [] %}

        {% set foo = arrayPush(rowData , [ 'data' : property.label, 'class' : 'text-center'] ) %}

        {% if property.is_numeric == 'Y' %}

            {% set foo = arrayPush(rowData , [ 'data' : numberFormat(property.value_numeric), 'class' : 'text-center'] ) %}

        {% else %}

            {% set foo = arrayPush(rowData , [ 'data' : property.value_string, 'class' : 'text-center'] ) %}

        {% endif %}

        {% if isAllowedToEdit %}
            {% set buttonData = '<button type="submit" class="btn btn-sm btn-outline-warning" name="submitAction"value="edit' ~ property.id ~ '"> <i class="icon-pencil"></i> change </button>' %}
            {% set foo = arrayPush(rowData ,  [ 'data' : buttonData, 'class' : 'td-width-12 text-center'] ) %}
        {% endif %}

        {% if isAllowedToDelete %}
            {% set buttonData = '<button type="submit" class="btn btn-sm btn-outline-danger" name="submitAction"value="del' ~ property.id ~ '"> <i class="icon-pencil"></i> remove </button>' %}
            {% set foo = arrayPush(rowData ,  [ 'data' : buttonData, 'class' : 'td-width-12 text-center'] ) %}
        {% endif %}

        {% set foo = arrayPush(tableBodyData , rowData) %}

    {% else %}
        {% set tableBodyDataDefaultText = 'No certificates found' %}
    {% endfor %}


    {% include 'layouts/includes/dataastable.volt' %}

    {#---------- end table.volt insert part --------#}


    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-sm btn-primary"
                    name="submitAction" value="goToProperty">Add new property</button>
        </div>
    </div>

{{ endAllTabs }}

{% endblock %}
