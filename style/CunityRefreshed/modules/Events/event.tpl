<div class="event-banner" style="background-image:url('http://lorempixel.com/970/250/nightlife/2/');">
    <div class="event-title-box clearfix">
        <div class="event-title-box-date pull-left" title="{-$event.date->format('d.m.Y')}">
            <span class="month">{-$event.date->format('M')}</span>
            <span class="day">{-$event.date->format('d')}</span>
        </div>
        <h1 class="pull-left">{-$event.title}</h1>        
    </div>
</div>
<ul class="nav nav-pills event-menu" id="event-menu">
    <li class="active"><a href="#Wall" data-toggle="pill"><i class="fa fa-rss"></i>&nbsp;{-"Wall"|translate}</a></li>
    <li class=""><a href="#Forum" data-toggle="pill" onclick="loadForum({-$event.id});"><i class="fa fa-bullhorn"></i>&nbsp;{-"Forum"|translate}</a></li>
    <li class=""><a href="#Guests" data-toggle="pill" onclick="loadGuests({-$event.id});"><i class="fa fa-users"></i>&nbsp;{-"Guests"|translate}&nbsp;<span class="badge">{-if count($event.guests.attending) > 0}{-count($event.guests.attending)}{-/if}</span></a></li>       
            {-if $user.userid eq $event.userid}
        <li class="pull-right hidden-sm hidden-xs"><a href="{-"index.php?m=profile&action=edit"|URL}" class="tab-no-follow"><i class="fa fa-wrench"></i>&nbsp;{-"Edit Event"|translate}</a></li>
        {-else}
        <li class="event-attending-buttons pull-right">
            <div class="btn-group">
                <button class="btn btn-default"><i class="fa fa-check"></i>&nbsp;{-"Attending"|translate}</button>
                <button class="btn btn-default dropdown-toggle" data-toggle="dropdown"><i class="fa fa-caret-down"></i></button>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Maybe</a></li>
                    <li><a href="#">Decline</a></li>
                    <li class="divider"></li>
                    <li><a href="#">{-"Remove invitation"|translate}</a></li>
                </ul>
            </div>
        </li>
    {-/if}
</ul>
<div class="tab-content">    
    <div class="tab-pane fade in clearfix active" id="Wall">                
        <div class="newsfeed-container pull-left">
            <form class="newsfeed-newpost ajaxform clearfix" action="{-"index.php?m=newsfeed&action=send"|URL}" method="post">
                <input type="hidden" id="newsfeed-owner-id" value="{-$event.id}">                     
                <input type="hidden" id="newsfeed-owner-type" value="event">                     
                <button class="btn btn-default pull-left newsfeed-post-option hidden-sm hidden-xs" type="button"><span class="fa fa-ellipsis-v fa"></span></button>
                <div class="btn-group-vertical pull-left hidden newsfeed-post-option-buttons hidden-sm hidden-xs">        
                    <button class="btn btn-default" type="button" onclick="postText();"><span class="fa fa-pencil fa-fw"></span></button>
                    <button class="btn btn-default" type="button" onclick="postImage();"><span class="fa fa-picture-o fa-fw"></span></button>
                </div>
                <input type="hidden" class="ajaxform-callback" value="sendPost">
                <input type="hidden" name="wall_owner_id" value="{-$event.id}">
                <input type="hidden" name="wall_owner_type" value="event">
                <input type="hidden" name="type" value="post">
                <input type="hidden" name="youtubedata" value="">
                <div class="pull-right clearfix newsfeed-post-area">
                    <textarea class="form-control" id="postmsg" name="content" placeholder="{-if $user.userid eq $profile.userid}{-"Anything new?"|translate}{-else}{-"Say Hello!"|translate}{-/if}"></textarea>        
                    <div class="pull-left newsfeed-post-file-input">
                        <span class="loader-small hidden"></span>
                        <button class="btn btn-primary hidden" id="newsfeed-upload" type="button"><i class="fa fa-upload"></i>&nbsp;{-"Select Photo"|translate}</button>
                    </div>
                    <div class="clearfix newsfeed-post-video-box hidden"></div>
                </div>        
                <div class="btn-group pull-right hidden newsfeed-post-buttons">                
                    <button class="btn btn-primary tooltip-trigger" type="button" data-title="{-$profile.name}&nbsp;{-"decides who is allowed to see this post!"|translate}"><span class="fa fa-lock"></span></button>                
                    <input type="hidden" name="privacy" value="{-if $profile.privacy.post eq 3}0{-else if $profile.privacy.post eq 1}1{-else}2{-/if}" id="postPrivacy">
                    <button class="btn btn-primary newsfeed-post-button" type="submit" id="newsfeed-post-button"><span class="fa fa-comment"></span>&nbsp;{-"Post"|translate}!</button>
                </div>   
            </form>
            {-include file="Newsfeed/newsfeed-templates.tpl"}
            <div class="newsfeed-postbox">
                <div id="newsfeed-posts"><div class="loader block-loader" id="newsfeed-loader"></div><div class="alert alert-danger alert-block hidden">{-"There are no posts to show"|translate}</div></div>                        
                <div class="newsfeed-postbox-load-more hidden"><a href="javascript:load();"><i class="fa fa-clock-o"></i>&nbsp;{-"Load more Posts"|translate}</a></div>
            </div>
        </div>
        <div class="sidebar right-sidebar profile-newsfeed-sidebar pull-right hidden-xs" style="display:block;">
            <section title="upcoming events" style="min-height: 500px;">
                <h3 class="sidebar-header"><i class="fa fa-filter fa-fw"></i>&nbsp;{-"Filter posts"|translate}</h3>                                
                <div class="btn-group btn-group-justified" data-toggle="buttons">
                    <label class="btn btn-default tooltip-trigger" data-title="{-"Show posts"|translate}">
                        <input type="checkbox" class="newsfeed-filter" value="post"><i class="fa fa-fw fa-comment"></i>
                    </label>
                    <label class="btn btn-default tooltip-trigger" data-title="{-"Show photos"|translate}">
                        <input type="checkbox" class="newsfeed-filter" value="image"><i class="fa fa-fw fa-picture-o"></i>
                    </label>
                    <label class="btn btn-default tooltip-trigger" data-title="{-"Show videos"|translate}">
                        <input type="checkbox" class="newsfeed-filter" value="video"><i class="fa fa-fw fa-film"></i>
                    </label>
                </div>
                <button class="btn btn-primary btn-sm btn-block" style="width:180px;margin-top:10px" onclick="applyFilter();">{-"Apply filter"|translate}</button>                                    
            </section>
        </div>    

    </div>
    <div class="tab-pane fade in clearfix" id="Forum">        
        <div class="pull-left" style="width: 570px;">
            {-include file="Forums/forum.tpl"}
        </div>
        <div class="sidebar right-sidebar pull-right hidden-xs" style="display:block;"></div>
    </div>
    <div class="tab-pane fade in clearfix" id="Guests">
        <div class="col-md-3">
            <div class="list-group">
                <a href="#guestsAttending" class="list-group-item active" data-toggle="tab">{-"Attending"|translate}&nbsp;<span class="badge">{-if count($event.guests.attending) > 0}{-count($event.guests.attending)}{-/if}</span></a>
                <a href="#guestsMaybe" class="list-group-item" data-toggle="tab">{-"Maybe"|translate}&nbsp;<span class="badge">{-if count($event.guests.maybe) > 0}{-count($event.guests.maybe)}{-/if}</span></a>
                <a href="#guestsInvited" class="list-group-item" data-toggle="tab">{-"Invited"|translate}&nbsp;<span class="badge">{-if count($event.guests.invited) > 0}{-count($event.guests.invited)}{-/if}</span></a>
            </div>
        </div>
        <div class="col-md-9 tab-content">
            <div class="tab-pane active panel panel-default" id="guestsAttending">
                <div class="panel-heading">
                    {-"Guests, who will come"|translate}
                </div>
                <div class="panel-body">

                </div>
            </div>            
            <div class="tab-pane panel panel-default" id="guestsMaybe">
                <div class="panel-heading">
                    {-"Guests, who will probably come"|translate}
                </div>
                <div class="panel-body">

                </div>
            </div>
            <div class="tab-pane panel panel-default" id="guestsInvited">
                <div class="panel-heading">
                    {-"Guests, who are invited"|translate}
                </div>
                <div class="panel-body">

                </div>
            </div>
        </div>
    </div>
</div>