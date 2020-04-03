<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Clue</title>
    <!-- Font Awesome icons (free version)-->
    <script
      src="https://use.fontawesome.com/releases/v5.12.1/js/all.js"
      crossorigin="anonymous"
    ></script>
    <!-- Google fonts-->
    <link
      href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic"
      rel="stylesheet"
      type="text/css"
    />
    <!-- Third party plugin CSS-->
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css"
      rel="stylesheet"
    />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100;300;400;700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">

        <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
  </head>
  <body id="page-top">
    <!-- Navigation-->
    <nav
      class="navbar navbar-expand-lg navbar-light fixed-top py-3"
      id="mainNav"
    >
      <div class="header_nav_wrap">
        <a class="navbar-brand js-scroll-trigger" href="#page-top">Clue</a>
      </div>
    </nav>
    <!-- Masthead-->
    <header class="masthead">
      <div class="container h-100">
        <div
          class="row h-100 align-items-center justify-content-center text-center"
        >
          <div class="col-lg-10 align-self-end">
            <h1 class="text-uppercase text-white font-weight-bold">
              あなたのおしゃれに<br>“誰か”が手がかりをくれる。
            </h1>
            <hr class="divider my-4" />
          </div>
          <div class="col-lg-8-2 align-self-baseline">
            <p class="text-white-75 font-weight-light mb-5">
                <span class="font-montserrat">Clue</span>（クルー）は、<br>ファッションに関するお悩みを<br>
                気軽に投稿することができる場です。<br>
                アカウント登録をして投稿してみよう。<br>
                ※スマートフォンのみ対応
            </p>
            <div class="btn-wrap">
                <a class="btn btn-primary btn-xl js-scroll-trigger" href="{{ route('register') }}">
                    はじめる
                </a>
            </div>
            <div class="btn-wrap">
                <a class="btn btn-light btn-xl js-scroll-trigger" href="{{ route('login') }}">ログイン</a>
            </div>
          </div>
        </div>
      </div>
    </header>
    <!-- About section-->
    <section class="page-section bg-primary" id="about">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-8-2 text-center">
            <h2 class="text-white mt-0 font-montserrat"><span class="logo-clue">Clue</span>とは...</h2>
            <hr class="divider light my-4" />
            <p class="text-white-50 mb-4">
            <span class="font-montserrat">Clue</span>(クルー)は、ファッションに関するお悩みを<br>
            気軽に投稿することができるWebサービスです。</p>
            <p class="text-white-50 mb-4">
            例えば、<br>「どんな服がトレンドなのか教えて欲しい。」<br>
            「季節感のある着こなしをしたいけど<br>
                何を取り入れたらいいかわからない。」<br>
            </p>
            <p class="text-white-50 mb-4">
            そんなお悩みを解決してくれる<br>おしゃれ好きな誰かがいます。
            </p>
            <p class="text-white-50 mb-4">
            <span class="font-montserrat">Clue</span>でおしゃれを楽しむ手がかりを見つけよう。
            </p>
          </div>
        </div>
      </div>
    </section>
    <!-- Services section-->
    <section class="page-section bg-primary2" id="services">
      <div class="container">
        <h2 class="text-center mt-0">使い方</h2>
        <hr class="divider my-4" />
        <div class="row">
        <div class="col-lg-3 col-md-6 text-center">
            <div class="mt-5">
              <i class="fas fa-4x fa-user-cog text-primary mb-4"></i>
              <h3 class="h4 mb-2">プロフィールの登録</h3>
              <p class="text-muted mb-0">
                基本情報の登録を行いましょう。<br>
                好きなテイストを登録しておくと<br>
                好みにあった提案に繋がります。
              </p>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 text-center">
            <div class="mt-5">
              <i class="fas fa-4x fa-file-alt text-primary mb-4"></i>
              <h3 class="h4 mb-2">質問の投稿</h3>
              <p class="text-muted mb-0">
                画面下にあるプラスボタンから<br>新規投稿ができます。              
              </p>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 text-center">
            <div class="mt-5">
              <i class="fas fa-4x fa-crown text-primary mb-4"></i>
              <h3 class="h4 mb-2">ベストアンサー</h3>
              <p class="text-muted mb-0">
                回答があった場合は<br>
                ベストアンサーを選びましょう。<br>
                回答者へお礼のポイントが付与されます。
              </p>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 text-center">
            <div class="mt-5">
              <i class="fas fa-4x fa-heart text-primary mb-4"></i>
              <h3 class="h4 mb-2">その他</h3>
              <p class="text-muted mb-0">
                通知やブックマークなどの機能も...<br>
                自分の投稿だけではなく、<br>
                他のユーザーの投稿も見てみよう！
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Call to action section-->
    <section class="page-section bg-dark text-white">
      <div class="container text-center">
        <h2 class="mb-4 register-btn">アカウントの登録はこちら</h2>
        <a
          class="btn btn-light btn-xl"
          href="{{ route('register') }}"
          ><span class="font-montserrat">Clue</span>をはじめる</a
        >
      </div>
    </section>
    <!-- Footer-->
    <footer class="bg-light py-5">
      <div class="container">
        <div class="small text-center text-muted">
          Copyright © 2020 - Clue
        </div>
      </div>
    </footer>
    <!-- Bootstrap core JS-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <!-- Third party plugin JS-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
    <!-- Core theme JS-->
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
    <script>
        // new Vue({
        //     el: '#top',
        //     vuetify: new Vuetify(),
        // })
    </script>
  </body>
</html>

