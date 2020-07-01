<div class="row">
    <nav>
        <ul class="pager">
            <li class="previous">{{ link_to("equipment/index", "Zurück", 'class': 'btn btn-outline-primary btn-sm') }}</li>
            <li class="next">{{ link_to("equipment/new", "Neu", 'class': 'btn btn-outline-success') }}</li>
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

                <td>{{ link_to("equipment/edit/"~equipment['id'], "Edit") }}</td>
                <td>{{ link_to("equipment/delete/"~equipment['id'], "Delete") }}</td>
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
                <li>{{ link_to("equipment/search", "First", false, "class": "page-link", 'id': 'first') }}</li>
                <li>{{ link_to("equipment/search?page="~page.getPrevious(), "Previous", false, "class": "page-link", 'id': 'previous') }}</li>
                <li>{{ link_to("equipment/search?page="~page.getNext(), "Next", false, "class": "page-link", 'id': 'next') }}</li>
                <li>{{ link_to("equipment/search?page="~page.getLast(), "Last", false, "class": "page-link", 'id': 'last') }}</li>
            </ul>
        </nav>
    </div>
</div>
