<h1 class="mt-3">Search result</h1>

<div class="btn-group mb-5" role="group">
    {{ link_to(url("operationshifts_vehicles_link"), "&larr; Go Back", "class": "btn btn-warning") }}
    {{ link_to(url("operationshifts_vehicles_link/new"), "Create operationshifts_vehicles_link", 'class': 'btn btn-primary') }}
</div>

{{ content() }}

{{ flash.output() }}

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Id</th>
            <th>OperationShiftId</th>
            <th>VehicleId</th>
            <th>Create Of Time</th>
            <th>Update Of Time</th>
            <th>ShortDescription</th>
            <th>LongDescription</th>

            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    {% for operationshifts_vehicles_link in page.getItems() %}
        <tr>
            <td>{{ operationshifts_vehicles_link['id'] }}</td>
            <td>{{ operationshifts_vehicles_link['operationShiftId'] }}</td>
            <td>{{ operationshifts_vehicles_link['vehicleId'] }}</td>
            <td>{{ operationshifts_vehicles_link['create_time'] }}</td>
            <td>{{ operationshifts_vehicles_link['update_time'] }}</td>
            <td>{{ operationshifts_vehicles_link['shortDescription'] }}</td>
            <td>{{ operationshifts_vehicles_link['longDescription'] }}</td>


            <td class="td-width-12">{{ link_to( url("operationshifts_vehicles_link/edit/") ~ operationshifts_vehicles_link['id'], '<i class="icon-pencil"></i> Edit', "class": "btn btn-sm btn-outline-warning") }}</td>
            <td class="td-width-12">{{ link_to( url("operationshifts_vehicles_link/delete/") ~ operationshifts_vehicles_link['id'], '<i class="icon-remove"></i> Delete', "class": "btn btn-sm btn-outline-danger") }}</td>
        </tr>
    {% else %}
        <tr>
            <td colspan="10">
                No operationshifts_vehicles_link are recorded
            </td>
        </tr>
    {% endfor %}
    </tbody>
    <tfoot>
    <tr>
        <td colspan="10" class="text-right">
            <div class="btn-group" role="group">
                {{ link_to(url("operationshifts_vehicles_link/search") , '<i class="icon-fast-backward"></i> First', "class": "btn btn-secondary") }}
                {{ link_to(url("operationshifts_vehicles_link/search?page=") ~ page.previous, '<i class="icon-step-backward"></i> Previous', "class": "btn btn-secondary") }}
                {{ link_to(url("operationshifts_vehicles_link/search?page=") ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn btn-secondary") }}
                {{ link_to(url("operationshifts_vehicles_link/search?page=") ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn btn-secondary") }}
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
