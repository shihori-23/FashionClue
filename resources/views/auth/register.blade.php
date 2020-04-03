<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100;300;400;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">

    <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    -->
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
    </head>
<body>
<div id="register">
    <v-app>
        <div class="logo">
            <h2 class="logo_title">Clue</h1>
            <!-- <img src="{{ asset('img/logo.png')}}" alt="clueロゴ画像"> -->
        </div>
        <div class="form-wrapper">
            <h1>Register</h1>
            <form method="POST" action="{{ route('register') }}">
            @csrf
                <v-text-field
                        name="name"
                        value="{{ old('name') }}"
                        counter="10"
                        label="アカウント名"
                        required
                        color="#707070"
                    ></v-text-field>
                    <v-text-field
                        name="email"
                        value="{{ old('email') }}"
                        label="メールアドレス"
                        required
                        color="#707070"
                    ></v-text-field>
                    <v-text-field
                        name="password"
                        value="{{ old('password') }}"
                        label="パスワード"
                        type="password"
                        required
                        color="#707070"
                    ></v-text-field>
                    <v-text-field
                        name="password_confirmation"
                        label="パスワードの確認"
                        type="password"
                        required
                        color="#707070"
                    ></v-text-field>
                <div class="button-panel">
                    <input type="submit" class="button" title="Submit" value="Submit"></input>
                </div>
            </form>
            <div class="form-footer">
                <p><a href="{{ route('login') }}">Sign In</a></p>
            </div>
        </div>
    </v-app>
</div>
<script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
<script>
    new Vue({
      el: '#register',
      vuetify: new Vuetify(),
    })
</script>
</body>
