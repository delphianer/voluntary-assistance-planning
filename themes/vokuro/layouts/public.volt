{# layout for public pages #}

{%- set isPublicMenu = true -%}


{% if userRole is defined and userRole is not empty and userRole != 'Guest' %}

{%- set menus = [
    'Landing Page': 'landingpage',
    'Calendar View': 'calendarview',
    'About': 'about'
] -%}

{% else %}

{%- set menus = [
    'Home': 'index',
    'About': 'about'
] -%}

{% endif %}

{% include 'layouts/includes/header.volt' %}


<main role="main" class="flex-shrink-0">
    <div class="container">
        {{ content() }}
    </div>
</main>


{% include 'layouts/includes/footer.volt' %}

