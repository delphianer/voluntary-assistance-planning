<h1 class="mt-3">{% block title %}{% endblock %}</h1>

<div class="btn-group mb-5" role="group">
    {% if backAction is defined %}
         {% set actionURL = url(backAction) %}
    {% else %}
        {% set actionURL = url(dispatcher.getControllerName()) %}
    {% endif %}
    {{ link_to(actionURL, "&larr; Go Back", "class": "btn btn-warning") }}
</div>

{{ content() }}

{{ flash.output() }}

<form  action="{{ url( dispatcher.getControllerName() ~ "/save") }}" class="form-horizontal" method="post">

{% if backAction is defined %}
     {{ hidden_field('backActionController', 'value':backActionController) }}
     {{ hidden_field('backActionValue', 'value':backActionValue) }}
{% endif %}

{% block startOfTablist %}{% endblock %}

            {% block inputelements %}{% endblock %}

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-success" name="submitAction" value="submit">Save</button>
                    <button type="reset" class="btn btn-warning">Reset</button>
                </div>
            </div>

{% block endOfTablist %}{% endblock %}

</form>


