<!DOCTYPE html>
<html>
<head>
    {!! HTML::style('css/all.css') !!}
<link rel="stylesheet" href="https://tools.ersnet.org/ersKit/0.4/fonts/fonts.min.css" />
<meta id="token" name="token" value="{{ csrf_token() }}"></meta>
    <title>Reports</title>



        <!--[if (gte IE 6)&(lte IE 8)]>
        <link rel="stylesheet" href="https://tools.ersnet.org/ersKit/0.4/css/ie8.css" />
        <script src="https://tools.ersnet.org/ersKit/0.4/js/respond.js"></script> 
        <link href="https://tools.ersnet.org/ersKit/0.4/cross-domain/respond-proxy.html" id="respond-proxy" rel="respond-proxy" />
        <link href="/cross-domain/respond.proxy.gif" id="respond-redirect" rel="respond-redirect" />
        <script src="/cross-domain/respond.proxy.js"></script>
        <script type="text/javascript" src="https://tools.ersnet.org/ersKit/0.4/js/selectivizr.js"></script>
        <script src="https://tools.ersnet.org/ersKit/0.4/js/ie8.js"></script>
        <![endif]-->

</head>
<body>
<div class="ers-main-container">
<div class="ers-metanavigation uk-visible-large">
    <a class="ers-logo uk-visible-large" href="https://www.ersnet.org"></a>
</div>
<div class="ers-container" style="left: 100px;">
    @include('navbar')
    <div class="uk-container uk-container-center uk-margin-top uk-margin-large-bottom">
      <div data-uk-grid-margin="" class="uk-grid">
         <div class="uk-width-1-1">
            @foreach($results as $key => $result)
            <div class="uk-grid uk-text-center">
		        <h3 class="uk-container-center" style="margin-top:50px;">{{$key}} (<a href="{{url('impersonate/'.$result['ers_id'])}}">{{$result['ers_id']}}</a>) - {{$result['total'] + 1 }}/{{$result['quantity']}}</h3>
	        </div>
            <h4 class="uk-text-center">As chair of a group, the user has been added and counted as a reviewer</h4>
                <div class="uk-grid uk-grid-medium" style="margin-left:20px">
                @foreach($result['reviewers'] as $reviewer)
                <div class="uk-width-medium-1-4 uk-grid-width-small-1-1">
                    <div class="uk-grid">
                        <div style="margin-top:30px;"class="uk-panel uk-panel-header uk-panel-box uk-width-1-1 uk-container-center">
                            <div class="uk-panel-title">{{$reviewer['title']}} {{$reviewer['first_name']}} {{$reviewer['last_name']}}</div>
                            <ul class="uk-list">
                                <li>ERS ID: {{$reviewer['ers_id']}}</li>
                                <li>{{$reviewer['email']}}</li>
                            </ul>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>   
            @endforeach
        </div>
      </div>
    </div>

</div>
    <script src="/js/all.js"></script>
    <script src="/js/invite.js"></script>
      @yield('footer')

</body>
</html>