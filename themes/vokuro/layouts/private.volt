{%-
set menus = [
    'Home': null,
    'Manage' : [
        'Certificates' : 'certificates',
        'Equipment' : 'equipment',
        'Volunteers' : 'volunteers'
        ],
    'Admin': [
        'Users': 'users',
        'Profiles': 'profiles'
        ],
    'SU': [
        'Permissions': 'permissions'
        ]
] -%}

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    {{ link_to(null, 'class': 'navbar-brand', 'Vökuró') }}

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            {%- for key, value in menus %}
                {% if isAnArray( value) %}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ key }}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            {%- for subkey, subvalue in value %}
                                {% if subvalue == dispatcher.getControllerName() %}
                                    <li class="dropdown-item active">
                                        {{ link_to(subvalue, 'class': 'nav-link', subkey) }}
                                    </li>
                                {% else %}
                                    <li class="dropdown-item">
                                        {{ link_to(subvalue, 'class': 'dropdown-item', subkey) }}{# link_to('users/changePassword', 'class': 'dropdown-item' nav-link, 'Change Password') #}
                                    </li>
                                {% endif %}
                            {%- endfor -%}
                        </ul>
                    </li>
                {% elseif value == dispatcher.getControllerName() %}
                    <li class="nav-item active">
                        {{ link_to(value, 'class': 'nav-link', key) }}
                    </li>
                {% else %}
                    {# TODO: TODO-001 make this working % if acl.isAllowed( acl.acl.activeRole, value, "index") % #}
                    <li class="nav-item">{{ link_to(value, 'class': 'nav-link', key) }}</li>
                    {# % endif % #}
                {% endif %}
            {%- endfor -%}
        </ul>

        <ul class="navbar-nav my-2 my-lg-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ auth.getName() }}
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    {{ link_to('users/changePassword', 'class': 'dropdown-item', 'Change Password') }}
                    <hr>
                    {{ link_to('about', 'class': 'dropdown-item', userRole) }}
                </div>
            </li>
            <li class="nav-item">{{ link_to('session/logout', 'class': 'nav-link', 'Logout') }}</li>
        </ul>
    </div>
</nav>



<div class="container">
    {{ content() }}
</div>
