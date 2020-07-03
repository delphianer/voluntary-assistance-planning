<h1 class="mt-3">Search result</h1>

<div class="btn-group mb-5" role="group">
    {{ link_to(url("vehicles"), "&larr; Go Back", "class": "btn btn-warning") }}
    {{ link_to(url("vehicles/new"), "Create vehicles", 'class': 'btn btn-primary') }}
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
            <th>TechnicalInspection</th>
            <th>SeatCount</th>
            <th>IsAmbulance</th>
            <th>HasFlashingLights</th>
            <th>HasRadioCom</th>
            <th>HasDigitalRadioCom</th>

            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    {% for vehicle in page.getItems() %}
        <tr>
            <td>{{ vehicle['id'] }}</td>
            <td>{{ vehicle['create_time'] }}</td>
            <td>{{ vehicle['update_time'] }}</td>
            <td>{{ vehicle['desc_short'] }}</td>
            <td>{{ vehicle['desc_long'] }}</td>
            <td>{{ vehicle['technicalInspection'] }}</td>
            <td>{{ vehicle['seatCount'] }}</td>
            <td>{{ vehicle['isAmbulance'] }}</td>
            <td>{{ vehicle['hasFlashingLights'] }}</td>
            <td>{{ vehicle['hasRadioCom'] }}</td>
            <td>{{ vehicle['hasDigitalRadioCom'] }}</td>


            <td class="td-width-12">{{ link_to( url("vehicles/edit/") ~ vehicle['id'], '<i class="icon-pencil"></i> Edit', "class": "btn btn-sm btn-outline-warning") }}</td>
            <td class="td-width-12">{{ link_to( url("vehicles/delete/") ~ vehicle['id'], '<i class="icon-remove"></i> Delete', "class": "btn btn-sm btn-outline-danger") }}</td>
        </tr>
    {% else %}
        <tr>
            <td colspan="10">
                No vehicles are recorded
            </td>
        </tr>
    {% endfor %}
    </tbody>
    <tfoot>
    <tr>
        <td colspan="10" class="text-right">
            <div class="btn-group" role="group">
                {{ link_to(url("vehicles/search") , '<i class="icon-fast-backward"></i> First', "class": "btn btn-secondary") }}
                {{ link_to(url("vehicles/search?page=") ~ page.previous, '<i class="icon-step-backward"></i> Previous', "class": "btn btn-secondary") }}
                {{ link_to(url("vehicles/search?page=") ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn btn-secondary") }}
                {{ link_to(url("vehicles/search?page=") ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn btn-secondary") }}
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
