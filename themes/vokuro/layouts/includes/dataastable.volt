{# needs
          - tableHeadingData as array with also arrays for 'title', 'class' used as attributes
          - tableBodyData as array similar tableHeadingData with data containing all cell-Rows.
                           Cells as Array with 'data', 'class' as attributes
        #}
{# returns
            nothing -> outputs all the table #}

{#------------------------------------------------#}
{#                  define variables              #}
{% set colCount = 0                               %}

{#------------------------------------------------#}
{#     execute and fill arrays and variables      #}


    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            {% for cell in tableHeadingData %}

                {% set cellClass = (cell['class'] is defined) ? ' class="' ~ cell['class'] ~ '"' : '' %}

                <th{{ cellClass }}>{{ cell['title'] }}</th>       {% set colCount += 1 %}

            {% endfor %}

        </tr>
        </thead>
        <tbody>

        {% for rowData in tableBodyData %}
            <tr>
            {% for cell in rowData %}

                {% set cellClass = (cell['class'] is defined) ? ' class="' ~ cell['class'] ~ '"' : '' %}

                <td{{ cellClass }}>{{ cell['data'] }}</td>

            {% endfor %}
            </tr>
        {% else %}
            <tr>
                <td colspan="{{ colCount }}" class="text-center">{{ tableBodyDataDefaultText }}</td>
            </tr>
        {% endfor %}

        </tbody>
    </table>
