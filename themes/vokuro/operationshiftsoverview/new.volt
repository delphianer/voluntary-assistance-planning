<h1 class="mt-3">Operation Shifts Overview</h1>

<div class="btn-group mb-5" role="group">
    {{ link_to(url(origin), "&larr; Go Back", "class": "btn btn-warning") }}
</div>


<header class="jumbotron" id="overview">
    <div class="row">
        <div class="col font-weight-bold">
            Operation:
        </div>
        <div class="col">
            {{ operation.shortDescription }}
        </div>
    </div>
</header>

    {#---------- header definition -------------#}

    {% set aclEditOperationshifts = (userRole is defined and acl.isAllowed( userRole, "operationshifts", "edit")) %}
    {% set editLabel = "" %}
    {% if aclEditOperationshifts %}
        {% set editLabel = "Edit" %}
    {% endif %}

    {% set headerData = [
            ['title' : 'Label', 'class':'text-center'],
            ['title' : 'Start', 'class':'text-center'],
            ['title' : 'End', 'class':'text-center'],
            ['title' : 'Department', 'class':'text-center'],
            ['title' : 'Needs', 'class':'text-center'],
            ['title' : 'Committed', 'class':'text-center'],
            ['title' : 'Action', 'class':'text-center'],
            ['title' : editLabel, 'class':'text-center']
        ] %}

    {#---------- table body definition ---------------#}

    {% set bodyData = [] %}

    {% for shift in operationShiftsWithCommitmentList %}
        {% set rowData = [] %}

        {% do arrayPush(rowData , [ 'data' : shift['event_label']] ) %}
        {% do arrayPush(rowData , [ 'data' : shift['event_start']] ) %}
        {% do arrayPush(rowData , [ 'data' : shift['event_end']] ) %}
        {% do arrayPush(rowData , [ 'data' : shift['department_label']] ) %}
        {% do arrayPush(rowData , [ 'data' : shift['event_needed']] ) %}
        {% do arrayPush(rowData , [ 'data' : shift['event_volunteersCommitted']] ) %}

        {% set availableActions = '' %}
        {% if shift['event_IHaveCommitted'] != 0 %}
            {% set availableActions = link_to( url("opshdeplvolunteerslink/edit?origin=operationshiftsoverview&opshid=" ~ shift['shift_id']~ '&dnid=' ~ shift['department_need_id']), '<i class="icon-pencil"></i> edit my entry', "class": "btn btn-sm btn-outline-warnig") %}
            {% set availableActions = availableActions ~ link_to( url("opshdeplvolunteerslink/delete?origin=operationshiftsoverview&opshid=" ~ shift['shift_id']~ '&dnid=' ~ shift['department_need_id']), '<i class="icon-pencil"></i> cancel commitment', "class": "btn btn-sm btn-outline-danger") %}
        {% else %}
            {% set availableActions = link_to( url("opshdeplvolunteerslink/new?origin=operationshiftsoverview&opshid=" ~ shift['shift_id'] ~ '&dnid=' ~ shift['department_need_id']), '<i class="icon-check"></i> Commit', "class": "btn btn-sm btn-outline-primary") %}
        {% endif %}
        {% do arrayPush(rowData , [ 'data' : availableActions, 'class' : 'text-center'] ) %}

        {% if aclEditOperationshifts %}
            {% do arrayPush(rowData , [ 'data' : link_to( url("operationshifts/edit/") ~ shift['shift_id'], '<i class="icon-pencil"></i> Edit', "class": "btn btn-sm btn-outline-warning"), 'class' : 'text-center'] ) %}
        {% endif %}

        {% do arrayPush(bodyData , rowData) %}

    {% else %}
        {% set nothingFound = 'No future events found' %}
    {% endfor %}

    {% include 'layouts/includes/dataasdivs.volt' %}

    {#---------- end --------#}





{#
        {% if event['event_IHaveCommitted'] != 0 %}
            {% set availableActions = link_to( url("opshdeplvolunteerslink/edit?origin=landingpage&opid=" ~ event['event_id']), '<i class="icon-pencil"></i> edit my entry', "class": "btn btn-sm btn-outline-warnig") %}
            {% set availableActions = availableActions ~ link_to( url("operationshiftsoverview/delete?origin=landingpage&opid=" ~ event['event_id']), '<i class="icon-pencil"></i> cancel commitment', "class": "btn btn-sm btn-outline-danger") %}
        {% else %}
            {% set availableActions = link_to( url("opshdeplvolunteerslink/new?origin=landingpage&opid=" ~ event['event_id']), '<i class="icon-pencil"></i> Commit', "class": "btn btn-sm btn-outline-primary") %}
        {% endif %}

#}
