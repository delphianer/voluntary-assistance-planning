<h1 class="mt-3">Create operations</h1>

<div class="btn-group mb-5" role="group">
    {{ link_to(url("operations"), "&larr; Go Back", "class": "btn btn-warning") }}
</div>

{{ flash.output() }}

<form action="{{ url("operations/create") }}" class="form-horizontal" method="post">
    <div class="form-group">
    <label for="fieldClientid" class="col-sm-2 control-label">ClientId</label>
    <div class="col-sm-10">
        {{ text_field("clientId", "type" : "numeric", "class" : "form-control", "id" : "fieldClientid") }}
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
    <label for="fieldMaindepartmentid" class="col-sm-2 control-label">MainDepartmentId</label>
    <div class="col-sm-10">
        {{ text_field("mainDepartmentId", "type" : "numeric", "class" : "form-control", "id" : "fieldMaindepartmentid") }}
    </div>
</div>



    {{ submit_button("Save", "class": "btn btn-success") }}
</form>
