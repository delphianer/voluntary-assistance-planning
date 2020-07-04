<h1 class="mt-3">Create volunteers</h1>

<div class="btn-group mb-5" role="group">
    {{ link_to(url("volunteers"), "&larr; Go Back", "class": "btn btn-warning") }}
</div>

{{ flash.output() }}

<form action="{{ url("volunteers/create") }}" class="form-horizontal" method="post">

<div class="form-group">
    <label for="fieldFirstname" class="col-sm-2 control-label">FirstName</label>
    <div class="col-sm-10">
        {{ form.render('firstName', ['class': 'form-control', 'placeholder': 'FirstName']) }}
    </div>
</div>

<div class="form-group">
    <label for="fieldLastname" class="col-sm-2 control-label">LastName</label>
    <div class="col-sm-10">
        {{ form.render('lastName', ['class': 'form-control', 'placeholder': 'LastName']) }}
    </div>
</div>

<div class="form-group">
    <label for="fieldUserid" class="col-sm-2 control-label">UserId</label>
    <div class="col-sm-10">
        {{ form.render('userId', ['class': 'form-control', 'placeholder': 'System User']) }}
    </div>
</div>

<div class="form-group">
    <label for="fieldDepartmentid" class="col-sm-2 control-label">Department</label>
    <div class="col-sm-10">
        {{ form.render('departmentId', ['class': 'form-control', 'placeholder': 'Department']) }}
    </div>
</div>



    {{ submit_button("Save", "class": "btn btn-success") }}
</form>
