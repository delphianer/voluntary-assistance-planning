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
            $headerColumns$
            {#--------------------------------------------#}

        ] %}

    {% for $singular$ in page.items %}

        {% set rowData = [] %}

        {# TODO: remove not necessary columns and this comment #}
        {# TODO: change format -> like this example to add each cell into rowData-Array:
            example:
                {% do arrayPush(rowData , $singular$.id) %}
                {% do arrayPush(rowData , $singular$.label) %}
                {% do arrayPush(rowData , $singular$.description) %}
            then remove this comment
         #}

         {#--------------------------------------------#}
         $rowColumns$
         {#--------------------------------------------#}

        {% do arrayPush(tableBodyData , rowData) %}

    {% endfor %}

{% endblock %}
