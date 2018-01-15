<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Gentelella Alela! | Login </title>
        <!-- Bootstrap -->
        <link href="<?=base_url('assets/plugins/bootstrap/dist/css/bootstrap.min.css')?>" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="<?=base_url('assets/plugins/font-awesome/css/font-awesome.min.css')?>" rel="stylesheet">
        <!-- NProgress -->
        <link href="<?=base_url('assets/plugins/nprogress/nprogress.css')?>" rel="stylesheet">
        <!-- Animate.css -->
        <link href="<?=base_url('assets/plugins/animate.css/animate.min.css')?>" rel="stylesheet">
        <!-- Custom Theme Style -->
        <link href="<?=base_url('assets/css/custom.min.css')?>" rel="stylesheet">
    </head>
    <body class="login">
        <div>
            <a class="hiddenanchor" id="signup"></a>
            <a class="hiddenanchor" id="signin"></a>
            <div class="login_wrapper">
                <div class="animate form login_form">
                    <section class="login_content">
                        <form action="#" method="post" id="login_form">
                            <h1>Login Form</h1>
                            <div>
                                <input type="text" name="username" class="form-control" placeholder="Username"/>
                            </div>
                            <div>
                                <input type="password" name="password" class="form-control" placeholder="Password"/>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-default" id="login">Log in</button>
                                <a class="reset_pass" href="#">Lost your password?</a>
                            </div>
                            <div class="clearfix"></div>
                            <div class="separator">
                                <p class="change_link">New to site?
                                    <a href="#signup" class="to_register"> Create Account </a>
                                </p>
                                <div class="clearfix"></div>
                                <br />
                                <div>
                                    <h1><i class="fa fa-paw"></i> Gentelella Alela!</h1>
                                    <p>©2016 All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template. Privacy and Terms</p>
                                </div>
                            </div>
                        </form>
                    </section>
                </div>
                <div id="register" class="animate form registration_form">
                    <section class="login_content">
                        <form action="#" method="POST" id="register_form">
                            <h1>Create Account</h1>
                            <div>
                                <input type="text" name="username" class="form-control" placeholder="Username" required/>
                            </div>
                            <div>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Password" required/>
                            </div>
                            <div>
                                <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" required/>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-default" id="register_submit">Submit</button>
                                <!-- <a class="btn btn-default submit" href="#" id="register_submit">Submit</a> -->
                            </div>
                            <div class="clearfix"></div>
                            <div class="separator">
                                <p class="change_link">Already a member ?
                                    <a href="#signin" class="to_register"> Log in </a>
                                </p>
                                <div class="clearfix"></div>
                                <br />
                                <div>
                                    <h1><i class="fa fa-paw"></i> Gentelella Alela!</h1>
                                    <p>©2016 All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template. Privacy and Terms</p>
                                </div>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
        <!-- jQuery -->
        <script src="<?=base_url('assets/plugins/jquery/dist/jquery.min.js')?>"></script>
        <!-- Bootstrap -->
        <script src="<?=base_url('assets/plugins/bootstrap/dist/js/bootstrap.min.js')?>"></script>
        <!-- validator -->
        <script src="<?=base_url('assets/plugins/jquery-validation/jquery.validate.min.js')?>"></script>    
        <!-- FastClick -->
        <script src="<?=base_url('assets/plugins/fastclick/lib/fastclick.js')?>"></script>
        <!-- NProgress -->
        <script src="<?=base_url('assets/plugins/nprogress/nprogress.js')?>"></script>
        <!-- Custom Theme Scripts -->
        <script src="<?=base_url('assets/js/custom.min.js')?>"></script>
        <script>
            $(document).ready(function() {
                $('#login_form').validate({
                    rules: {
                        username: {
                            required: true
                        },
                        password: {
                            required: true
                        }
                    },
                    submitHandler: function(form) {
                        $.ajax({
                            url: "<?=base_url('auth/do_login')?>",
                            type: 'post',
                            dataType: 'json',
                            data: $('#login_form').serializeArray(),
                            beforeSend: function() {},
                            success: function(data) {
                                $("#password").val('');
                                if (data.error == true) {
                                    alert(data.message);
                                } else {
                                    window.location.href = "<?=base_url('home')?>";
                                }
                            }

                        });
                    }
                });

                $('#register_form').validate({
                    rules: {
                        username: {
                            required: true,
                        },
                        password: {
                            required: true,
                            minlength: 8,
                            maxlength: 12,
                        },
                        confirm_password: {
                            minlength: 8,
                            maxlength: 12,
                            equalTo: "#password",
                        }

                    },
                    submitHandler: function(form) {
                        $.ajax({
                            url: "<?=base_url()?>",
                            type: 'post',
                            dataType: 'json',
                            data: $('#register_form').serializeArray(),
                            beforeSend: function() {},
                            success: function(data) {
                                $('#register_form')[0].reset();
                                alert(data.message);
                            }

                        });
                    }
                });
            }); 
        </script>
    </body>