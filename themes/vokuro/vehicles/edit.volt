<div class="row">
    <nav>
        <ul class="pager">
            <li class="previous">{{ link_to("vehicles", "Zurück", 'class': 'btn btn-outline-primary btn-sm') }}</li>
        </ul>
    </nav>
</div>

<div class="page-header">
    <h1>vehicles bearbeiten</h1>
</div>

{{ content() }}

<form action="vehicles/save" class="form-horizontal" method="post">
    <div class="form-group">
    <label for="fieldCreateTime" class="col-sm-2 control-label">Create Of Time</label>
    <div class="col-sm-10">
        {{ text_field("create_time", "size" : 30, "class" : "form-control", "id" : "fieldCreateTime") }}
    </div>
</div>

<div class="form-group">
    <label for="fieldUpdateTime" class="col-sm-2 control-label">Update Of Time</label>
    <div class="col-sm-10">
        {{ text_field("update_time", "size" : 30, "class" : "form-control", "id" : "fieldUpdateTime") }}
    </div>
</div>

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


    {{ hidden_field("id") }}

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            {{ submit_button('Send', 'class': 'btn btn-default') }}
        </div>
    </div>
</form>
