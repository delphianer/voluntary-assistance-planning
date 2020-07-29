{# needs
          - headerData as array with also arrays for 'title', 'class' used as attributes
          - bodyData as array similar tableHeadingData with data containing all cell-Rows.
                           Cells as Array with 'data', 'class' as attributes
          - nothingFound with a text-message in the case, nothing has been found
        #}
{# returns
            nothing -> outputs all the div-styled dynamic table #}

{#------------------------------------------------#}
{#                  define variables              #}
{% set colCount = 0                               %}

{#------------------------------------------------#}
{#     execute and fill arrays and variables      #}

    <div class="row m-2">
        {% for cell in headerData %}
            {% set cellClass = (cell['class'] is defined) ? ' ' ~ cell['class'] : '' %}
        <div class="col font-weight-bold{{ cellClass }}">
            {{ cell['title'] }}
            {% set colCount += 1 %}
        </div>
        {% endfor %}
    </div>

    {% for rowData in bodyData %}
    <div class="row">
        {% for cell in rowData %}
            {% set cellClass = (cell['class'] is defined) ? ' ' ~ cell['class'] : '' %}
        <div class="col{{ cellClass }}">
            {{ cell['data'] }}
        </div>
        {% endfor %}
    </div>
    {% else %}
    <div class="row">
        <div class="col is-1">
            {{ nothingFound }}
        </div>
    </div>
    {% endfor %}
