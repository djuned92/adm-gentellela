<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?=$template['title']?></title>

    <!-- global stylesheets -->
    <!-- Bootstrap -->
    <link href="<?=base_url('assets/plugins/bootstrap/dist/css/bootstrap.min.css')?>" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?=base_url('assets/plugins/font-awesome/css/font-awesome.min.css')?>" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?=base_url('assets/plugins/nprogress/nprogress.css')?>" rel="stylesheet">
    <!-- color system -->
    <link href="<?=base_url('assets/plugins/color-system/color-system.css')?>" rel="stylesheet" type="text/css">
    <!-- sweet alert -->
    <link href="<?=base_url('assets/plugins/sweetalert/sweetalert.css')?>" rel="stylesheet" type="text/css">
    <!-- loader -->
    <link href="<?=base_url('assets/plugins/loader/loader.css')?>" rel="stylesheet" type="text/css">
    <link href="<?=base_url('assets/plugins/animate.css/animate.min.css')?>" rel="stylesheet" type="text/css">
    <!-- Custom Theme Style -->
    <link href="<?=base_url('assets/css/custom.min.css')?>" rel="stylesheet">
    <style type="text/css">
        .breadcrumb {
            margin-bottom: 0;
        }
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
    <!-- jQuery -->
    <script src="<?=base_url('assets/plugins/jquery/dist/jquery.min.js')?>"></script>
    <!-- Bootstrap -->
    <script src="<?=base_url('assets/plugins/bootstrap/dist/js/bootstrap.min.js')?>"></script>
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
        <?php $this->load->view('layouts/partials/backend/sidebar.php') ?>

        <!-- top navigation -->
        <?php $this->load->view('layouts/partials/backend/top_navigation.php') ?>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
            <?=$template['body']?>
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <?php $this->load->view('layouts/partials/backend/footer.php') ?>
        <!-- /footer content -->
      </div>
    </div>

    <!-- global script -->
    <!-- FastClick -->
    <script src="<?=base_url('assets/plugins/fastclick/lib/fastclick.js')?>"></script>
    <!-- NProgress -->
    <script src="<?=base_url('assets/plugins/nprogress/nprogress.js')?>"></script>
    <!-- validator -->
    <script src="<?=base_url('assets/plugins/jquery-validation/jquery.validate.min.js')?>"></script>
    <!-- sweet alert -->
    <script src="<?=base_url('assets/plugins/sweetalert/sweetalert.min.js')?>"></script>
    <!-- Custom Theme Scripts -->
    <script src="<?=base_url('assets/js/custom.js')?>"></script>
    
    <!-- loader -->
    <script type="text/javascript">
        $(window).load(function() { // makes sure the whole site is loaded
            $('#status').fadeOut(); // will first fade out the loading animation
            $('#preloader').delay(250).fadeOut('slow'); // will fade out the white DIV that covers the website.
            $('body').delay(250).css({'overflow':'visible'});
        });       
    </script>


  </body>
</html>