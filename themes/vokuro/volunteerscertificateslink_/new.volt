{% extends 'layouts/inheritance/masternew.volt' %}

{% block title %}Create  Volunteers Certificate{% endblock %}

{% block inputelements %}


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



{% endblock %}
