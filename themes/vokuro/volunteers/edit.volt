{% extends 'layouts/inheritance/masteredit.volt' %}

{% block title %}Edit Volunteer{% endblock %}


{% block startOfTablist %}

    {% set activeTabKey = 'basic' %}

    {% set tabs = [
        'basic' : 'Main',
        'certificates' : 'Certificates'
    ] %}

    {% include 'layouts/includes/tablist.volt' %}

{% endblock %}



{% block inputelements %}

    {% include 'volunteers/common_input.volt' %}

{{ form.render("id") }}

{% endblock %}



{% block endOfTablist %}

{{ tabChangeList['certificates'] }}


    {#---------- start table.volt insert part --------#}

    {#---------- basic defines for acl-check ---------#}

    {% set isAllowedToEdit = (userRole is defined and acl.isAllowed( userRole, 'volunteerscertificateslink', "edit")) %}
    {% set isAllowedToDelete = (userRole is defined and acl.isAllowed( userRole, 'volunteerscertificateslink', "delete")) %}


    {#---------- table header definition -------------#}

    {% set tableHeadingData = [
            ['title' : 'Certificate', 'class':'text-center'],
            ['title' : 'Valid Until', 'class':'text-center']
        ] %}

    {% if isAllowedToEdit %}
        {% set foo = arrayPush(tableHeadingData ,  ['title' : ''] ) %}
    {% endif %}

    {% if isAllowedToDelete %}
        {% set foo = arrayPush(tableHeadingData ,  ['title' : ''] ) %}
    {% endif %}


    {#---------- table body definition ---------------#}

    {% set tableBodyData = [] %}

    {% for certLink in volunteer.VolunteersCertificatesLink %}

        {% set rowData = [] %}

        {% set foo = arrayPush(rowData , [ 'data' : certLink.Certificates.label, 'class' : 'text-center'] ) %}

        {% if certLink.validUntil is empty or certLink.validUntil == '0000-00-00' %}
            {% set foo = arrayPush(rowData , [ 'data' : '-', 'class' : 'text-center'] ) %}
        {% else %}
            {% set foo = arrayPush(rowData , [ 'data' : certLink.validUntil, 'class' : 'text-center'] ) %}
        {% endif %}

        {% if isAllowedToEdit %}
            {% set buttonData = '<button type="submit" class="btn btn-sm btn-outline-warning" name="submitAction"value="edit' ~ certLink.id ~ '"> <i class="icon-pencil"></i> change </button>' %}
            {% set foo = arrayPush(rowData ,  [ 'data' : buttonData, 'class' : 'td-width-12 text-center'] ) %}
        {% endif %}

        {% if isAllowedToDelete %}
            {% set buttonData = '<button type="submit" class="btn btn-sm btn-outline-danger" name="submitAction"value="del' ~ certLink.id ~ '"> <i class="icon-remove"></i> remove </button>' %}
            {% set foo = arrayPush(rowData ,  [ 'data' : buttonData, 'class' : 'td-width-12 text-center'] ) %}
        {% endif %}

        {% set foo = arrayPush(tableBodyData , rowData) %}

    {% else %}
        {% set tableBodyDataDefaultText = 'No certificates found' %}
    {% endfor %}


    {% include 'layouts/includes/dataastable.volt' %}

    {#---------- end table.volt insert part --------#}


    <div class="form-inline">
        <div class="col-sm-offset-2 col-sm-10">

            {{ form.render("volCertLnkId") }}

            {{ form.render("certificate") }}

            {{ form.render("certValidUntil") }}

            <button type="submit" class="btn btn-sm btn-primary"
                    name="submitAction" value="saveCertDefinition">Save Certificate</button>
        </div>
    </div>

{{ endAllTabs }}

{% endblock %}
