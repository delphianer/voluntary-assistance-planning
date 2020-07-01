<div class="row">
    <nav>
        <ul class="pager">
            <li class="previous">{{ link_to("locations/index", "Zurück", 'class': 'btn btn-outline-primary btn-sm') }}</li>
            <li class="next">{{ link_to("locations/new", "Neu", 'class': 'btn btn-outline-success') }}</li>
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
            <th>Street</th>
            <th>AdditionalText</th>
            <th>Postalcode</th>
            <th>City</th>
            <th>Country</th>

                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        {% for location in page.getItems() %}
            <tr>
                <td>{{ location['id'] }}</td>
            <td>{{ location['create_time'] }}</td>
            <td>{{ location['update_time'] }}</td>
            <td>{{ location['desc_short'] }}</td>
            <td>{{ location['desc_long'] }}</td>
            <td>{{ location['street'] }}</td>
            <td>{{ location['additionalText'] }}</td>
            <td>{{ location['postalcode'] }}</td>
            <td>{{ location['city'] }}</td>
            <td>{{ location['country'] }}</td>

                <td>{{ link_to("locations/edit/"~location['id'], "Edit") }}</td>
                <td>{{ link_to("locations/delete/"~location['id'], "Delete") }}</td>
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
                <li>{{ link_to("locations/search", "First", false, "class": "page-link", 'id': 'first') }}</li>
                <li>{{ link_to("locations/search?page="~page.getPrevious(), "Previous", false, "class": "page-link", 'id': 'previous') }}</li>
                <li>{{ link_to("locations/search?page="~page.getNext(), "Next", false, "class": "page-link", 'id': 'next') }}</li>
                <li>{{ link_to("locations/search?page="~page.getLast(), "Last", false, "class": "page-link", 'id': 'last') }}</li>
            </ul>
        </nav>
    </div>
</div>
