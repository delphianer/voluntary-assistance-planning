<h1 class="mt-3">Create locations</h1>

<div class="btn-group mb-5" role="group">
    {{ link_to(url("locations"), "&larr; Go Back", "class": "btn btn-warning") }}
</div>

{{ flash.output() }}

<form action="{{ url("locations/create") }}" class="form-horizontal" method="post">

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



    {{ submit_button("Save", "class": "btn btn-success") }}
</form>
