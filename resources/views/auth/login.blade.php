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
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
    <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
    </head>
<body>
    <div id="login">
        <div class="bg"></div>
        <v-app>
            <v-container>
                <h2 class="main-title_a">Fashion Clue</h2>
                    <div class="signin_container">
                    <h2 class="sub-title_a">Sign In</h2>
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
                        <!-- <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus> -->
                        <!-- <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password"> -->
                        <v-btn type="submit" class="submit_btn_a" color="#707070">
                            ログイン
                        </v-btn>
                        @if (Route::has('password.request'))
                        <div>
                            <a class="btn btn-link text_btn_a" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        </div>
                        @endif
                    </form>
                </div>
            </v-container>
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