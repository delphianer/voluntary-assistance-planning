<h1 class="mt-3">Search departments</h1>

<div class="btn-group mb-5" role="group">
    {{ link_to(url("departments/new"), "Create departments", 'class': 'btn btn-primary') }}
</div>

{{ content() }}

{{ flash.output() }}

<form action="{{ url("departments/search") }}" class="form-horizontal" method="get">
    <div class="form-group">
    <label for="fieldId" class="col-sm-2 control-label">Id</label>
    <div class="col-sm-10">
        {{ text_field("id", "type" : "numeric", "class" : "form-control", "id" : "fieldId") }}
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
        <div class="col-sm-offset-2 col-sm-10">
            {{ submit_button('Search', 'class': 'btn btn-primary') }}
        </div>
    </div>
</form>
