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

