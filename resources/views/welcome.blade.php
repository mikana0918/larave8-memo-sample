<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>サンプルアプリ</title>
    </head>
    <body>
        <div id="app">
            <!-- デフォルトだとこの中ではvue.jsが有効 -->
            <!-- example-component はLaravelに入っているサンプルのコンポーネント -->
            <router-view></router-view>
        </div>
    </body>
</html>
<script src={{ mix('js/app.js') }}></script>