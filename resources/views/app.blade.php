<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<link href="{{ asset('/css/app.css') }}" rel="stylesheet">

	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

<link rel="stylesheet" type="text/css" href="/semantic/dist/semantic.min.css">
<link rel="stylesheet" type="text/css" href="/css/style.css">

  <script src="/js/jquery-2.1.3.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script src="/semantic/dist/semantic.min.js"></script>
 <script src="/js/script.js"></script>
</head>
<body>







        <div class="ui inverted top  menu">
    <div class="header  item ">
     <img src="http://animeonline.su/templates/main/images/logo.png">

      </div>

 <a class="link item" href="{{URL::to('/',array())}}">
 Главная
    </a>
    <a class="link item" href="{{URL::to('top',array())}}">
    Топ аниме
    </a>
   @if(!Auth::check())

    <a class="link item" href="{{URL::to('auth/register',array())}}">
        Регистрация
        </a>
        <a class="link item" href="{{URL::to('auth/login',array())}}">
                Войти
                </a>
        @else
        <a class="link item" href="{{URL::route('prof',array('id'=>\Auth::user()->id))}}">
                Профайл
                </a>
                <div class="right menu">
        <div class="item">
        <div class="ui message blue  ">
        Hello {{{Auth::user()-> name}}}
        </div>
        </div>

                <a class="link item " href="{{URL::to('auth/logout',array())}}">Выйти</a>

                </div>
        @endif
</div>
@yield('content');



</body>
</html>