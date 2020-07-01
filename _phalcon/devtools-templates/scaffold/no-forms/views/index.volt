<h1>Search $plural$</h1>

<div class="btn-group mb-5" role="group">
    {{ link_to(url("$plural$"), "&larr; Go Back", "class": "btn btn-warning") }}
    {{ link_to(url("$plural$/new"), "Create $plural$", 'class': 'btn btn-primary') }}
</div>

{{ content() }}

{{ flash.output() }}

<form action="{{ url("$plural$/search") }}" class="form-horizontal" method="get">
    $captureFields$
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            {{ submit_button('Search', 'class': 'btn btn-default') }}
        </div>
    </div>
</form>
