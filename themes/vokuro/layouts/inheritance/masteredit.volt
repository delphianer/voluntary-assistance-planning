<h1 class="mt-3">{% block title %}{% endblock %}</h1>

<div class="btn-group mb-5" role="group">
    {{ link_to(url(dispatcher.getControllerName()), "&larr; Go Back", "class": "btn btn-warning") }}
</div>

{{ content() }}

{{ flash.output() }}

<form  action="{{ url( dispatcher.getControllerName() ~ "/save") }}" class="form-horizontal" method="post">

{% block startOfTablist %}{% endblock %}

            {% block inputelements %}{% endblock %}

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    {{ submit_button('Save', 'class': 'btn btn-success') }}
                    <button type="reset" class="btn btn-warning">Reset</button>
                </div>
            </div>

{% block endOfTablist %}{% endblock %}

</form>


