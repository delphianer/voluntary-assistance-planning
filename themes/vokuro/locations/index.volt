<h1 class="mt-3">Search locations</h1>

<div class="btn-group mb-5" role="group">
    {{ link_to(url("locations/new"), "Create locations", 'class': 'btn btn-primary') }}
</div>

{{ content() }}

{{ flash.output() }}

<form action="{{ url("locations/search") }}" class="form-horizontal" method="get">
    <div class="form-group">
    <label for="fieldId" class="col-sm-2 control-label">Id</label>
    <div class="col-sm-10">
        {{ text_field("id", "type" : "numeric", "class" : "form-control", "id" : "fieldId") }}
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
    <label for="fieldStreet" class="col-sm-2 control-label">Street</label>
    <div class="col-sm-10">
        {{ text_field("street", "size" : 30, "class" : "form-control", "id" : "fieldStreet") }}
    </div>
</div>

<div class="form-group">
    <label for="fieldAdditionaltext" class="col-sm-2 control-label">AdditionalText</label>
    <div class="col-sm-10">
        {{ text_field("additionalText", "size" : 30, "class" : "form-control", "id" : "fieldAdditionaltext") }}
    </div>
</div>

<div class="form-group">
    <label for="fieldPostalcode" class="col-sm-2 control-label">Postalcode</label>
    <div class="col-sm-10">
        {{ text_field("postalcode", "size" : 30, "class" : "form-control", "id" : "fieldPostalcode") }}
    </div>
</div>

<div class="form-group">
    <label for="fieldCity" class="col-sm-2 control-label">City</label>
    <div class="col-sm-10">
        {{ text_field("city", "size" : 30, "class" : "form-control", "id" : "fieldCity") }}
    </div>
</div>

<div class="form-group">
    <label for="fieldCountry" class="col-sm-2 control-label">Country</label>
    <div class="col-sm-10">
        {{ text_field("country", "size" : 30, "class" : "form-control", "id" : "fieldCountry") }}
    </div>
</div>


    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            {{ submit_button('Search', 'class': 'btn btn-primary') }}
        </div>
    </div>
</form>
