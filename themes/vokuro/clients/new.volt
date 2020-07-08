<h1 class="mt-3">Create clients</h1>

<div class="btn-group mb-5" role="group">
    {{ link_to(url("clients"), "&larr; Go Back", "class": "btn btn-warning") }}
</div>

{{ flash.output() }}

<form action="{{ url("clients/create") }}" class="form-horizontal" method="post">

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
    <label for="fieldContactinformation" class="col-sm-2 control-label">ContactInformation</label>
    <div class="col-sm-10">
        {{ text_field("contactInformation", "size" : 30, "class" : "form-control", "id" : "fieldContactinformation") }}
    </div>
</div>



    {{ submit_button("Save", "class": "btn btn-success") }}
</form>
