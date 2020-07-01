<h1 class="mt-3">Edit $plural$</h1>

<div class="btn-group mb-5" role="group">
    {{ link_to(url("$plural$"), "&larr; Go Back", "class": "btn btn-warning") }}
</div>

{{ content() }}

{{ flash.output() }}


<form class="form-horizontal" method="post">

    $captureFields$

    {{ hidden_field("id") }}

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            {{ submit_button('Save', 'class': 'btn btn-big btn-success') }}
        </div>
    </div>
</form>
