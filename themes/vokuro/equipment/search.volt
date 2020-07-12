{% extends 'layouts/inheritance/mastersearch.volt' %}

{% block title %}Search result{% endblock %}

{% block tableheader %}
            <th>Id</th>
            <th>Label</th>
            <th>Description</th>
            <th>Total Of Count</th>
{% endblock %}

{% block tablebody %}

    {% for equipment in page.items %}
        <tr>
            <td>{{ equipment.id }}</td>
            <td>{{ equipment.label }}</td>
            <td>{{ equipment.description }}</td>
            <td>{{ equipment.total_count }}</td>

            <td class="td-width-12">{{ link_to( url("equipment/edit/") ~ equipment.id, '<i class="icon-pencil"></i> Edit', "class": "btn btn-sm btn-outline-warning") }}</td>
            <td class="td-width-12">{{ link_to( url("equipment/delete/") ~ equipment.id, '<i class="icon-remove"></i> Delete', "class": "btn btn-sm btn-outline-danger") }}</td>
        </tr>
    {% else %}
        <tr>
            <td colspan="10">
                No equipment are recorded
            </td>
        </tr>
    {% endfor %}

{% endblock %}
