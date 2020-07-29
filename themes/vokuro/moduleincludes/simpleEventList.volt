{# needs
            outputEvents comming from EventlistController -> getNextEventsSimpleFormat() or similar
            #}

    {#---------- header definition -------------#}

    {% set aclEditAppointment = (userRole is defined and acl.isAllowed( userRole, "appointments", "edit")) %}
    {% set aclEditOperation = (userRole is defined and acl.isAllowed( userRole, "operations", "edit")) %}
    {% set editLabel = "" %}
    {% if aclEditAppointment or aclEditOperation %}
        {% set editLabel = "Edit" %}
    {% endif %}

    {% set headerData = [
            ['title' : 'Event', 'class':'text-center'],
            ['title' : 'Label', 'class':'text-center'],
            ['title' : 'Start', 'class':'text-center'],
            ['title' : 'End', 'class':'text-center'],
            ['title' : editLabel, 'class':'text-center']
        ] %}

    {#---------- table body definition ---------------#}

    {% set bodyData = [] %}

    {% for event in outputEvents %}
        {% set rowData = [] %}
        {% set aclEditController = '' %}

        {% set aclEditController = event['event_kind'] %}
        {% set aclEditRow = (userRole is defined and acl.isAllowed( userRole, event['event_kind'], "edit")) %}

        {% do arrayPush(rowData , [ 'data' : ((event['event_kind'] == 'operations') ? 'Operation' : 'Appointment')] ) %}

        {% do arrayPush(rowData , [ 'data' : event['event_label']] ) %}
        {% do arrayPush(rowData , [ 'data' : event['event_starting']] ) %}
        {% do arrayPush(rowData , [ 'data' : event['event_ending']] ) %}
        {% if aclEditRow %}
        {% do arrayPush(rowData , [ 'data' : link_to( url(aclEditController ~ "/edit/") ~ event['event_id'], '<i class="icon-pencil"></i> Edit', "class": "btn btn-sm btn-outline-warning"), 'class' : 'text-center'] ) %}
        {% endif %}

        {% do arrayPush(bodyData , rowData) %}

    {% else %}
        {% set nothingFound = 'No future events found' %}
    {% endfor %}

    {% include 'layouts/includes/dataasdivs.volt' %}

    {#---------- end --------#}
