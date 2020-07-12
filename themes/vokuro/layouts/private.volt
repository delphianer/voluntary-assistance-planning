{# layout for private pages #}

{%-
set subMenuPermissions = [
    'Home': 'index',
    'List': 'noAccess',
    'Manage master data' : 'equipment',
    'Manage people': 'clients',
    'Admin page': 'users',
    'Super User': 'permissions'
]    -%}

{%-
set menus = [
    'Home': 'index',
    'Appointments': 'appointments',
    'Operations': 'operations',
    'List': [
        ],
    'Manage master data' : [
        'Certificates' : 'certificates',
        'Departments' : 'departments',
        'Equipment' : 'equipment',
        'Locations' : 'locations',
        'Vehicles' : 'vehicles',
        'Vehicle Properties' : 'vehicleproperties'
        ],
    'Manage people': [
        'Clients' : 'clients',
        'Volunteers' : 'volunteers'
        ],
    'Manage people': [
        'Clients' : 'clients',
        'Volunteers' : 'volunteers'
        ],
    'Admin page': [
        'Users': 'users',
        'Profiles': 'profiles'
        ],
    'Super User': [
        'Permissions': 'permissions'
        ]
] -%}



{% include 'layouts/includes/header.volt' %}

<div class="container">
    {{ content() }}
</div>

{% include 'layouts/includes/footer.volt' %}
