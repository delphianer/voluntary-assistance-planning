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

