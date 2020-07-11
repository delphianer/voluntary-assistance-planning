<h1 class="mt-3">Search operationshifts</h1>

<div class="btn-group mb-5" role="group">
    {{ link_to(url("operationshifts/new"), "Create operationshifts", 'class': 'btn btn-primary') }}
</div>

{{ content() }}

{{ flash.output() }}

<form action="{{ url("operationshifts/search") }}" class="form-horizontal" method="get">
    <div class="form-group">
    <label for="fieldId" class="col-sm-2 control-label">Id</label>
    <div class="col-sm-10">
        {{ text_field("id", "type" : "numeric", "class" : "form-control", "id" : "fieldId") }}
    </div>
</div>

<div class="form-group">
    <label for="fieldOperationid" class="col-sm-2 control-label">OperationId</label>
    <div class="col-sm-10">
        {{ text_field("operationId", "type" : "numeric", "class" : "form-control", "id" : "fieldOperationid") }}
    </div>
</div>

<div class="form-group">
    <label for="fieldLocationid" class="col-sm-2 control-label">LocationId</label>
    <div class="col-sm-10">
        {{ text_field("locationId", "type" : "numeric", "class" : "form-control", "id" : "fieldLocationid") }}
    </div>
</div>

<div class="form-group">
    <label for="fieldCreateTime" class="col-sm-2 control-label">Create Of Time</label>
    <div class="col-sm-10">
        {{ text_field("create_time", "size" : 30, "class" : "form-control", "id" : "fieldCreateTime") }}
    </div>
</div>

<div class="form-group">
    <label for="fieldCreateUserid" class="col-sm-2 control-label">Create Of UserId</label>
    <div class="col-sm-10">
        {{ text_field("create_userId", "type" : "numeric", "class" : "form-control", "id" : "fieldCreateUserid") }}
    </div>
</div>

<div class="form-group">
    <label for="fieldUpdateTime" class="col-sm-2 control-label">Update Of Time</label>
    <div class="col-sm-10">
        {{ text_field("update_time", "size" : 30, "class" : "form-control", "id" : "fieldUpdateTime") }}
    </div>
</div>

<div class="form-group">
    <label for="fieldUpdateUserid" class="col-sm-2 control-label">Update Of UserId</label>
    <div class="col-sm-10">
        {{ text_field("update_userId", "type" : "numeric", "class" : "form-control", "id" : "fieldUpdateUserid") }}
    </div>
</div>

<div class="form-group">
    <label for="fieldShortdescription" class="col-sm-2 control-label">ShortDescription</label>
    <div class="col-sm-10">
        {{ text_field("shortDescription", "size" : 30, "class" : "form-control", "id" : "fieldShortdescription") }}
    </div>
</div>

<div class="form-group">
    <label for="fieldLongdescription" class="col-sm-2 control-label">LongDescription</label>
    <div class="col-sm-10">
        {{ text_field("longDescription", "size" : 30, "class" : "form-control", "id" : "fieldLongdescription") }}
    </div>
</div>

<div class="form-group">
    <label for="fieldStart" class="col-sm-2 control-label">Start</label>
    <div class="col-sm-10">
        {{ text_field("start", "size" : 30, "class" : "form-control", "id" : "fieldStart") }}
    </div>
</div>

<div class="form-group">
    <label for="fieldEnd" class="col-sm-2 control-label">End</label>
    <div class="col-sm-10">
        {{ text_field("end", "size" : 30, "class" : "form-control", "id" : "fieldEnd") }}
    </div>
</div>


    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            {{ submit_button('Search', 'class': 'btn btn-primary') }}
        </div>
    </div>
</form>
