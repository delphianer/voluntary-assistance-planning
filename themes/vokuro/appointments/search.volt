<h1 class="mt-3">Search result</h1>

<div class="btn-group mb-5" role="group">
    {{ link_to(url("appointments"), "&larr; Go Back", "class": "btn btn-warning") }}
    {{ link_to(url("appointments/new"), "Create appointments", 'class': 'btn btn-primary') }}
</div>

{{ content() }}

{{ flash.output() }}

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Id</th>
            <th>Create Of Time</th>
            <th>Create Of UserId</th>
            <th>Update Of Time</th>
            <th>Update Of UserId</th>
            <th>Label</th>
            <th>Description</th>
            <th>Start</th>
            <th>End</th>
            <th>LocationId</th>
            <th>MainDepartmentId</th>
            <th>ClientId</th>

            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    {% for appointment in page.getItems() %}
        <tr>
            <td>{{ appointment.id }}</td>
            <td>{{ appointment.create_time }}</td>
            <td>{{ appointment.create_userId }}</td>
            <td>{{ appointment.update_time }}</td>
            <td>{{ appointment.update_userId }}</td>
            <td>{{ appointment.label }}</td>
            <td>{{ appointment.description }}</td>
            <td>{{ appointment.start }}</td>
            <td>{{ appointment.end }}</td>
            <td>{{ appointment.locationId }}</td>
            <td>{{ appointment.mainDepartmentId }}</td>
            <td>{{ appointment.clientId }}</td>


            <td class="td-width-12">{{ link_to( url("appointments/edit/") ~ appointment.id, '<i class="icon-pencil"></i> Edit', "class": "btn btn-sm btn-outline-warning") }}</td>
            <td class="td-width-12">{{ link_to( url("appointments/delete/") ~ appointment.id, '<i class="icon-remove"></i> Delete', "class": "btn btn-sm btn-outline-danger") }}</td>
        </tr>
    {% else %}
        <tr>
            <td colspan="10">
                No appointments are recorded
            </td>
        </tr>
    {% endfor %}
    </tbody>
    <tfoot>
    <tr>
        <td colspan="10" class="text-right">
            <div class="btn-group" role="group">
                {{ link_to(url("appointments/search") , '<i class="icon-fast-backward"></i> First', "class": "btn btn-secondary") }}
                {{ link_to(url("appointments/search?page=") ~ page.previous, '<i class="icon-step-backward"></i> Previous', "class": "btn btn-secondary") }}
                {{ link_to(url("appointments/search?page=") ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn btn-secondary") }}
                {{ link_to(url("appointments/search?page=") ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn btn-secondary") }}
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
