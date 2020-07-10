<h1 class="mt-3">Edit vehicles</h1>

<div class="btn-group mb-5" role="group">
    {{ link_to(url("vehicles"), "&larr; Go Back", "class": "btn btn-warning") }}
</div>

{{ content() }}

{{ flash.output() }}


<form action="{{ url(dispatcher.getControllerName() ~ "/save") }}" class="form-horizontal" method="post">

<div class="form-group">
    <label for="fieldLabel" class="col-sm-2 control-label">Label</label>
    <div class="col-sm-10">
        {{ text_field("label", "size" : 30, "class" : "form-control", "id" : "fieldLabel") }}
    </div>
</div>

<div class="form-group">
    <label for="fieldDescription" class="col-sm-2 control-label">Description</label>
    <div class="col-sm-10">
        {{ text_field("description", "size" : 30, "class" : "form-control", "id" : "fieldDescription") }}
    </div>
</div>

<div class="form-group">
    <label for="fieldTechnicalinspection" class="col-sm-2 control-label">TechnicalInspection</label>
    <div class="col-sm-10">
        {{ text_field("technicalInspection", "type" : "date", "class" : "form-control", "id" : "fieldTechnicalinspection") }}
    </div>
</div>

<div class="form-group">
    <label for="fieldSeatcount" class="col-sm-2 control-label">SeatCount</label>
    <div class="col-sm-10">
        {{ text_field("seatCount", "type" : "numeric", "class" : "form-control", "id" : "fieldSeatcount") }}
    </div>
</div>

<div class="form-group">
    <label for="fieldIsambulance" class="col-sm-2 control-label">IsAmbulance</label>
    <div class="col-sm-10">
        {{ text_field("isAmbulance", "size" : 30, "class" : "form-control", "id" : "fieldIsambulance") }}
    </div>
</div>

<div class="form-group">
    <label for="fieldHasflashinglights" class="col-sm-2 control-label">HasFlashingLights</label>
    <div class="col-sm-10">
        {{ text_field("hasFlashingLights", "size" : 30, "class" : "form-control", "id" : "fieldHasflashinglights") }}
    </div>
</div>

<div class="form-group">
    <label for="fieldHasradiocom" class="col-sm-2 control-label">HasRadioCom</label>
    <div class="col-sm-10">
        {{ text_field("hasRadioCom", "size" : 30, "class" : "form-control", "id" : "fieldHasradiocom") }}
    </div>
</div>

<div class="form-group">
    <label for="fieldHasdigitalradiocom" class="col-sm-2 control-label">HasDigitalRadioCom</label>
    <div class="col-sm-10">
        {{ text_field("hasDigitalRadioCom", "size" : 30, "class" : "form-control", "id" : "fieldHasdigitalradiocom") }}
    </div>
</div>



    {{ hidden_field("id") }}

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            {{ submit_button('Save', 'class': 'btn btn-big btn-success') }}
        </div>
    </div>
</form>
