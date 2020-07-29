<h2 class="mt-5">Landing Page</h2>

<header class="jumbotron" id="overview">
    <div class="row">
        <div class="col font-weight-bold">
            Hello {{ authName }}
        </div>
        <div class="col">
            Your System-Role: <div class="font-weight-bold">{{ userRole }}</div>
        </div>
        {% if volunteer is defined %}
        <div class="col">
            Volunteer-Name:
            <div class="font-weight-bold">{{ volunteer.firstName ~ ' ' ~ volunteer.lastName }}</div>
        </div>
        <div class="col">
            Department:
             <div class="font-weight-bold">{{ volunteer.Department.label }}</div>
        </div>
        {% endif %}
    </div>
    {% if volunteer is defined %}
    <hr class="my-4">
    <div class="row ">
        <div class="col text-center">
            Todo: last Event on
        </div>
        <div class="col text-center">
            Todo: next Event on
        </div>
    </div>
    {% endif %}
    <hr class="my-4">
    <div class="row">
        <div class="col is-3">
            Appointments
        </div>
        <div class="col is-3">
            Next week: {{ appointmentsNextWeekCount }}
        </div>
        <div class="col is-3">
            Next 30 days: {{ appointmentsNext30DaysCount }}
        </div>
        <div class="col is-3">
            Done: {{ appointmentsDoneCount }}
        </div>
    </div>
    <hr class="my-4">
    <div class="row">
        <div class="col is-3">
            Operations
        </div>
        <div class="col is-3">
            Next week: {{ operationsNextWeekCount }}
        </div>
        <div class="col is-3">
            Next 30 days: {{ operationsNext30DaysCount }}
        </div>
        <div class="col is-3">
            Done: {{ operationsDoneCount }}
        </div>
    </div>
</header>

    <div class="row m-5">
        <div class="col text-center">
            <h3 class="text-center">
                next operations
            </h3>
        </div>
    </div>



    {#---------- header definition -------------#}

    {% set aclEditOperation = (userRole is defined and acl.isAllowed( userRole, "operations", "edit")) %}
    {% set editLabel = "" %}
    {% if aclEditOperation %}
        {% set editLabel = "Edit" %}
    {% endif %}

    {% set headerData = [
            ['title' : 'Label', 'class':'text-center'],
            ['title' : 'Start', 'class':'text-center'],
            ['title' : 'End', 'class':'text-center'],
            ['title' : 'Needs', 'class':'text-center'],
            ['title' : 'Committed', 'class':'text-center'],
            ['title' : 'Action', 'class':'text-center'],
            ['title' : editLabel, 'class':'text-center']
        ] %}

    {#---------- table body definition ---------------#}

    {% set bodyData = [] %}

    {% for event in nextOperations %}
        {% set rowData = [] %}
        {% set aclEditController = '' %}

        {% set aclEditController = event['event_kind'] %}
        {% set aclEditRow = (userRole is defined and acl.isAllowed( userRole, event['event_kind'], "edit")) %}

        {% do arrayPush(rowData , [ 'data' : event['event_label']] ) %}
        {% do arrayPush(rowData , [ 'data' : event['event_starting']] ) %}
        {% do arrayPush(rowData , [ 'data' : event['event_ending']] ) %}
        {% do arrayPush(rowData , [ 'data' : event['event_volunteersNeeded']] ) %}
        {% do arrayPush(rowData , [ 'data' : event['event_volunteersCommitted']] ) %}

        {% set availableActions = '' %}
        {% if event['event_IHaveCommitted'] != 0 %}
            {% set availableActions = link_to( url("opshdeplvolunteerslink/edit/") ~ event['event_IHaveCommitted'], '<i class="icon-pencil"></i> Edit', "class": "btn btn-sm btn-outline-warnig") %}
            {% set availableActions = availableActions ~ link_to( url("opshdeplvolunteerslink/delete/") ~ event['event_IHaveCommitted'], '<i class="icon-pencil"></i> Edit', "class": "btn btn-sm btn-outline-danger") %}
        {% else %}
            {% set availableActions = link_to( url("opshdeplvolunteerslink/new/") ~ event['event_id'], '<i class="icon-pencil"></i> Commit', "class": "btn btn-sm btn-outline-primary") %}
        {% endif %}
        {% do arrayPush(rowData , [ 'data' : availableActions, 'class' : 'text-center'] ) %}

        {% if aclEditRow %}
        {% do arrayPush(rowData , [ 'data' : link_to( url(aclEditController ~ "/edit/") ~ event['event_id'], '<i class="icon-pencil"></i> Edit', "class": "btn btn-sm btn-outline-warning"), 'class' : 'text-center'] ) %}
        {% endif %}

        {% do arrayPush(bodyData , rowData) %}

    {% else %}
        {% set nothingFound = 'No future events found' %}
    {% endfor %}

    {% include 'layouts/includes/dataasdivs.volt' %}

    {#---------- end --------#}




    <hr />

    <div class="row m-5">
        <div class="col text-center">
            <h3 class="text-center">
                upcomming events
            </h3>
        </div>
    </div>
    {% set outputEvents = nextEvents %}

    {% include 'moduleincludes/simpleEventList.volt' %}

    <div class="row m-5">
        <div class="col is-3 text-center font-weight-bold mt-4">
            <h3 class="text-center">
                last 5 events
            </h3>
        </div>
    </div>
    {% set outputEvents = lastEvents %}

    {% include 'moduleincludes/simpleEventList.volt' %}

