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
    <div class="row m-1">
        <div class="col is-3">
            Volunteers
        </div>
        <div class="col is-3">
            {{ volunteersCount }}
        </div>
        {% if volunteersWithoutCertification > 0 %}
        <div class="col is-3 bg-danger text-white">
            without valid certification
        </div>
        <div class="col is-3 bg-danger text-white">
            {{ volunteersWithoutCertification }}
        </div>
        {% endif %}
    </div>
    <div class="row m-1">
        <div class="col is-3">
            Vehicles
        </div>
        <div class="col is-3">
           {{ vehiclesCount }}
        </div>
        {% if vehiclesInspectionAhead > 0 %}
        <div class="col is-3 bg-danger text-white">
            soon inspection
        </div>
        <div class="col is-3 bg-danger text-white">
            {{ vehiclesInspectionAhead }}
        </div>
        {% endif %}
    </div>
    <div class="row m-1">
        <div class="col is-3">
            Equipment total
        </div>
        <div class="col is-3">
            {{ equipmentCount }}
        </div>
        {% if equipmentNotOnStockCount > 0 %}
        <div class="col is-3 bg-danger text-white">
            out of Stock
        </div>
        <div class="col is-3 bg-danger text-white">
            {{ equipmentNotOnStockCount }}
        </div>
        {% endif %}
    </div>
    <div class="row m-1">
        <div class="col is-3">
            Clients
        </div>
        <div class="col is-3">
            {{ clientsCount }}
        </div>
        <div class="col is-3">
            Locations
        </div>
        <div class="col is-3">
            {{ locationsCount }}
        </div>
    </div>
</header>

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



