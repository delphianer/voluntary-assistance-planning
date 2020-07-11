<h1 class="mt-3">Create operationshifts_departments_link</h1>

<div class="btn-group mb-5" role="group">
    {{ link_to(url("operationshifts_departments_link"), "&larr; Go Back", "class": "btn btn-warning") }}
</div>

{{ flash.output() }}

<form action="{{ url("operationshifts_departments_link/create") }}" class="form-horizontal" method="post">
    <div class="form-group">
    <label for="fieldOperationshiftid" class="col-sm-2 control-label">OperationShiftId</label>
    <div class="col-sm-10">
        {{ text_field("operationShiftId", "type" : "numeric", "class" : "form-control", "id" : "fieldOperationshiftid") }}
    </div>
</div>

<div class="form-group">
    <label for="fieldDepartmentid" class="col-sm-2 control-label">DepartmentId</label>
    <div class="col-sm-10">
        {{ text_field("departmentId", "type" : "numeric", "class" : "form-control", "id" : "fieldDepartmentid") }}
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
    <label for="fieldNumbervolunteersneeded" class="col-sm-2 control-label">NumberVolunteersNeeded</label>
    <div class="col-sm-10">
        {{ text_field("numberVolunteersNeeded", "type" : "numeric", "class" : "form-control", "id" : "fieldNumbervolunteersneeded") }}
    </div>
</div>

<div class="form-group">
    <label for="fieldMinimumcertificateranking" class="col-sm-2 control-label">MinimumCertificateRanking</label>
    <div class="col-sm-10">
        {{ text_field("minimumCertificateRanking", "type" : "numeric", "class" : "form-control", "id" : "fieldMinimumcertificateranking") }}
    </div>
</div>



    {{ submit_button("Save", "class": "btn btn-success") }}
</form>
