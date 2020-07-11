<h1 class="mt-3">Edit opshdepl_volunteers_link</h1>

<div class="btn-group mb-5" role="group">
    {{ link_to(url("opshdepl_volunteers_link"), "&larr; Go Back", "class": "btn btn-warning") }}
</div>

{{ content() }}

{{ flash.output() }}


<form  action="{{ url("opshdepl_volunteers_link/save") }}" class="form-horizontal" method="post">

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



    {{ hidden_field("id") }}

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            {{ submit_button('Save', 'class': 'btn btn-big btn-success') }}
        </div>
    </div>
</form>
