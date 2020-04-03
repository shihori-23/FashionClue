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
    <div id="login">
        <v-app>
            <div class="logo">
                <h2 class="logo_title">Clue</h1>
                <!-- <img src="{{ asset('img/logo.png')}}" alt="clueロゴ画像"> -->
            </div>
            <div class="form-wrapper">
                <h1>Sign In</h1>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <v-text-field
                            name="email"
                            value="{{ old('email') }}"
                            label="メールアドレス"
                            required
                            autocomplete="email"
                            autofocus
                            color="#707070"
                        ></v-text-field>
                        <v-text-field
                            name="password"
                            type="password"
                            value="{{ old('password') }}"
                            label="パスワード"
                            required
                            autocomplete="password"
                            color="#707070"
                        ></v-text-field>
                        <div class="button-panel">
                        <input type="submit" class="button" title="Sign In" value="Sign In"></input>
                        </div>
                    </form>
                    <div class="form-footer">
                        <p><a href="{{ route('register') }}">Create an account</a></p>
                    @if (Route::has('password.request'))
                        <!-- <div>
                            <a class="btn btn-link text_btn_a" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        </div> -->
                    @endif
                    </div>
                    
            </div>
        </v-app>
    </div>

<script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
<script>
    new Vue({
        el: '#login',
        vuetify: new Vuetify(),
    })
</script>
</body>