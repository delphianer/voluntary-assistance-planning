{% extends 'layouts/inheritance/masteredit.volt' %}

{% block title %}Edit Operation Shift{% endblock %}




{% block startOfTablist %}

    {% set activeTabKey = 'basic' %}

    {% set tabs = [
        'basic' : 'Main',
        'manpower' : 'Departments & Manpower',
        'equipment' : 'Equipment',
        'vehicles' : 'Vehicles'
    ] %}

    {% include 'layouts/includes/tablist.volt' %}

{% endblock %}





{% block inputelements %}

{% include 'operationshifts/common_input.volt' %}

{{ hidden_field("id") }}

{% endblock %}




{% block endOfTablist %}

{{ tabChangeList['manpower'] }}


todo: manpower


{{ tabChangeList['equipment'] }}


todo: equipment


{{ tabChangeList['vehicles'] }}


todo: vehicles


{{ endAllTabs }}

{% endblock %}
