<!DOCTYPE html>
<html>
    <head>
        <title><?php echo Config('params.site_name'); ?> | @yield('title')</title>
        <meta name="description" content="@yield('description')">
        <meta name="keywords" content="@yield('keywords')" />

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!--iPhone from zooming form issue-->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" /> 
        <link rel="icon" type="image/png" href="{{asset('front/images/favicon.png')}}">
        <link href="{{asset('front/css/bootstrap.min.css')}}" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('front/style.css')}}">
        <link rel="stylesheet" href="{{asset('front/css/font-awesome.min.css')}}">
        <script src="{{asset('/front/js/jquery-2.2.4.min.js')}}"></script>
        <script type="text/javascript" src="{{ asset('front/js/html2canvas.js') }}"></script>   
        <script src="{{asset('/front/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('/front/js/bigtext.js')}}"></script>
        <script>
        var bt = BigText.noConflict(true);
        $.fn.bt = bt.jQueryMethod;

        
        
        </script>
    </head>
    <body>
        @include('front/common/navigation')
        <main id="page-content">
            @yield('content')

            @include('front/common/footer')
            <a href="" class="scrollToTop"><i class="fa fa-arrow-up"></i></a>
        </main>
        <div id="loading"></div>

        <script src="{{asset('/front/js/kodeized.js')}}"></script>
        
    </body>
</html>
