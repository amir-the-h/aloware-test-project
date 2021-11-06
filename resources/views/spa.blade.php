<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Comments</title>
        <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
    </head>
    <body>
        <div id="app"></div>
    </body>

    <script>
        // set the base url for the api to use in vue app
        window.apiBaseUrl = '{{ env('APP_URL') }}/api';
        window.commentsMaxDepthLevel = {{ App\Models\Comment::MAX_LAYER }}
    </script>
    <script src="{{ mix('/js/app.js') }}"></script>
</html>
