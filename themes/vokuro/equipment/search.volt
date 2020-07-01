<h1>Search result</h1>

<div class="btn-group mb-5" role="group">
    {{ link_to(url("equipment"), "&larr; Go Back", "class": "btn btn-warning") }}
    {{ link_to(url("equipment/new"), "Create equipment", 'class': 'btn btn-primary') }}
</div>

{{ content() }}

{{ flash.output() }}

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Id</th>
            <th>Create Of Time</th>
            <th>Update Of Time</th>
            <th>Desc Of Short</th>
            <th>Desc Of Long</th>
            <th>Total Of Count</th>

            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    {% for equipment in page.getItems() %}
        <tr>
            <td>{{ equipment['id'] }}</td>
            <td>{{ equipment['create_time'] }}</td>
            <td>{{ equipment['update_time'] }}</td>
            <td>{{ equipment['desc_short'] }}</td>
            <td>{{ equipment['desc_long'] }}</td>
            <td>{{ equipment['total_count'] }}</td>


            <td class="td-width-12">{{ link_to( url("equipment/edit") ~ equipment['id'], '<i class="icon-pencil"></i> Edit', "class": "btn btn-sm btn-outline-warning") }}</td>
            <td class="td-width-12">{{ link_to( url("equipment/delete") ~ equipment['id'], '<i class="icon-remove"></i> Delete', "class": "btn btn-sm btn-outline-danger") }}</td>
        </tr>
    {% else %}
        <tr>
            <td colspan="10">
                No equipment are recorded
            </td>
        </tr>
    {% endfor %}
    </tbody>
    <tfoot>
    <tr>
        <td colspan="10" class="text-right">
            <div class="btn-group" role="group">
                {{ link_to(url("equipment/search") , '<i class="icon-fast-backward"></i> First', "class": "btn btn-secondary") }}
                {{ link_to(url("equipment/search?page=") ~ page.previous, '<i class="icon-step-backward"></i> Previous', "class": "btn btn-secondary") }}
                {{ link_to(url("equipment/search?page=") ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn btn-secondary") }}
                {{ link_to(url("equipment/search?page=") ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn btn-secondary") }}
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
