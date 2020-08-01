
{% if operationShift is defined %}
<div class="row p-4 bg-light">
    <div class="col">
        <div class="row p-4 bg-light">
            <div class="col">
                <h3>
                Operation:   <b>{{ operationShift.Operations.shortDescription }} </b>
                </h3>
            </div>
        </div>
        <div class="row bg-light">
            <div class="col p-3 border bg-white rounded">
                {{ operationShift.Operations.longDescription }}
            </div>
        </div>
    </div>
</div>
<div class="row p-4 bg-light">
    <div class="col">
        <div class="row p-4 bg-light text-center">
            <div class="col">
                <h4>
        {{ operationShift.shortDescription }} - Details:
                </h4>
            </div>
        </div>

        <div class="row p-4 mb-4 bg-light  text-center">
            <div class="col-sm-2 text-right">
                start:
            </div>
            <div class="col-sm-4  text-center">
                <b>{{ operationShift.start }}</b>
            </div>
            <div class="col-sm-2 text-right">
                end:
            </div>
            <div class="col-sm-4 text-center">
                <b>{{ operationShift.end }}</b>
            </div>
        </div>
        <div class="row p-4 bg-light">
            <div class="col font-weight-bold text-center">
                <h5>
                Location:
                </h5>
            </div>
            <div class="col  font-weight-bold text-center">
                <h5>
                {{ operationShift.Locations.label }}
                </h5>
            </div>
        </div>

    {% if operationShift.longDescription is not empty %}
        <div class="row p-4 bg-light">
            <div class="col border bg-white rounded">
                {{ operationShift.longDescription }}
            </div>
        </div>
    {% endif %}
    {% if operationShift.OperationshiftsEquipmentLink is defined %}
        <div class="row p-3 bg-light">
            <div class="col font-weight-bold text-center">
                Equipment:
            </div>
        </div>
        {% for equipmentLink in operationShift.OperationshiftsEquipmentLink %}
        <div class="row bg-white m-1 p-2">
            <div class="col">
                {{ equipmentLink.Equipment.label }}
            </div>
            <div class="col">
                {{ equipmentLink.shortDescription }}
            </div>
            <div class="col">
               {{ equipmentLink.needCount }} x
            </div>
        </div>
        {% endfor %}
    {% endif %}
    {% if operationShift.OperationshiftsVehiclesLink is defined %}
        <div class="row p-3 bg-light">
            <div class="col font-weight-bold text-center">
                Vehicles:
            </div>
        </div>
        {% for vehicleLink in operationShift.OperationshiftsVehiclesLink %}
        <div class="row bg-white m-1 p-2">
            <div class="col font-weight-bold text-center">
                {{ vehicleLink.Vehicles.label }}
            </div>
            <div class="col font-italic font-weight-bold">
                {{ vehicleLink.shortDescription }}
            </div>
        </div>
        <div class="row bg-white m-1">
            <div class="col">
                <b>next inspection:</b><br />{{ vehicleLink.Vehicles.technicalInspection }}
            </div>
            <div class="col">
                <b>seats:</b><br />{{ vehicleLink.Vehicles.seatCount }}
            </div>
            <div class="col">

                {% set propText = '' %}
                {% set comma = '' %}
                {% if vehicleLink.Vehicles.isAmbulance == 'Y' %}
                    {% set propText = propText ~ 'Is Ambulance' %}
                    {% set comma = ', ' %}
                {% endif %}

                {% if vehicleLink.Vehicles.hasFlashingLights == 'Y' %}
                    {% set propText = propText ~ comma ~ 'Has Flashing Lights' %}
                    {% set comma = ', ' %}
                {% endif %}

                {% if vehicleLink.Vehicles.hasRadioCom == 'Y' %}
                    {% set propText = propText ~ comma ~ 'Radio Communication' %}
                    {% set comma = ', ' %}
                {% endif %}

                {% if vehicleLink.Vehicles.hasDigitalRadioCom == 'Y' %}
                    {% set propText = propText ~ comma ~ 'Digital Radio Communication' %}
                {% endif %}

                {% if propText is not empty %}
                <b>Fix Properties:</b><br />{{ propText }}
                {% else %}
                No properties set
                {% endif %}

            </div>
        </div>
        <div class="row bg-white m-1">
            <div class="col">
                Description: {{ vehicleLink.Vehicles.description }}
            </div>
        </div>
        {% endfor %}
    {% endif %}
    </div>
</div>
{% endif %}

<div class="form-group mt-5">
    <label for="shortDescription" class="col-sm-2 control-label">short description</label>
    <div class="col-sm-10">
        {{ form.render('shortDescription') }}
    </div>
</div>

<div class="form-group">
    <label for="fieldLongdescription" class="col-sm-2 control-label">long description</label>
    <div class="col-sm-10">
        {{ form.render('longDescription') }}
    </div>
</div>

<div class="form-group">
    <label for="opDepNeedId" class="col-sm-2 control-label">Needs of Department</label>
    <div class="col-sm-10">
        {{ form.render('opDepNeedId') }}
        {{ form.render('opDepNeedIdDisabled') }}

    </div>
</div>

<div class="form-group">
    <label for="fieldEndid" class="col-sm-2 control-label">Volunteer</label>
    <div class="col-sm-10">
        {{ form.render('volunteersId') }}
        {{ form.render('volunteersIdDisabled') }}
    </div>
</div>


<div class="form-group">
    <label for="fieldEndid" class="col-sm-2 control-label">Role</label>
    <div class="col-sm-10">
        {{ form.render('volCurrentMaximumCertRank') }}
    </div>
</div>

