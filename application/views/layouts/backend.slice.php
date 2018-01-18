<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <!-- global stylesheets -->
    <link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/app.min.css')?>">
    <style type="text/css">
        /*preloader*/
        #preloader {position:fixed;top:0;left:0;right:0;bottom:0;background-color:#fff;z-index:9999999;}

        #status {width:100px;height:100px;position:absolute;left:47%;top:46%;background-repeat:no-repeat;background-position:center;}
        @media(max-width:320px){
            #status{left: 39%;top: 45%;}
        }
        @media screen and (min-width: 321px) and (max-width: 375px) {
            #status {left: 42%;}
        }
        @media screen and (min-width: 376px) and (max-width: 414px) {
            #status {left: 43%;}
        }
        @media screen and (min-width: 767px) and (max-width: 768px) {
            #status {left: 47%;}
        }
    </style>
    <link rel="icon" href="<?=base_url('assets/images/favicon.png')?>">
    @yield('css')
  </head>

  <body class="nav-md">
    <!-- loader -->
    <div id="preloader">
        <div id="status">
            <div class="loader">
                <div class="square-spin">
                    <div style="background-color: #2A3F54;"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="container body">
      <div class="main_container">
        @include('layouts/partials/backend/sidebar')

        <!-- top navigation -->
        @include('layouts/partials/backend/top_navigation')
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
            @yield('content')
        </div>
        <!-- /page content -->

        <!-- footer content -->
        @include('layouts/partials/backend/footer')
        <!-- /footer content -->
      </div>
    </div>

    <!-- global script -->
    <script src="<?=base_url('assets/js/app.min.js')?>"></script>
    
    <!-- loader -->
    <script type="text/javascript">
        $(window).load(function() { // makes sure the whole site is loaded
            $('#status').fadeOut(); // will first fade out the loading animation
            $('#preloader').delay(250).fadeOut('slow'); // will fade out the white DIV that covers the website.
            $('body').delay(250).css({'overflow':'visible'});
        });
    </script>

    @yield('script')

  </body>
</html>