<!DOCTYPE html>
<html>
<head>
    {!! HTML::style('css/all.css') !!}
<link rel="stylesheet" href="http://tools.ersnet.org/ersKit/0.4/fonts/fonts.min.css" />
<meta id="token" name="token" value="{{ csrf_token() }}"></meta>
    <title>Invite Reviewers</title>



        <!--[if (gte IE 6)&(lte IE 8)]>
        <link rel="stylesheet" href="http://tools.ersnet.org/ersKit/0.4/css/ie8.css" />
        <script src="http://tools.ersnet.org/ersKit/0.4/js/respond.js"></script> 
        <link href="http://tools.ersnet.org/ersKit/0.4/cross-domain/respond-proxy.html" id="respond-proxy" rel="respond-proxy" />
        <link href="/cross-domain/respond.proxy.gif" id="respond-redirect" rel="respond-redirect" />
        <script src="/cross-domain/respond.proxy.js"></script>
        <script type="text/javascript" src="http://tools.ersnet.org/ersKit/0.4/js/selectivizr.js"></script>
        <script src="http://tools.ersnet.org/ersKit/0.4/js/ie8.js"></script>
        <![endif]-->

</head>
<body>
<div class="ers-main-container">
<div class="ers-metanavigation uk-visible-large">
    <a class="ers-logo uk-visible-large" href="http://www.ersnet.org"></a>
</div>
<div class="ers-container" style="left: 100px;">
    @include('navbar')
    <div class="uk-container uk-container-center uk-margin-top uk-margin-large-bottom">
      <div data-uk-grid-margin="" class="uk-grid">
         <div class="uk-width-1-1">
          @yield('content')
        </div>
      </div>
    </div>

</div>
    <script src="/js/all.js"></script>
    <script src="/js/invite.js"></script>
      @yield('footer')

</body>
</html>
