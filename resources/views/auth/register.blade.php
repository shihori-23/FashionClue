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
<div id="register">
    <v-app>
            <v-container>
                <h2 class="main-title_a">Fashion clue</h2>
                <div class="signin_container">
                    <h2 class="sub-title_a">ユーザー登録</h2>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <v-text-field
                            name="name"
                            value="{{ old('name') }}"
                            counter="10"
                            label="ニックネーム"
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
                        <!-- <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>         -->
                        <!-- <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email"> -->
                        <input id="role" value="1" type="hidden" name="role">
                        <!-- <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password"> -->
                        <!-- <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password"> -->
            
                        <v-btn type="submit" class="btn btn-primary submit_btn_a" color="#707070">
                                Register
                        </v-btn>
                    </form>
                </div>
            </v-container>
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
