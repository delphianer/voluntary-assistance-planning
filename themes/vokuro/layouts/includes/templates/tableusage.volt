 {#  how?
     just go for INSERT...HERE and add some extra entries if needed
     in this example also an if-statement for col 2 is set
     use what is useful and delete the not useful part #}


    {#---------- start table.volt insert part --------#}

    {#---------- basic defines for acl-check ---------#}

    {% set isAllowedToEdit = (userRole is defined and acl.isAllowed( userRole, 'INSERT_CONTROLLER_HERE', "edit")) %}
    {% set isAllowedToDelete = (userRole is defined and acl.isAllowed( userRole, 'INSERT_CONTROLLER_HERE', "delete")) %}


    {#---------- table header definition -------------#}

    {% set tableHeadingData = [
            ['title' : 'INSERT_COL_1_TITLE_HERE', 'class':'text-center'],
            ['title' : 'INSERT_COL_2_TITLE_HERE', 'class':'text-center']
        ] %}

    {% if isAllowedToEdit %}
        {% set foo = arrayPush(tableHeadingData ,  ['title' : ''] ) %}
    {% endif %}

    {% if isAllowedToDelete %}
        {% set foo = arrayPush(tableHeadingData ,  ['title' : ''] ) %}
    {% endif %}


    {#---------- table body definition ---------------#}

    {% set tableBodyData = [] %}

    {% for collectData in INSERT_COLLECTION_OBJECT_HERE %}

        {% set rowData = [] %}

        {% set foo = arrayPush(rowData , [ 'data' : collectData.INSERT_COL_1_DATA_HERE, 'class' : 'text-center INSERT_EXTRA_CLASSES_IF_NEEDED_HERE'] ) %}

        {% if collectData.INSERT_DECISION_VAR_HERE == 'INSERT_DECISION_VALUE_HERE' %}

            {% set foo = arrayPush(rowData , [ 'data' : INSERT_COL_2_DATA_THAT_COMES_FROM_TRUE_DECISION_HERE, 'class' : 'text-center INSERT_EXTRA_CLASSES_IF_NEEDED_HERE'] ) %}

        {% else %}

            {% set foo = arrayPush(rowData , [ 'data' : INSERT_COL_2_DATA_THAT_COMES_FROM_FALSE_DECISION_HERE, 'class' : 'text-center INSERT_EXTRA_CLASSES_IF_NEEDED_HERE'] ) %}

        {% endif %}

        {% if isAllowedToEdit %}
            {% set buttonData = '<button type="submit" class="btn btn-sm btn-outline-warning" name="submitAction" value="INSERT_IDENTIFER_HEREedit' ~ collectData.id ~ '"> <i class="icon-pencil"></i> change </button>' %}
            {% set foo = arrayPush(rowData ,  [ 'data' : buttonData, 'class' : 'td-width-12 text-center'] ) %}
        {% endif %}

        {% if isAllowedToDelete %}
            {% set buttonData = '<button type="submit" class="btn btn-sm btn-outline-danger" name="submitAction" value="INSERT_IDENTIFER_HEREdel' ~ collectData.id ~ '"> <i class="icon-remove"></i> remove </button>' %}
            {% set foo = arrayPush(rowData ,  [ 'data' : buttonData, 'class' : 'td-width-12 text-center'] ) %}
        {% endif %}

        {% set foo = arrayPush(tableBodyData , rowData) %}

    {% else %}
        {% set tableBodyDataDefaultText = 'No INSERT_NOTHING_FOUND_MESSAGE_HERE found' %}
    {% endfor %}


    {% include 'layouts/includes/dataastable.volt' %}

    {#---------- end table.volt insert part --------#}
