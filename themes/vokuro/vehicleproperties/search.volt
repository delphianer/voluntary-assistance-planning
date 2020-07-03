<h1 class="mt-3">Search result</h1>

<div class="btn-group mb-5" role="group">
    {{ link_to(url("vehicleproperties"), "&larr; Go Back", "class": "btn btn-warning") }}
    {{ link_to(url("vehicleproperties/new"), "Create vehicleproperties", 'class': 'btn btn-primary') }}
</div>

{{ content() }}

{{ flash.output() }}

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Id</th>
            <th>VehiclesId</th>
            <th>Create Of Time</th>
            <th>Update Of Time</th>
            <th>Desc Of Short</th>
            <th>Desc Of Long</th>
            <th>Is Of Numeric</th>
            <th>Value Of String</th>
            <th>Value Of Numeric</th>

            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    {% for vehiclepropertie in page.getItems() %}
        <tr>
            <td>{{ vehiclepropertie['id'] }}</td>
            <td>{{ vehiclepropertie['vehiclesId'] }}</td>
            <td>{{ vehiclepropertie['create_time'] }}</td>
            <td>{{ vehiclepropertie['update_time'] }}</td>
            <td>{{ vehiclepropertie['desc_short'] }}</td>
            <td>{{ vehiclepropertie['desc_long'] }}</td>
            <td>{{ vehiclepropertie['is_numeric'] }}</td>
            <td>{{ vehiclepropertie['value_string'] }}</td>
            <td>{{ vehiclepropertie['value_numeric'] }}</td>


            <td class="td-width-12">{{ link_to( url("vehicleproperties/edit/") ~ vehiclepropertie['id'], '<i class="icon-pencil"></i> Edit', "class": "btn btn-sm btn-outline-warning") }}</td>
            <td class="td-width-12">{{ link_to( url("vehicleproperties/delete/") ~ vehiclepropertie['id'], '<i class="icon-remove"></i> Delete', "class": "btn btn-sm btn-outline-danger") }}</td>
        </tr>
    {% else %}
        <tr>
            <td colspan="10">
                No vehicleproperties are recorded
            </td>
        </tr>
    {% endfor %}
    </tbody>
    <tfoot>
    <tr>
        <td colspan="10" class="text-right">
            <div class="btn-group" role="group">
                {{ link_to(url("vehicleproperties/search") , '<i class="icon-fast-backward"></i> First', "class": "btn btn-secondary") }}
                {{ link_to(url("vehicleproperties/search?page=") ~ page.previous, '<i class="icon-step-backward"></i> Previous', "class": "btn btn-secondary") }}
                {{ link_to(url("vehicleproperties/search?page=") ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn btn-secondary") }}
                {{ link_to(url("vehicleproperties/search?page=") ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn btn-secondary") }}
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
