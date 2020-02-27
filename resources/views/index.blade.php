<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">


        <title>Laravel</title>
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">

        <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">


    </head>
    <body>
        <div id="top">
            <v-btn >
                <a href="{{ route('register') }}" class="btn-gradient-3d-simple">会員登録</a>
            </v-btn>

            <v-btn>
                <a href="{{ route('login') }}" class="btn-gradient-3d-simple2">ログイン</a>
            </v-btn>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
        <script>
            new Vue({
                el: '#top',
                vuetify: new Vuetify(),
            })
        </script>
    </body>
</html>
