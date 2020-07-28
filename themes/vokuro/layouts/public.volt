{# layout for public pages #}

{%- set isPublicMenu = true -%}

{%- set menus = [
    'Home': 'index',
    'About': 'about'
] -%}

{% include 'layouts/includes/header.volt' %}


<main role="main" class="flex-shrink-0">
    <div class="container">
        {{ content() }}
    </div>
</main>


{% include 'layouts/includes/footer.volt' %}

