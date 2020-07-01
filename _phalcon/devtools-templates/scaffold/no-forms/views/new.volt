<h1 class="mt-3">Create $plural$</h1>

<div class="btn-group mb-5" role="group">
    {{ link_to(url("$plural$"), "&larr; Go Back", "class": "btn btn-warning") }}
</div>

{{ flash.output() }}

<form action="{{ url("$plural$/create") }}" class="form-horizontal" method="post">
    $captureFields$

    {{ submit_button("Save", "class": "btn btn-success") }}
</form>
