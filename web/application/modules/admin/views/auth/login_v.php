<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Login | AppStart - Admin Template</title>
        <!-- Mobile specific metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <!-- Force IE9 to render in normal mode -->
        <!--[if IE]><meta http-equiv="x-ua-compatible" content="IE=9" /><![endif]-->
        <meta name="author" content="SuggeElson" />
        <meta name="description" content="AppStart admin template - new premium responsive admin template. This template is designed to help you build the site administration without losing valuable time.Template contains all the important functions which must have one backend system.Build on great twitter boostrap framework"
        />
        <meta name="keywords" content="admin, admin template, admin theme, responsive, responsive admin, responsive admin template, responsive theme, themeforest, 960 grid system, grid, grid theme, liquid, jquery, administration, administration template, administration theme, mobile, touch , responsive layout, boostrap, twitter boostrap"
        />
        <meta name="application-name" content="AppStart admin template" />
        <!-- Import google fonts - Heading first/ text second -->
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,400italic,700' rel='stylesheet' type='text/css'>
        <!-- Css files -->
        <!-- Icons -->
        <link href="<?=base_url()?>/assets/css/icons.css" rel="stylesheet" />
        <!-- Bootstrap stylesheets (included template modifications) -->
        <link href="<?=base_url()?>/assets/css/bootstrap.css" rel="stylesheet" />
        <!-- jQueryUI -->
        <link href="<?=base_url()?>/assets/css/appstart-theme/jquery.ui.all.css" rel="stylesheet" />
        <!-- Plugins stylesheets (all plugin custom css) -->
        <link href="<?=base_url()?>/assets/css/plugins.css" rel="stylesheet" />
        <!-- Main stylesheets (template main css file) -->
        <link href="<?=base_url()?>/assets/css/main.css" rel="stylesheet" />
        <!-- Custom stylesheets ( Put your own changes here ) -->
        <link href="<?=base_url()?>/assets/css/custom.css" rel="stylesheet" />
        <!-- Fav and touch icons -->
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="/assets/img/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/assets/img/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/assets/img/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="/assets/img/ico/apple-touch-icon-57-precomposed.png">
        <link rel="icon" href="/assets/img/ico/favicon.ico" type="image/png">
        <!-- Windows8 touch icon ( http://www.buildmypinnedsite.com/ )-->
        <meta name="msapplication-TileColor" content="#3399cc" />
    </head>
    <body class="login-page">
        <!-- Start #login -->
        <div id="login" class="animated bounceIn">
            <!-- img id="logo" src="/assets/img/logo.png" alt="appstart Logo" -->
			theDyas
            <!-- Start .login-wrapper -->
            <div class="login-wrapper">
                <ul id="myTab" class="nav nav-tabs nav-justified bn">
                    <li>
                        <a href="#log-in" data-toggle="tab">Login</a>
                    </li>
                </ul>
                <div id="myTabContent" class="tab-content bn">
                    <div class="tab-pane fade active in" id="log-in">
                        <!-- div class="social-buttons text-center mt25">
                            <a href="#" class="btn btn-primary btn-alt btn-round btn-lg mr10"><i class="fa fa-facebook s24"></i></a>
                            <a href="#" class="btn btn-primary btn-alt btn-round btn-lg mr10"><i class="fa fa-twitter s24"></i></a>
                            <a href="#" class="btn btn-danger btn-alt btn-round btn-lg mr10"><i class="fa fa-google-plus s24"></i></a>
                            <a href="#" class="btn btn-info btn-alt btn-round btn-lg"><i class="fa fa-linkedin s24"></i></a>
                        </div -->
                        <!--div class="seperator">
                            <strong>or</strong>
                            <hr>
                        </div -->
                        <form class="form-horizontal mt0" action="/auth/login_pro" id="login-form" role="form" method="POST">
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <input type="text" name="email" id="email" class="form-control left-icon" value="" placeholder="Your email ...">
                                    <i class="im-user s16 left-input-icon"></i>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <input type="password" name="pw" id="password" class="form-control left-icon" value="" placeholder="Your password">
                                    <i class="im-lock s16 left-input-icon"></i>
                                    <!-- span class="help-block"><a href="#"><small>Forgout password ?</small></a></span -->
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-8">
                                    <!-- col-lg-12 start here -->
                                    <!-- label class="checkbox">
                                        <input type="checkbox" name="remember" id="remember" value="option">Remember me ?
                                    </label -->
                                </div>
                                <!-- col-lg-12 end here -->
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-4 mb25">
                                    <!-- col-lg-12 start here -->
                                    <button class="btn btn-default pull-right" type="submit">Login</button>
                                </div>
                                <!-- col-lg-12 end here -->
                            </div>
                        </form>
                    </div>

                </div>
            </div>
            <!-- End #.login-wrapper -->
        </div>
        <!-- End #login -->
        <!-- Javascripts -->
        <!-- Important javascript libs(put in all pages) -->
        <script src="http://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script>
        window.jQuery || document.write('<script src="/assets/js/libs/jquery-2.1.1.min.js">\x3C/script>')
        </script>
        <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
        <script>
        window.jQuery || document.write('<script src="/assets/js/libs/jquery-ui-1.10.4.min.js">\x3C/script>')
        </script>
        <!--[if lt IE 9]>
  <script type="text/javascript" src="/assets/js/libs/excanvas.min.js"></script>
  <script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
  <script type="text/javascript" src="/assets/js/libs/respond.min.js"></script>
<![endif]-->
        <!-- Bootstrap plugins -->
        <script src="<?=base_url()?>/assets/js/bootstrap/bootstrap.js"></script>
        <!-- Form plugins -->
        <script src="<?=base_url()?>/assets/plugins/forms/icheck/jquery.icheck.js"></script>
        <script src="<?=base_url()?>/assets/plugins/forms/validation/jquery.validate.js"></script>
        <script src="<?=base_url()?>/assets/plugins/forms/validation/additional-methods.min.js"></script>
        <!-- Init plugins olny for this page -->
        <script src="<?=base_url()?>/assets/js/pages/login.js"></script>
    </body>
</html>
