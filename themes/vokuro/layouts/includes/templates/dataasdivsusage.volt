 {#  how?
     just go for INSERT...HERE and add some extra entries if needed
     in this example also an if-statement for col 2 is set
     use what is useful and delete the not useful part #}


    {#---------- header definition -------------#}

    {% set headerData = [
            ['title' : 'INSERT_COL_1_TITLE_HERE', 'class':'text-center'],
            ['title' : 'INSERT_COL_2_TITLE_HERE', 'class':'text-center'],
            ['title' : 'INSERT_COL_2_TITLE_HERE - or leave empty that this column shoult not be shown', 'class':'text-center']
        ] %}

    {#---------- body definition ---------------#}

    {% set bodyData = [] %}

    {% for collectData in INSERT_COLLECTION_OBJECT_HERE %}

        {% set rowData = [] %}

        {% do arrayPush(rowData , [ 'data' : collectData.INSERT_COL_1_DATA_HERE, 'class' : 'text-center INSERT_EXTRA_CLASSES_IF_NEEDED_HERE'] ) %}

        {# ... #}

        {% do arrayPush(bodyData , rowData) %}

    {% else %}
        {% set nothingFound = 'No INSERT_NOTHING_FOUND_MESSAGE_HERE found' %}
    {% endfor %}

    {% include 'layouts/includes/dataasdivs.volt' %}

    {#---------- end --------#}
