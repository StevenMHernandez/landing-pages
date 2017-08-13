<!DOCTYPE html>
<html>
<head>
    <title>{{ $page->header }}</title>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"
          name="viewport">
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900,200italic,300italic,400italic,600italic,700italic,900italic|Roboto+Condensed:300italic,400italic,700italic,400,300,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Condensed:300italic,400italic,700italic,400,300,700' rel='stylesheet' type='text/css'>
    <link href="css/style.css" rel="stylesheet" media="screen">
</head>
<body>

<!-- NAVBAR
    ================================================== -->
<nav class="navbar navbar-default" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse"
                    data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <a class="navbar-brand" href="#">Landing.app</a>

        </div>
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav">
                <li><a onclick="$('.features').animatescroll({padding:71});">Features</a></li>
                <li><a onclick="$('.social').animatescroll({padding:71});">Connect </a></li>
                <li><a onclick="$('.get-it').animatescroll({padding:71});">Subscribe </a></li>
            </ul>
        </div>
    </div>
</nav>


<!-- HEADER
================================================== -->
<header class="visibility">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>{{ $page->header }}</h1>
            </div>
        </div>
    </div>
</header>


<!-- FEATURES
    ================================================== -->
<section class="features">
    <div class="container">
        <div class="row">

            <div class="col-md-4">
                <div class="circle"><i class="icon-bookmark"></i></div>
                <h2>Quick &amp; Easy Setup</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                    incididunt ut labore et dolore magna.</p>
            </div>

            <div class="col-md-4">
                <div class="circle"><i class="icon-keypad"></i></div>
                <h2>Parallax Scrolling</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                    incididunt ut labore et dolore magna.</p>
            </div>

            <div class="col-md-4">
                <div class="circle"><i class="icon-like"></i></div>
                <h2>Responsive Design</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                    incididunt ut labore et dolore magna.</p>
            </div>

        </div>
    </div>
</section>


<!-- PAYOFF
    ================================================== -->
<section class="payoff">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                    incididunt ut labore et dolore magna.</h1>
            </div>
        </div>
    </div>
</section>


<!-- PURCHASE
    ================================================== -->
<section class="purchase">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8 text-left">
                <h1>Everything's easily customizable.</h1>
                <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Lorem ipsum dolor sit a sit amet, consectetur adipisiciisicing elit. Lorem ipsum dolorur adium dolor sit amet, consectetur adipisicing elit. Lorem ipsum dolor sit amet, consectetur adipisng elit. Lorem ipsum dolor sit amet, consectetmet, consectetur adipicing elit. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Lorem ipspisicing elit. Lorem ipsum dolor sit aum dolor sit amet, consectetur adimet, consectetur adipisicing elit. </p>
            </div>
        </div>
    </div>
</section>

<!-- SOCIAL
    ================================================== -->
<section class="social">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Connect with us</h2>
                <a class="icon-facebook"></a>
                <a class="icon-twitter"></a>
                <a class="icon-google"></a>
                <a class="icon-instagram"></a>
                <a class="icon-pinterest"></a>
            </div>
        </div>
    </div>
</section>


<!-- GET IT
    ================================================== -->
<section class="get-it">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
                {!! Form::open(['method', 'POST', 'route' => 'create_subscription']) !!}
                <div class="form-group">
                    <label for="email">
                        Your Email:
                    </label>
                    {!! Form::email('email', null, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    <label for="description">
                        Tell us about your company:
                    </label>
                    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
                </div>
                {!! Form::submit($page->sign_up_text, ['class' => 'btn btn-primary']) !!}
                {!! Form::close() !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <hr/>
                <ul>
                    <li><a href="#link-here">Contact</a></li>
                    <li><a href="#link-here">Twitter</a></li>
                    <li><a href="#link-here">Press</a></li>
                    <li><a href="#link-here">Support</a></li>
                    <li><a href="#link-here">Developers</a></li>
                    <li><a href="#link-here">Privacy</a></li>
                </ul>
            </div>
        </div>
    </div>
</section>


<!-- JAVASCRIPT
    ================================================== -->
<script src="js/app.js"></script>
<script src="js/scripts.js"></script>

</body>
</html>
