<h1 class="mt-3">Create vehicles</h1>

<div class="btn-group mb-5" role="group">
    {{ link_to(url("vehicles"), "&larr; Go Back", "class": "btn btn-warning") }}
</div>

{{ flash.output() }}

<div class="form-group">
    <label for="fieldDescShort" class="col-sm-2 control-label">Desc Of Short</label>
    <div class="col-sm-10">
        {{ text_field("desc_short", "size" : 30, "class" : "form-control", "id" : "fieldDescShort") }}
    </div>
</div>

<div class="form-group">
    <label for="fieldDescLong" class="col-sm-2 control-label">Desc Of Long</label>
    <div class="col-sm-10">
        {{ text_field("desc_long", "size" : 30, "class" : "form-control", "id" : "fieldDescLong") }}
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



    {{ submit_button("Save", "class": "btn btn-success") }}
</form>
