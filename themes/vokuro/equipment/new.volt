<div class="row">
    <nav>
        <ul class="pager">
            <li class="previous">{{ link_to("equipment", "Zurück", 'class': 'btn btn-outline-primary btn-sm') }}</li>
        </ul>
    </nav>
</div>

<div class="page-header">
    <h1>Create equipment</h1>
</div>

{# display flashing outputs: #}
{{ flash.output() }}

{{ content() }}

<form action="/equipment/create" class="form-horizontal" method="post">


<div class="form-group">
    <label for="fieldDescShort" class="col-sm-2 control-label">Desc Of Short</label>
    <div class="col-sm-10">
        {{ text_field("desc_short", "size" : 30, "class" : "form-control", "id" : "fieldDescShort") }}
    </div>
</div>

<div class="form-group">
    <label for="fieldDescLong" class="col-sm-2 control-label">Desc Of Long - todo: big text box</label>
    <div class="col-sm-10">
        {{ text_field("desc_long", "size" : 30, "class" : "form-control", "id" : "fieldDescLong") }}
    </div>
</div>

<div class="form-group">
    <label for="fieldTotalCount" class="col-sm-2 control-label">Total Of Count</label>
    <div class="col-sm-10">
        {{ text_field("total_count", "type" : "numeric", "class" : "form-control", "id" : "fieldTotalCount") }}
    </div>
</div>


    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            {{ submit_button('Save', 'class': 'btn btn-default') }}
        </div>
    </div>
</form>
