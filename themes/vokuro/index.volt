<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <title>
    {% if extraTitle is defined %}
        {{ extraTitle }} ::
    {% endif %}
    V:A:P :: Voluntary Assistance Planning</title>

    {{ assets.outputCss('css') }}
</head>
<body class="d-flex flex-column h-100">

    {{ content() }}

    {{ assets.outputJs('js') }}
</body>
</html>
