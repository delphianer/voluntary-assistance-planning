<h1 class="mt-3">{% block title %}{% endblock %}</h1>

<div class="btn-group mb-5" role="group">
    {{ link_to(url(dispatcher.getControllerName() ~ "/new"), "Create new", 'class': 'btn btn-primary') }}
</div>

{{ content() }}

{{ flash.output() }}

<form action="{{ url( dispatcher.getControllerName() ~ "/search") }}" class="form-horizontal" method="get">

{% block inputelements %}{% endblock %}

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            {{ submit_button('Search', 'class': 'btn btn-primary') }}
            {{ link_to(url(dispatcher.getControllerName() ), "Clear", 'class': 'btn btn-warning') }}
        </div>
    </div>
</form>
