<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="siteurl" content="{-"siteurl"|setting}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="generator" content="Cunity -  your private social network">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <title>{-$meta.title|translate}&nbsp;|&nbsp;{-"sitename"|setting}</title>
        <link href="{-"siteurl"|setting}style/CunityRefreshed/css/bootstrap.min.css" rel="stylesheet">
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
        <link type="text/css" href="{-"siteurl"|setting}style/CunityRefreshed/css/style.css" rel="stylesheet" media="screen and (min-width:1024px)">
        <link type="text/css" href="{-"siteurl"|setting}style/CunityRefreshed/css/mobile.css" rel="stylesheet" media="screen and (max-width: 1023px)">
        <link href="{-"siteurl"|setting}style/CunityRefreshed/img/favicon-default.gif" rel="icon" type="image/x-icon">
        {-if !$css_head eq ""}
            <link rel="stylesheet" type="text/css" href="{-"siteurl"|setting}style/CunityRefreshed/css/cunity.min.css.php?files={-$css_head}">
        {-/if}
        <script src="{-"siteurl"|setting}style/CunityRefreshed/javascript/jquery.min.js" type="text/javascript"></script>
        <script type="text/javascript">var modrewrite = {-$modrewrite}, siteurl = "{-"siteurl"|setting}", design = "CunityRefreshed", login = {-if empty($user)}false{-else}true{-/if};</script>
        {-*        <script src="{-"siteurl"|setting}style/CunityRefreshed/javascript/jquery.touchSwipe.min.js"></script>*}
        <script src="{-"siteurl"|setting}style/CunityRefreshed/javascript/cunity-core.js" type="text/javascript"></script>        
        <script src="{-"siteurl"|setting}style/CunityRefreshed/javascript/bootbox.min.js" type="text/javascript"></script>
        <script src="{-"siteurl"|setting}style/CunityRefreshed/javascript/tmpl.min.js" type="text/javascript"></script>
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
        {-*<script src="{-"siteurl"|setting}style/CunityRefreshed/modules/Messages/javascript/chat.js" type="text/javascript"></script>        *}
        <script src="{-"siteurl"|setting}style/CunityRefreshed/javascript/example.js"></script>                
        <script src="{-"siteurl"|setting}style/CunityRefreshed/javascript/html5shiv.min.js"></script>
        <script src="{-"siteurl"|setting}style/CunityRefreshed/javascript/respond.min.js"></script>
        {-$script_head}
        <base href="{-"siteurl"|setting}data/uploads/{-"filesdir"|setting}/">        
    </head>
    <body>        
        <div class="head">
            <div class="content">
                <div class="headline pull-left"><a href="{-"siteurl"|setting}"><img src="http://cunity.net/img/logo.gif"></a></div>
                        {-if !empty($user)}
                    <ul class="head-menu list-unstyled list-inline pull-right">
                        <li class="tooltip-trigger" title="Logout"><a href="{-"index.php?m=register&action=logout"|URL}"><i class="fa fa-power-off"></i></a></li>
                        <li class="tooltip-trigger notification-link-general" title="Notifications"><a href="javascript:getNotification('general');"><i class="fa fa-bell"></i></a></li>
                        <li class="tooltip-trigger notification-link-friends" title="Friend Requests"><a href="javascript:getNotification('friends');"><i class="fa fa-group"></i></a></li>
                        <li class="tooltip-trigger notification-link-messages"title="New Messages"><a href="javascript:getNotification('messages');"><i class="fa fa-envelope"></i></a></li>
                    </ul>
                    <div class="dropdown-menu-arrow"></div>
                    <ul class="dropdown-menu" id="notification-dropdown"></ul>
                {-/if}
            </div>
        </div>
        <nav id="mobile-slide-nav">
            {-if !empty($user)}
                <ul class="head-menu list-unstyled list-inline">
                    <li><a href="#"><i class="fa fa-search"></i></a></li>
                    <li class="notification-link-general"><a href="javascript:getNotification('general');"><i class="fa fa-bell"></i></a></li>
                    <li class="notification-link-friends"><a href="javascript:getNotification('friends');"><i class="fa fa-group"></i></a></li>
                    <li class="notification-link-messages"><a href="javascript:getNotification('messages');"><i class="fa fa-envelope"></i></a></li>
                    <li><a href="{-"index.php?m=register&action=logout"|URL}"><i class="fa fa-power-off"></i></a></li>                                               
                </ul>   
                <section class="mini-profile clearfix" title="Your short profile">
                    <img src="{-$user.pimg|image:"user":"cr_"}" alt="{-"Your Profile"|translate}" class="pull-left img-rounded thumbnail">
                    <a href="{-"index.php?m=profile"|URL}" class="pull-left">{-$user.name}</a>
                </section>
                {-*<input type="text" class="form-control" id="searchinputfield" name="q" placeholder="{-"Search"|translate}" autocomplete="off">*}
            {-/if}
            <ul class="nav nav-list mobile-menu"><li><a href="{-"index.php?m=start"|URL}"><i class="fa fa-home fa-fw"></i> Startpage</a></li></ul>
            <footer>
                <small class="copyright">Powered by <a href="http://www.cunity.net" target="_blank">Cunity</a> &copy; {-$smarty.now|date_format:"%Y"} {-*<br>by <a href="http://www.smartinmedia.com" target="_blank">Smart In Media</a>*}</small>
                <ul class="footer-menu list-unstyled">
                    <li><a href="{-"index.php?m=pages&action=legalnotice"|URL}">{-"Legal-Notice"|translate}</a></li>
                    <li><a href="{-"index.php?m=pages&action=privacy"|URL}">{-"Privacy"|translate}</a></li>
                    <li><a href="{-"index.php?m=pages&action=terms"|URL}">{-"Terms and Conditions"|translate}</a></li>
                    <li><a href="{-"index.php?m=contact"|URL}">{-"Contact"|translate}</a></li>
                </ul>
            </footer>
        </nav>
        <div class="mobile-page-wrapper">
            <div class="mobile-head clearfix dropdown">
                {-*<button class="btn btn-primary pull-left"><i class="fa fa-bars"></i></button>*}
                <div style="overflow:hidden;" class="pull-left">
                    <i id="menu-trigger" class="fa fa-bars"><img src="{-"siteurl"|setting}style/CunityRefreshed/img/cunity-logo-26.gif"></i>                
                </div>
                <h1 class="pull-left">{-$meta.title|translate}</h1>
                {-if !empty($user)}
                    <i data-toggle="dropdown" data-target="#option-drop" class="fa fa-ellipsis-v pull-right"></i>
                    {-*<button class="btn btn-primary pull-right"><i class="fa fa-search"></i></button>            *}            
                    <ul class="dropdown-menu" role="menu" aria-labelledby="option-drop" id="option-drop">
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Action</a></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Another action</a></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Something else here</a></li>
                        <li role="presentation" class="divider"></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Separated link</a></li>
                    </ul>
                {-/if}
            </div>
            <div class="head-shadow"></div>        
            <div class="main clearfix">
                <div class="sidebar pull-left left-sidebar">
                    {-if !empty($user)}
                        <section class="mini-profile clearfix" title="Your short profile">
                            <img src="{-$user.pimg|image:"user":"cr_"}" alt="{-"Your Profile"|translate}" class="pull-left img-rounded thumbnail">
                            <a href="{-"index.php?m=profile"|URL}" class="pull-left">{-$user.name}</a>
                        </section>
                        <section title="{-"Search"|translate}" class="sidebar-search">
                            <form action="{-"index.php?m=search"|URL}" method="get" onsubmit="return ($('#searchinputfield').val().length > 0);">
                                <div class="input-group" style="width:199px">
                                    <input type="text" class="form-control" id="searchinputfield" name="q" placeholder="{-"Search"|translate}" autocomplete="off">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="submit"><i class="fa fa-search fa-fw"></i></button>
                                    </span>
                                </div>
                            </form>   
                        </section>
                        <section class="main-menu">
                            <ul class="nav nav-list">
                                {-foreach $menu->getMainMenu()  AS $menuItem}
                                    {-if $menuItem.type=="module"}
                                        <li class="{-if $meta.module eq $menuItem.content}active{-/if} main-menu-item-{-$menuItem.content}"><a href="{-"index.php?m={-$menuItem.content}"|URL}"><i class="fa fa-{-$menuItem.iconClass} fa-fw"></i> {-$menuItem.title|translate}<span class="badge pull-right"></span></a></li>
                                            {-else if $menuItem.type == "page"}
                                        <li class="{-if $meta.module eq $menuItem.content}active{-/if} main-menu-item-{-$menuItem.content}"><a href="{-"index.php?m=pages&action={-$menuItem.content}"|URL}"><i class="fa fa-{-$menuItem.iconClass} fa-fw"></i> {-$menuItem.title|translate}<span class="badge pull-right"></span></a></li>
                                            {-else}
                                        <li class=""><a href="{-$content}"><i class="fa fa-{-$menuItem.iconClass} fa-fw"></i> {-$menuItem.title}<span class="badge pull-right"></span></a></li>
                                            {-/if}
                                        {-/foreach}
                                        {-if !empty($user) && $user->isAdmin()}
                                    <li class="divider"></li>
                                    <li><a href="{-"index.php?m=admin"|URL}"><i class="fa fa-cogs"></i> Administration</a></li>
                                    {-/if}
                            </ul>
                        </section>
                    {-else}
                        <section title="Login" class="login-sidebar">
                            <h3><i class="fa fa-sign-in fa-fw"></i>&nbsp;{-"Login"|translate}</h3>
                            <form class="form-horizontal sidebar-login-form" role="form"  style="margin-bottom:10px" action="{-"index.php?m=register&action=login"|URL}" method="post">
                                <div class="form-group">
                                    <label for="inputEmail1" class="sr-only">Email</label>
                                    <input type="email" class="form-control" name="email" placeholder="Email">
                                </div>
                                <div class="form-group" style="margin-bottom:0;">
                                    <label for="inputPassword1" class="sr-only">{-"Password"|translate}</label>
                                    <input type="password" class="form-control" name="password" placeholder="{-"Password"|translate}">
                                    <a class="help-block" style="margin-bottom:0;" href="{-"index.php?m=register&action=forgetPw"|URL}">{-"I forgot my password"|translate}</a>
                                </div>
                                <div class="form-group">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="save-login"> {-"Remember me"|translate}
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary pull-right">{-"Log in"|translate}</button>
                                </div>
                            </form>
                        </section>
                    {-/if}
                    <footer>
                        <small class="copyright">Powered by <a href="http://www.cunity.net" target="_blank">Cunity</a> &copy; {-$smarty.now|date_format:"%Y"} {-*<br>by <a href="http://www.smartinmedia.com" target="_blank">Smart In Media</a>*}</small>
                        <ul class="footer-menu list-unstyled">
                            {-foreach $menu->getFooterMenu()  AS $menuItem}
                                {-if $menuItem.type=="module"}
                                    <li><a href="{-"index.php?m={-$menuItem.content}"|URL}">{-$menuItem.title|translate}</a></li>
                                    {-else if $menuItem.type == "page"}
                                    <li><a href="{-"index.php?m=pages&action={-$menuItem.content}"|URL}">{-$menuItem.title|translate}</a></li>
                                    {-else}
                                    <li><a href="{-$content}">{-$menuItem.title|translate}</a></li>
                                    {-/if}
                                {-/foreach}
                        </ul>
                    </footer>
                </div>
                <div class="content pull-left">                    
                    {-include file="$tpl_name"}
                    {-if empty($user)}
                        <section title="Login" class="mobile-login">                            
                            <form class="form-horizontal sidebar-login-form" role="form"  style="margin-bottom:10px" action="{-"index.php?m=register&action=login"|URL}" method="post">
                                <div class="form-group">
                                    <label for="inputEmail1" class="sr-only">Email</label>
                                    <input type="email" class="form-control" name="email" placeholder="Email">
                                </div>
                                <div class="form-group" style="margin-bottom:0;">
                                    <label for="inputPassword1" class="sr-only">{-"Password"|translate}</label>
                                    <input type="password" class="form-control" name="password" placeholder="{-"Password"|translate}">
                                    <a class="help-block" style="margin-bottom:0;" href="{-"index.php?m=register&action=forgetPw"|URL}">{-"I forgot my password"|translate}</a>
                                </div>
                                <div class="form-group">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="save-login"> {-"Remember me"|translate}
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block">{-"Log in"|translate}</button>
                                </div>
                            </form>
                        </section>
                    {-/if}
                </div>
                <div class="sidebar pull-right right-sidebar">
                    {-if !empty($user)}
                        <section title="{-"Announcements"|translate}" style="min-height: 500px;">
                            <h3><i class="fa fa-bullhorn fa-fw"></i>&nbsp;{-"Announcements"|translate}</h3>
                            <div class="panel panel-danger">
                                <div class="panel-heading">
                                    Important!
                                </div>
                                <div class="panel-body">Here you can publish infos for your users</div>
                            </div>
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    Just an information
                                </div>
                                <div class="panel-body">Just tell users what is going on!</div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Just a notice
                                </div>
                                <div class="panel-body">This is Cunity <3</div>
                            </div>
                        </section>
                    {-/if}
                </div>
            </div>                    
        </div>
        {-if !empty($user) && false}
            <div id="chat-container" class="clearfix">
                <div class="chat-active"></div>
                {-*<div class="chat-control pull-right">
                <div class="input-group">
                <input type="search" class="form-control" placeholder="{-"Search for Chat"|translate}">
                <div class="input-group-btn dropdown dropup">                            
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cogs"></i></button>
                <ul class="dropdown-menu" role="menu">
                {-*<li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="closeChatWindows();"><i class="fa fa-times"></i>&nbsp;{-"Close all chat windows"|translate}</a></li>
                {-*<li class="divider"></li>
                <li><a href="disableChat();"><i class="fa fa-power-off"></i>&nbsp;{-"Deactivate Chat"|translate}</a></li>
                </ul>
                </div>
                </div>
                </div>*}
                <ul class="chat-list dropdown-menu">
                    <li role="presentation" class="chat-controls">                                                
                        <div class="btn-group dropdown dropup">                                                 
                            <button class="btn btn-default" style="width:147px"><i class="fa fa-circle" style="color:#4cae4c;font-size: 12px;"></i>Online</button>                                
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cogs"></i></button>
                            <ul class="dropdown-menu" role="menu">
                                {-*<li><a href="#">Action</a></li>
                                <li><a href="#">Another action</a></li>*}
                                <li><a href="closeChatWindows();"><i class="fa fa-times"></i>&nbsp;{-"Close all chat windows"|translate}</a></li>
                                    {-*<li class="divider"></li>*}
                                <li><a href="disableChat();"><i class="fa fa-power-off"></i>&nbsp;{-"Deactivate Chat"|translate}</a></li>
                            </ul>
                        </div>
                        </div>
                    </li>    
                </ul>
            </div>
        {-/if}

        <div class="modal fade" id="infoModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Info Box</h4>
                    </div>
                    <div class="modal-body"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">{-"Close"|translate}</button>
                    </div>
                </div>
            </div>
        </div>     
        <script id="onlinefriends" type="text/html">        
        <li role="presentation" class="online-friend-item">
            <a role="menuitem" tabindex="-1" href="javascript:chat({%=o.userid%});" class="clearfix">
                <img src="{%=checkImage(o.pimg,'user','cr_')%}" class="img-rounded">
                <span>{%=o.name%}</span>
                <i class="online-friend-item-status fa fa-circle pull-right"></i>
            </a>
        </li>    
    </script>
    <script id="notification-friends" type="text/html">
        <li>
            <div class="notification-friends-item clearfix">
                <img alt="{%=o.name%}" src="{%=checkImage(o.pimg,'user','cr_')%}" class="img-rounded">
                <a href="{-"index.php?m=profile&action="|URL}{%=o.username%}" class="notification-friends-item-name">{%=o.name%}</a>
                <div class="btn-group btn-group-xs">
                    <a class="btn btn-primary" data-userid="{%=o.userid%}" data-action="confirmfriend" data-toggle="modal" data-target="#relationship-modal"><i class="fa fa-question"></i>&nbsp;{-"Answer"|translate}</a>                    
                </div>                        
            </div>
        </li>
    </script>
    <script id="notification-general" type="text/html">
        <li>
            <div class="notification-messages-item notification-general-item clearfix" data-id="{%=o.id%}">
                <img alt="{%=o.name%}" src="{%=checkImage(o.pimg,'user','cr_')%}" class="img-rounded pull-left">
                <div class="pull-left" style="margin-left:5px;">
                    <a href="{-"index.php?m=profile&action="|URL}{%=o.username%}" class="notification-messages-item-name">{%=o.name%}{% if (o.unread == 1) { %}&nbsp;<span class="label label-new label-primary">{-"new"|translate}</span>{% } %}</a><br>
                    <span class="notification-messages-item-time" style="top:2px;">{%#convertDate(o.time)%}</span>
                    <span class="notification-messages-item-preview">{%=o.message%}</span>
                </div>
            </div>
        </li>    
    </script>
    <script id="notification-empty" type="text/html">
        <li class="alert alert-block alert-danger notification-empty-alert">{-"Nothing new!"|translate}</li>
    </script>
    <script id="notification-messages" type="text/html">
        <li>
            <div class="notification-messages-item clearfix">
                <img alt="{%=o.name%}" src="{%=o.image%}" class="img-rounded pull-left">
                <div class="pull-left" style="margin-left:5px;">
                    <a href="{-"index.php?m=messages&action="|URL}{%=o.conversation%}" class="notification-messages-item-name">{%=o.name%}</a><br>
                    <span class="notification-messages-item-time">{%#convertDate(o.time)%}</span>
                    <span class="notification-messages-item-preview">{%#o.message%}</span>
                </div>
            </div>
        </li>        
    </script>
    <script id="like" type="text/html"><a href="{-"index.php?m=profile&action="|URL}{%=o.username%}"><img class="img-rounded tooltip-trigger" title="{%=o.name%}" src="{%=checkImage(o.filename,'user','cr_')%}" data-container="body"></a></script>
    <script id="like-list" type="text/html"><a href="{-"index.php?m=profile&action="|URL}{%=o.username%}" class="tooltip-trigger likelist-item" data-title="{%=o.name%}"><img alt="{%=o.name%}" src="{%=checkImage(o.filename,'user','cr_')%}" class="thumbnail"></a></script>
            {-include file="Friends/relation-modal.tpl"}
            {-include file="Search/livesearch.tpl"}
            {-include file="Messages/message-modal.tpl"}

</body>
</html>