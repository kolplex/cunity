<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>{-"Administration"|translate} - Cunity</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta name="apple-mobile-web-app-capable" content="yes" />

        <link rel="stylesheet" href="{-"siteurl"|setting}style/CunityRefreshed/css/bootstrap.min.css">
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
        <link href="{-"siteurl"|setting}style/CunityRefreshed/modules/Admin/css/cunity-admin.css" rel="stylesheet" />
        <script src="{-"siteurl"|setting}style/CunityRefreshed/javascript/jquery.min.js" type="text/javascript"></script>
        <script type="text/javascript">var modrewrite = {-$modrewrite}, siteurl = "{-"siteurl"|setting}", design = "CunityRefreshed", login = {-if empty($user)}false{-else}true{-/if};</script>
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
        <script src="{-"siteurl"|setting}style/CunityRefreshed/javascript/tmpl.min.js" type="text/javascript"></script>
        <script src="{-"siteurl"|setting}style/CunityRefreshed/javascript/bootbox.min.js" type="text/javascript"></script>
        <script src="{-"siteurl"|setting}style/CunityRefreshed/javascript/cunity-core.js" type="text/javascript"></script>
        {-$script_head}
        <script src="{-"siteurl"|setting}style/CunityRefreshed/javascript/html5shiv.min.js"></script>
        <script src="{-"siteurl"|setting}style/CunityRefreshed/javascript/respond.min.js"></script>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>

    <body>
        <div id="wrapper">

            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                        <span class="sr-only">{-"Toggle navigation"|translate}</span><i class="fa fa-bars"></i>
                    </button>
                    <a class="navbar-brand" href="{-"siteurl"|setting}admin">{-"sitename"|setting}</a>
                </div>
                <!-- /.navbar-header -->

                <ul class="nav navbar-top-links navbar-right">
                    {-*<li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-envelope fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                    <li>
                    <a href="#">
                    <div>
                    <strong>John Smith</strong>
                    <span class="pull-right text-muted">
                    <em>Yesterday</em>
                    </span>
                    </div>
                    <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                    </a>
                    </li>                            
                    </ul>
                    <!-- /.dropdown-messages -->
                    </li>
                    <!-- /.dropdown -->
                    <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-tasks fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-tasks">
                    <li>
                    <a href="#">
                    <div>
                    <p>
                    <strong>Task 1</strong>
                    <span class="pull-right text-muted">40% Complete</span>
                    </p>
                    <div class="progress progress-striped active">
                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                    <span class="sr-only">40% Complete (success)</span>
                    </div>
                    </div>
                    </div>
                    </a>
                    </li>                            
                    </ul>
                    <!-- /.dropdown-tasks -->
                    </li>
                    <!-- /.dropdown -->
                    <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-bell fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                    <li>
                    <a href="#">
                    <div>
                    <i class="fa fa-comment fa-fw"></i> New Comment
                    <span class="pull-right text-muted small">4 minutes ago</span>
                    </div>
                    </a>
                    </li>                            
                    </ul>
                    <!-- /.dropdown-alerts -->
                    </li>
                    <!-- /.dropdown -->*}
                    <li>
                        <a href="{-"siteurl"|setting}" data-title="{-"Back to your cunity"|translate}" class="tooltip-trigger" data-placement="left">
                            {-"Back to your Cunity"|translate}&nbsp;<i class="fa fa-sign-out fa-fw"></i>
                        </a>                        
                        <!-- /.dropdown-user -->
                    </li>
                    <!-- /.dropdown -->
                </ul>
                <!-- /.navbar-top-links -->

            </nav>
            <!-- /.navbar-static-top -->

            <nav class="navbar-default navbar-static-side" role="navigation">
                <div class="sidebar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a data-cat="dashboard" data-page="dashboard"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="#" class="dropdown"><i class="fa fa-cogs fa-fw"></i> {-"Settings"|translate}<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a data-cat="settings" data-page="site">{-"Site"|translate}</a>
                                </li>
                                <li>
                                    <a data-cat="settings" data-page="users">{-"Users & Registration"|translate}</a>
                                </li>
                                <li>
                                    <a data-cat="settings" data-page="mail">{-"Mail"|translate}</a>
                                </li>                                                              
                                <li>
                                    <a data-cat="settings" data-page="pages">{-"Static pages"|translate}</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#" class="dropdown"><i class="fa fa-picture-o fa-fw"></i> {-"Appearance"|translate}<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">                              
                                {-*<li>
                                <a data-cat="appearance" data-page="menus">{-"Menus"|translate}</a>
                                </li>*}  
                                <li>
                                    <a data-cat="appearance" data-page="sidebar">{-"Right Sidebar"|translate}</a>
                                </li>  
                                <li>
                                    <a data-cat="appearance" data-page="layout">{-"Layout"|translate}</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#" class="dropdown"><i class="fa fa-sitemap fa-fw"></i> {-"Modules"|translate}<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a data-cat="modules" data-page="manage">{-"Manage Modules"|translate}</a>
                                </li>                               
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a data-cat="users" data-page="view"><i class="fa fa-group fa-fw"></i> {-"Userlist"|translate}</a>
                        </li>
                        <li>
                            <a href="#" class="dropdown"><i class="fa fa-envelope-o fa-fw"></i> {-"Newsletter & Contact"|translate}<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a data-cat="mailing" data-page="newsletter">{-"Newsletter"|translate}</a>
                                </li>                               
                                <li>
                                    <a data-cat="mailing" data-page="contact">{-"Contact"|translate}</a>
                                </li>                               
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#" class="dropdown"><i class="fa fa-bar-chart-o fa-fw"></i> {-"Statistics"|translate}<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a data-cat="statistics" data-page="reports">{-"Site Reports"|translate}</a>
                                </li>
                                <li>
                                    <a data-cat="statistics" data-page="events">{-"Events"|translate}</a>
                                </li>                                
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>  
                        <li>
                            <a data-cat="cunity" data-page="about"><img src="{-"siteurl"|setting}style/CunityRefreshed/img/cunity-logo-26.png" width="16px" height="16px">&nbsp;{-"About Cunity"|translate}</a>
                        </li>
                    </ul>
                    <!-- /#side-menu -->
                </div>
                <!-- /.sidebar-collapse -->
            </nav>
            <!-- /.navbar-static-side -->

            <div id="page-wrapper"></div>

            <footer id="cunity-copyright" class="visible-lg visible-md visible-print">
                <a href="http://www.cunity.net" class="pull-left"><img src="{-"siteurl"|setting}style/CunityRefreshed/img/cunity-logo-sm.gif"></a>
                <div class="pull-left" style="padding: 4px 10px;font-size: 13px"><small class="copyright">Powered by <a href="http://www.cunity.net" target="_blank">Cunity</a> - &copy; {-$smarty.now|date_format:"%Y"}<br>by <a href="http://www.smartinmedia.com" target="_blank">Smart In Media</a></small></div>
            </footer>

        </div>                                
        <script src="{-"siteurl"|setting}style/CunityRefreshed/modules/Admin/javascript/plugins/metisMenu/jquery.metisMenu.min.js"></script>
        <script src="{-"siteurl"|setting}style/CunityRefreshed/modules/Admin/javascript/cunity-admin.js"></script>
    </body>
</html>
