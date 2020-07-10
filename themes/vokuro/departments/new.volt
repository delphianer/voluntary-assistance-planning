<h1 class="mt-3">Create departments</h1>

<div class="btn-group mb-5" role="group">
    {{ link_to(url("departments"), "&larr; Go Back", "class": "btn btn-warning") }}
</div>

{{ flash.output() }}

<form action="{{ url("departments/create") }}" class="form-horizontal" method="post">

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



    {{ submit_button("Save", "class": "btn btn-success") }}
</form>
