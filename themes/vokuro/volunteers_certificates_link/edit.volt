<h1 class="mt-3">Edit volunteers_certificates_link</h1>

<div class="btn-group mb-5" role="group">
    {{ link_to(url("volunteers_certificates_link"), "&larr; Go Back", "class": "btn btn-warning") }}
</div>

{{ content() }}

{{ flash.output() }}


<form class="form-horizontal" method="post">

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
    <label for="fieldVolunteersid" class="col-sm-2 control-label">VolunteersId</label>
    <div class="col-sm-10">
        {{ text_field("volunteersId", "type" : "numeric", "class" : "form-control", "id" : "fieldVolunteersid") }}
    </div>
</div>

<div class="form-group">
    <label for="fieldCertificatesid" class="col-sm-2 control-label">CertificatesId</label>
    <div class="col-sm-10">
        {{ text_field("certificatesId", "type" : "numeric", "class" : "form-control", "id" : "fieldCertificatesid") }}
    </div>
</div>

<div class="form-group">
    <label for="fieldValiduntil" class="col-sm-2 control-label">ValidUntil</label>
    <div class="col-sm-10">
        {{ text_field("validUntil", "type" : "date", "class" : "form-control", "id" : "fieldValiduntil") }}
    </div>
</div>



    {{ hidden_field("id") }}

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            {{ submit_button('Save', 'class': 'btn btn-big btn-success') }}
        </div>
    </div>
</form>
