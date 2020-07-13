{% extends 'layouts/inheritance/masternew.volt' %}

{% block title %}Create Volunteer Commitments{% endblock %}

{% block inputelements %}

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
    <label for="fieldOpdepneedid" class="col-sm-2 control-label">OpDepNeedId</label>
    <div class="col-sm-10">
        {{ text_field("opDepNeedId", "type" : "numeric", "class" : "form-control", "id" : "fieldOpdepneedid") }}
    </div>
</div>

<div class="form-group">
    <label for="fieldVolunteersid" class="col-sm-2 control-label">VolunteersId</label>
    <div class="col-sm-10">
        {{ text_field("volunteersId", "type" : "numeric", "class" : "form-control", "id" : "fieldVolunteersid") }}
    </div>
</div>

<div class="form-group">
    <label for="fieldVolcurrentmaximumcertrank" class="col-sm-2 control-label">VolCurrentMaximumCertRank</label>
    <div class="col-sm-10">
        {{ text_field("volCurrentMaximumCertRank", "type" : "numeric", "class" : "form-control", "id" : "fieldVolcurrentmaximumcertrank") }}
    </div>
</div>



{% endblock %}
