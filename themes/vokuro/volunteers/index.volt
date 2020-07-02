<h1 class="mt-3">Search volunteers</h1>

<div class="btn-group mb-5" role="group">
    {{ link_to(url("volunteers/new"), "Create volunteers", 'class': 'btn btn-primary') }}
</div>

{{ content() }}

{{ flash.output() }}

<form action="{{ url("volunteers/search") }}" class="form-horizontal" method="get">
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
    <label for="fieldFirstname" class="col-sm-2 control-label">FirstName</label>
    <div class="col-sm-10">
        {{ text_field("firstName", "size" : 30, "class" : "form-control", "id" : "fieldFirstname") }}
    </div>
</div>

<div class="form-group">
    <label for="fieldLastname" class="col-sm-2 control-label">LastName</label>
    <div class="col-sm-10">
        {{ text_field("lastName", "size" : 30, "class" : "form-control", "id" : "fieldLastname") }}
    </div>
</div>

<div class="form-group">
    <label for="fieldUserid" class="col-sm-2 control-label">UserId</label>
    <div class="col-sm-10">
        {{ text_field("userId", "type" : "numeric", "class" : "form-control", "id" : "fieldUserid") }}
    </div>
</div>

<div class="form-group">
    <label for="fieldDepartmentid" class="col-sm-2 control-label">DepartmentId</label>
    <div class="col-sm-10">
        {{ text_field("departmentId", "type" : "numeric", "class" : "form-control", "id" : "fieldDepartmentid") }}
    </div>
</div>


    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            {{ submit_button('Search', 'class': 'btn btn-primary') }}
        </div>
    </div>
</form>
