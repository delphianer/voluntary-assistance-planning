<div class="row">
    <nav>
        <ul class="pager">
            <li class="previous">{{ link_to("vehicles/index", "Zurück", 'class': 'btn btn-outline-primary btn-sm') }}</li>
            <li class="next">{{ link_to("vehicles/new", "Neu", 'class': 'btn btn-outline-success') }}</li>
        </ul>
    </nav>
</div>

<div class="page-header">
    <h1>Search result</h1>
</div>

{{ content() }}

<div class="row">
    <table class="table table-bordered">
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

                <td>{{ link_to("vehicles/edit/"~vehicle['id'], "Edit") }}</td>
                <td>{{ link_to("vehicles/delete/"~vehicle['id'], "Delete") }}</td>
            </tr>
        {% endfor %}
        </tbody>
    </table>
</div>

<div class="row">
    <div class="col-sm-1">
        <p class="pagination" style="line-height: 1.42857;padding: 6px 12px;">
            {{ page.getCurrent()~"/"~page.getTotalItems() }}
        </p>
    </div>
    <div class="col-sm-11">
        <nav>
            <ul class="pagination">
                <li>{{ link_to("vehicles/search", "First", false, "class": "page-link", 'id': 'first') }}</li>
                <li>{{ link_to("vehicles/search?page="~page.getPrevious(), "Previous", false, "class": "page-link", 'id': 'previous') }}</li>
                <li>{{ link_to("vehicles/search?page="~page.getNext(), "Next", false, "class": "page-link", 'id': 'next') }}</li>
                <li>{{ link_to("vehicles/search?page="~page.getLast(), "Last", false, "class": "page-link", 'id': 'last') }}</li>
            </ul>
        </nav>
    </div>
</div>
