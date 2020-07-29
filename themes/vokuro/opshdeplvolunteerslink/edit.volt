{% extends 'layouts/inheritance/masteredit.volt' %}

{% block title %}Declare Commitment{% endblock %}

{% block inputelements %}

<header class="jumbotron" id="overview">
    <div class="row">
        <div class="col font-weight-bold">
            Operation:
        </div>
        <div class="col">
            <b>{{ operation.shortDescription }}</b>
        </div>
    </div>
    <div class="row">
        <div class="col font-weight-bold">
            Shift:
        </div>
        <div class="col">
            {{ operationShift.shortDescription }}
        </div>
    </div>
    <div class="row">
        <div class="col font-weight-bold">
            Start:
        </div>
        <div class="col">
            <b>{{ operationShift.Start }}</b>
        </div>
        <div class="col font-weight-bold">
            End:
        </div>
        <div class="col">
           <b> {{ operationShift.End }}</b>
        </div>
    </div>
</header>



{% include 'opshdeplvolunteerslink/common_input.volt' %}

{{ hidden_field("id") }}

{% endblock %}
