<h1 class="mt-3">Search result</h1>

<div class="btn-group mb-5" role="group">
    {{ link_to(url("volunteers_certificates_link"), "&larr; Go Back", "class": "btn btn-warning") }}
    {{ link_to(url("volunteers_certificates_link/new"), "Create volunteers_certificates_link", 'class': 'btn btn-primary') }}
</div>

{{ content() }}

{{ flash.output() }}

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Create Of Time</th>
            <th>Update Of Time</th>
            <th>VolunteersId</th>
            <th>CertificatesId</th>
            <th>ValidUntil</th>

            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    {% for volunteers_certificates_link in page.getItems() %}
        <tr>
            <td>{{ volunteers_certificates_link['create_time'] }}</td>
            <td>{{ volunteers_certificates_link['update_time'] }}</td>
            <td>{{ volunteers_certificates_link['volunteersId'] }}</td>
            <td>{{ volunteers_certificates_link['certificatesId'] }}</td>
            <td>{{ volunteers_certificates_link['validUntil'] }}</td>


            <td class="td-width-12">{{ link_to( url("volunteers_certificates_link/edit/") ~ volunteers_certificates_link['create_time'], '<i class="icon-pencil"></i> Edit', "class": "btn btn-sm btn-outline-warning") }}</td>
            <td class="td-width-12">{{ link_to( url("volunteers_certificates_link/delete/") ~ volunteers_certificates_link['create_time'], '<i class="icon-remove"></i> Delete', "class": "btn btn-sm btn-outline-danger") }}</td>
        </tr>
    {% else %}
        <tr>
            <td colspan="10">
                No volunteers_certificates_link are recorded
            </td>
        </tr>
    {% endfor %}
    </tbody>
    <tfoot>
    <tr>
        <td colspan="10" class="text-right">
            <div class="btn-group" role="group">
                {{ link_to(url("volunteers_certificates_link/search") , '<i class="icon-fast-backward"></i> First', "class": "btn btn-secondary") }}
                {{ link_to(url("volunteers_certificates_link/search?page=") ~ page.previous, '<i class="icon-step-backward"></i> Previous', "class": "btn btn-secondary") }}
                {{ link_to(url("volunteers_certificates_link/search?page=") ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn btn-secondary") }}
                {{ link_to(url("volunteers_certificates_link/search?page=") ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn btn-secondary") }}
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
