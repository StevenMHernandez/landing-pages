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
    <link rel="stylesheet" href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome-font-awesome.min.css">
    <link href="css/app.css" rel="stylesheet" media="screen">
    <link href="css/style.css" rel="stylesheet" media="screen">
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

            <a class="navbar-brand" href="#">{{ $page->name }}</a>

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
            @foreach ($page->features as $feature)
                <div class="col-md-4">
                    <div class="circle"><i class="fa fa-5x {{ $feature->icon }}"></i></div>
                    <h2>{{ $feature->header }}</h2>
                    <p>{!! $feature->body !!}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>


<!-- PAYOFF
    ================================================== -->
<section class="payoff">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>{{ $page->quote }}</h1>
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
                {{ \GrahamCampbell\Markdown\Facades\Markdown::convertToHtml($page->full_description) }}
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
                <p>{{ $page->form_text }}</p>
                @foreach($page->socialLinks as $link)
                    <a class="{{ $link->icon }}" href="{{ $link->url }}"></a>
                @endforeach
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
    </div>
</section>


<!-- JAVASCRIPT
    ================================================== -->
<script src="js/app.js"></script>
<script src="js/scripts.js"></script>

</body>
</html>
