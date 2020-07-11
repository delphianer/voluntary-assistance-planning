<h1 class="mt-3">Edit appointments</h1>

<div class="btn-group mb-5" role="group">
    {{ link_to(url("appointments"), "&larr; Go Back", "class": "btn btn-warning") }}
</div>

{{ content() }}

{{ flash.output() }}


<form  action="{{ url("appointments/save") }}" class="form-horizontal" method="post">

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
    <label for="fieldLocationid" class="col-sm-2 control-label">LocationId</label>
    <div class="col-sm-10">
        {{ text_field("locationId", "type" : "numeric", "class" : "form-control", "id" : "fieldLocationid") }}
    </div>
</div>

<div class="form-group">
    <label for="fieldMaindepartmentid" class="col-sm-2 control-label">MainDepartmentId</label>
    <div class="col-sm-10">
        {{ text_field("mainDepartmentId", "type" : "numeric", "class" : "form-control", "id" : "fieldMaindepartmentid") }}
    </div>
</div>

<div class="form-group">
    <label for="fieldClientid" class="col-sm-2 control-label">ClientId</label>
    <div class="col-sm-10">
        {{ text_field("clientId", "type" : "numeric", "class" : "form-control", "id" : "fieldClientid") }}
    </div>
</div>



    {{ hidden_field("id") }}

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            {{ submit_button('Save', 'class': 'btn btn-big btn-success') }}
        </div>
    </div>
</form>
