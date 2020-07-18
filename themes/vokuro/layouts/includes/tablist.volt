
{# needs
           array tabs with key => value where key is the key that is used in end of tablist
           var activeTabKey with the name of the active tabKey
           (optional) setActiveTabKey to set the tabKey dynamically (e.g. from controller)#}
{# returns
           an array tabChangeList with key => value where key is same key as used in tabs and value is the echo for tabchange
           var endAllTabs with the echo for the end of the documenttabChangeList
            #}

    <ul class="nav nav-tabs" id="user-edit-tabs" role="tablist">


    {% if setActiveTabKey is defined %}
        {% set activeTabKey = setActiveTabKey %}
    {% endif %}

    {% set firstTabStart = '' %}
    {% set tabChangeList = [] %}
    {% set endAllTabs = '</div></div>' %}

    {% for tabKey, tabValue in tabs %}
        {% set classForActivation = '' %}
        {% if activeTabKey == tabKey %}
            {% set classForActivation = 'active' %}
        {% endif %}
        <li class="nav-item">
            <a class="nav-link {{ classForActivation }}" id="{{ tabKey }}-tab" data-toggle="tab" href="#{{ tabKey }}" role="tab" aria-controls="basic" aria-selected="true">{{ tabValue }}</a>
        </li>
        {% if firstTabStart is empty %}
            {% set firstTabStart = '<div class="tab-content mt-3">' %}
            {% set firstTabStart = firstTabStart ~ '<div class="tab-pane fade show ' ~ classForActivation %}
            {% set firstTabStart = firstTabStart ~ '" id="' ~ tabKey %}
            {% set firstTabStart = firstTabStart ~ '" role="tabpanel" aria-labelledby="' ~ tabKey ~ '-tab">' %}
        {% else %}

            {% set nextTabChange = "</div>" %}
            {% set nextTabChange = nextTabChange ~ ' <div class="tab-pane fade show ' %}
            {% set nextTabChange = nextTabChange ~ classForActivation %}
            {% set nextTabChange = nextTabChange ~ '" id="' ~ tabKey %}
            {% set nextTabChange = nextTabChange ~ '" role="tabpanel" aria-labelledby="' ~ tabKey ~ '-tab">' %}

            {% set tabChangeList[tabKey] = nextTabChange %}
        {% endif %}

    {% endfor %}

    </ul>

{{ firstTabStart }}

