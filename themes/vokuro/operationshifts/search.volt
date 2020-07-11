<h1 class="mt-3">Search result</h1>

<div class="btn-group mb-5" role="group">
    {{ link_to(url("operationshifts"), "&larr; Go Back", "class": "btn btn-warning") }}
    {{ link_to(url("operationshifts/new"), "Create operationshifts", 'class': 'btn btn-primary') }}
</div>

{{ content() }}

{{ flash.output() }}

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Id</th>
            <th>OperationId</th>
            <th>LocationId</th>
            <th>Create Of Time</th>
            <th>Create Of UserId</th>
            <th>Update Of Time</th>
            <th>Update Of UserId</th>
            <th>ShortDescription</th>
            <th>LongDescription</th>

            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    {% for operationshift in page.getItems() %}
        <tr>
            <td>{{ operationshift['id'] }}</td>
            <td>{{ operationshift['operationId'] }}</td>
            <td>{{ operationshift['locationId'] }}</td>
            <td>{{ operationshift['create_time'] }}</td>
            <td>{{ operationshift['create_userId'] }}</td>
            <td>{{ operationshift['update_time'] }}</td>
            <td>{{ operationshift['update_userId'] }}</td>
            <td>{{ operationshift['shortDescription'] }}</td>
            <td>{{ operationshift['longDescription'] }}</td>


            <td class="td-width-12">{{ link_to( url("operationshifts/edit/") ~ operationshift['id'], '<i class="icon-pencil"></i> Edit', "class": "btn btn-sm btn-outline-warning") }}</td>
            <td class="td-width-12">{{ link_to( url("operationshifts/delete/") ~ operationshift['id'], '<i class="icon-remove"></i> Delete', "class": "btn btn-sm btn-outline-danger") }}</td>
        </tr>
    {% else %}
        <tr>
            <td colspan="10">
                No operationshifts are recorded
            </td>
        </tr>
    {% endfor %}
    </tbody>
    <tfoot>
    <tr>
        <td colspan="10" class="text-right">
            <div class="btn-group" role="group">
                {{ link_to(url("operationshifts/search") , '<i class="icon-fast-backward"></i> First', "class": "btn btn-secondary") }}
                {{ link_to(url("operationshifts/search?page=") ~ page.previous, '<i class="icon-step-backward"></i> Previous', "class": "btn btn-secondary") }}
                {{ link_to(url("operationshifts/search?page=") ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn btn-secondary") }}
                {{ link_to(url("operationshifts/search?page=") ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn btn-secondary") }}
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
