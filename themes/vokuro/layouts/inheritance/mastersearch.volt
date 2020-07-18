<h1 class="mt-3">{% block title %}{% endblock %} - {{ dispatcher.getControllerName() }}</h1>

<div class="btn-group mb-5" role="group">
    {{ link_to(url(dispatcher.getControllerName()), "&larr; Go Back", "class": "btn btn-warning") }}
    {{ link_to(url(dispatcher.getControllerName() ~ "/new"), "Create new", 'class': 'btn btn-primary') }}
</div>

{{ content() }}

{{ flash.output() }}

{#------------------------------------------------#}
{#                  define variables              #}
{% set tableHeadingData = [] %}
{% set tableBodyData = [] %}
{% set rowIDIndex = 0 %}
{% set colCount = 0 %}
{% set isAllowedToEdit = (userRole is defined and acl.isAllowed( userRole, dispatcher.getControllerName(), "edit")) %}
{% set isAllowedToDelete = (userRole is defined and acl.isAllowed( userRole, dispatcher.getControllerName(), "delete")) %}

{#------------------------------------------------#}
{#     execute and fill arrays and variables      #}
{% block datatable %}{% endblock %}

<table class="table table-bordered table-striped">
    <thead>
        <tr>

            {#------------------------------------------------#}
            {% for cell in tableHeadingData %}
                <th>{{ cell }}</th>       {% set colCount += 1 %}
            {% endfor %}


            {% if isAllowedToEdit %}
            <th></th>             {% set colCount += 1 %}
            {% endif %}

            {% if isAllowedToDelete %}
            <th></th>               {% set colCount += 1 %}
            {% endif %}
        </tr>
    </thead>
    <tbody>

    {#------------------------------------------------#}
    {% for row in tableBodyData %}

        {% set rowId = rowIDIndex >= 0 ? row[rowIDIndex] : -1 %}
        <tr>
            {% for cell in row %}
            <td>{{ cell }}</td>
            {% endfor %}

            {% if rowId > 0 %}
                {% if isAllowedToEdit %}
                <td class="td-width-12">{{ link_to( url(dispatcher.getControllerName() ~ "/edit/") ~ rowId, '<i class="icon-pencil"></i> Edit', "class": "btn btn-sm btn-outline-warning") }}</td>
                {% endif %}

                {% if isAllowedToDelete %}
                <td class="td-width-12">{{ link_to( url(dispatcher.getControllerName() ~ "/delete/") ~ rowId, '<i class="icon-remove"></i> Delete', "class": "btn btn-sm btn-outline-danger") }}</td>
                {% endif %}
            {% endif %}
        </tr>
    {% else %}
        <tr>
            <td colspan="{{ colCount }}">
                No equipment are recorded
            </td>
        </tr>
    {% endfor %}

    </tbody>
    <tfoot>
    <tr>
        <td colspan="{{ colCount }}" class="text-right">
            <div class="btn-group" role="group">
                {{ link_to(url(dispatcher.getControllerName() ~ "/search") , '<i class="icon-fast-backward"></i> First', "class": "btn btn-secondary") }}
                {{ link_to(url(dispatcher.getControllerName() ~ "/search?page=") ~ page.previous, '<i class="icon-step-backward"></i> Previous', "class": "btn btn-secondary") }}
                {{ link_to(url(dispatcher.getControllerName() ~ "/search?page=") ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn btn-secondary") }}
                {{ link_to(url(dispatcher.getControllerName() ~ "/search?page=") ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn btn-secondary") }}
            </div>

            <div class="btn-group" role="group">
                <button type="button" class="btn btn-secondary" disabled>{{ page.current }}</button>
                <button type="button" class="btn btn-secondary" disabled>/</button>
                <button type="button" class="btn btn-secondary" disabled>{{ page.last }}</button>
            </div>
        </td>
    </tr>
    </tfoot>
</table>

