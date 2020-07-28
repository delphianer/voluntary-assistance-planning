<h2 class="mt-5">Data Entry Overview</h2>

<header class="jumbotron" id="overview">
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
    <hr class="my-4">
    <div class="row">
        <div class="col is-3">
            Count Volunteers
        </div>
        <div class="col is-3">
            {{ volunteersCount }}
        </div>
        <div class="col is-3">
            Count Vehicles
        </div>
        <div class="col is-3">
           {{ vehiclesCount }}
        </div>
    </div>
    <div class="row">
        <div class="col is-3">
            Count Equipment total
        </div>
        <div class="col is-3">
            {{ equipmentCount }}
        </div>
        <div class="col is-3">
            Count Equipment not on Stock
        </div>
        <div class="col is-3">
            {{ equipmentNotOnStockCount }}
        </div>
    </div>
    <div class="row">
        <div class="col is-3">
            Count Clients
        </div>
        <div class="col is-3">
            {{ clientsCount }}
        </div>
        <div class="col is-3">
            Count Locations
        </div>
        <div class="col is-3">
            {{ locationsCount }}
        </div>
    </div>
</header>

    <div class="row m-2">
        <div class="col font-weight-bold">
            Event
        </div>
        <div class="col font-weight-bold">
            Label
        </div>
        <div class="col font-weight-bold">
            Start
        </div>
        <div class="col font-weight-bold">
            End
        </div>
        <div class="col font-weight-bold">
            Edit ?
        </div>
    </div>

    {% for event in nextEvents %}
    {% set aclEditRow = false %}
    {% set aclEditController = '' %}
    <div class="row">
        <div class="col is-1">
            {% if event['event_kind'] == 'op' %}
                Operation
                {% set aclEditController = 'operations' %}
                {% set aclEditRow = (userRole is defined and acl.isAllowed( userRole, "operations", "edit")) %}
            {% else %}
                Appointment
                {% set aclEditController = 'appointments' %}
                {% set aclEditRow = (userRole is defined and acl.isAllowed( userRole, "appointments", "edit")) %}
            {% endif %}
        </div>

        <div class="col is-1">
        {{ event['event_label'] }}
        </div>

        <div class="col is-1">
        {{ event['event_starting'] }}
        </div>

        <div class="col is-1">
        {{ event['event_ending'] }}
        </div>

        <div class="col is-1">
            {% if aclEditRow %}
                {{ link_to( url(aclEditController ~ "/edit/") ~ event['event_id'], '<i class="icon-pencil"></i> Edit', "class": "btn btn-sm btn-outline-warning") }}
            {% else %}
            -
            {% endif %}
        </div>

    </div>
    {% else %}
        No events found
    {% endfor %}

