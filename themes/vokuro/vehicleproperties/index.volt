<div class="page-header">
    <h1>Search vehicleproperties</h1>
    <p>{{ link_to("vehicleproperties/new", "Neu: vehicleproperties", 'class': 'btn btn-outline-primary btn-sm') }}</p>
</div>

{{ content() }}

{{ flash.output() }}

<form action="vehicleproperties/search" class="form-horizontal" method="get">
    <div class="form-group">
    <label for="fieldId" class="col-sm-2 control-label">Id</label>
    <div class="col-sm-10">
        {{ text_field("id", "type" : "numeric", "class" : "form-control", "id" : "fieldId") }}
    </div>
</div>

<div class="form-group">
    <label for="fieldVehiclesid" class="col-sm-2 control-label">VehiclesId</label>
    <div class="col-sm-10">
        {{ text_field("vehiclesId", "type" : "numeric", "class" : "form-control", "id" : "fieldVehiclesid") }}
    </div>
</div>

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
    <label for="fieldIsNumeric" class="col-sm-2 control-label">Is Of Numeric</label>
    <div class="col-sm-10">
        {{ text_field("is_numeric", "size" : 30, "class" : "form-control", "id" : "fieldIsNumeric") }}
    </div>
</div>

<div class="form-group">
    <label for="fieldValueString" class="col-sm-2 control-label">Value Of String</label>
    <div class="col-sm-10">
        {{ text_field("value_string", "size" : 30, "class" : "form-control", "id" : "fieldValueString") }}
    </div>
</div>

<div class="form-group">
    <label for="fieldValueNumeric" class="col-sm-2 control-label">Value Of Numeric</label>
    <div class="col-sm-10">
        {{ text_field("value_numeric", "type" : "numeric", "class" : "form-control", "id" : "fieldValueNumeric") }}
    </div>
</div>


    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            {{ submit_button('Search', 'class': 'btn btn-default') }}
        </div>
    </div>
</form>