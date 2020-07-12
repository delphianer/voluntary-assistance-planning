{% extends 'layouts/inheritance/mastersearch.volt' %}

{% block title %}Search result{% endblock %}

{% block datatable %}

    {% set rowIDIndex = 0 %}


    {# TODO: remove not necessary columns and this comment #}
    {# TODO: change format of header columns to an array
        example: [
                     'Id',
                     'Label',
                     'Description'
                 ]
        then remove this comment
     #}
    {% set tableHeadingData = [

            {#--------------------------------------------#}
                        <th>Id</th>
            <th>Create Of Time</th>
            <th>Update Of Time</th>
            <th>Label</th>
            <th>Description</th>
            <th>TechnicalInspection</th>
            <th>SeatCount</th>
            <th>IsAmbulance</th>
            <th>HasFlashingLights</th>
            <th>HasRadioCom</th>
            <th>HasDigitalRadioCom</th>

            {#--------------------------------------------#}

        ] %}

    {% for $singular$ in page.items %}

        {% set rowData = [] %}

        {# TODO: remove not necessary columns and this comment #}
        {# TODO: change format -> like this example to add each cell into rowData-Array:
            example:
                {% set foo = arrayPush(rowData , $singular$.id) %}
                {% set foo = arrayPush(rowData , $singular$.label) %}
                {% set foo = arrayPush(rowData , $singular$.description) %}
            then remove this comment
         #}

         {#--------------------------------------------#}
                     <td>{{ vehicle['id'] }}</td>
            <td>{{ vehicle['create_time'] }}</td>
            <td>{{ vehicle['update_time'] }}</td>
            <td>{{ vehicle['label'] }}</td>
            <td>{{ vehicle['description'] }}</td>
            <td>{{ vehicle['technicalInspection'] }}</td>
            <td>{{ vehicle['seatCount'] }}</td>
            <td>{{ vehicle['isAmbulance'] }}</td>
            <td>{{ vehicle['hasFlashingLights'] }}</td>
            <td>{{ vehicle['hasRadioCom'] }}</td>
            <td>{{ vehicle['hasDigitalRadioCom'] }}</td>

         {#--------------------------------------------#}

        {% set foo = arrayPush(tableBodyData , rowData) %}

    {% endfor %}

{% endblock %}
