<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Login - Cunity Administration</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <link rel="stylesheet" href="{-"siteurl"|setting}style/CunityRefreshed/css/bootstrap.min.css">
        <link rel="stylesheet" href="{-"siteurl"|setting}style/CunityRefreshed/modules/Admin/css/login.css">
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.0/css/font-awesome.css" rel="stylesheet">
        <script src="//code.jquery.com/jquery-1.9.1.js" type="text/javascript"></script>
        <script src="{-"siteurl"|setting}style/CunityRefreshed/javascript/cunity-core.js" type="text/javascript"></script>
        <script src="{-"siteurl"|setting}style/CunityRefreshed/javascript/bootstrap.min.js"></script>
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
        <div class="container">
            <div class="logo">
                <img src="{-"siteurl"|setting}style/CunityRefreshed/img/cunity-logo.gif">
            </div><!-- /logo -->
            <div class="login-container">
                <p>{-"Please confirm your login to enter the admin-panel!"|translate}</p>
                {-if !$message eq ""}
                    <div class="alert alert-block alert-danger">{-$message}</div>
                {-/if}
                <form action="{-"index.php?m=admin&action=login"|URL}" method="post" class="form-horizontal">
                    <div class="form-group">
                        <label class="control-label sr-only" for="email">Your Name</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                            <input type="text" id="email" name="email" placeholder="Email" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label sr-only" for="password">Password</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-key"></i></span>
                            <input type="password" id="password" name="password" placeholder="{-"Password"|translate}" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary btn-large pull-right">{-"Sign In"|translate}</button>
                    </div> <!-- .actions -->
                </form>
            </div> <!-- /account-container -->
            <!-- Text Under Box -->
            <div class="login-extra">
                <a href="{-"siteurl"|setting}"><i class="fa fa-angle-double-left"></i>&nbsp;{-"Back to your Cunity"|translate}</a>
            </div> <!-- /login-extra -->
        </div>
    </body>
</html>