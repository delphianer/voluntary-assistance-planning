<h1 class="mt-3">Search volunteers_certificates_link</h1>

<div class="btn-group mb-5" role="group">
    {{ link_to(url("volunteers_certificates_link/new"), "Create volunteers_certificates_link", 'class': 'btn btn-primary') }}
</div>

{{ content() }}

{{ flash.output() }}

<form action="{{ url("volunteers_certificates_link/search") }}" class="form-horizontal" method="get">

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


    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            {{ submit_button('Search', 'class': 'btn btn-primary') }}
        </div>
    </div>
</form>
