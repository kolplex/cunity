<div class="page-buttonbar clearfix">
    <h1 class="page-header pull-left">{-"Events"|translate}</h1>        
    <button class="pull-right btn btn-primary" data-toggle="modal" data-target="#createEvent"><i class="fa fa-plus"></i>&nbsp;{-"Create Event"|translate}</button>
    <div class="btn-group pull-right" data-toggle="buttons">
        <label class="btn btn-default"><i class="fa fa-list"></i>&nbsp;{-"List"|translate}</label>
        <label class="btn btn-default active"><i class="fa fa-calendar"></i>&nbsp;{-"Calendar"|translate}</label>
    </div>
</div>
<div class="modal fade" id="createEvent" tabindex="-1" role="dialog" aria-labelledby="createEvent" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">{-"Create a new Event"|translate}</h4>
            </div>
            <div class="modal-body">
                <form id="createEventForm" class="form-horizontal ajaxform" role="form" action="{-"index.php?m=events&action=createEvent"|URL}" method="post">
                    <div class="form-group">
                        <label for="event-title" class="col-sm-2 control-label">{-"Title"|translate}</label>
                        <div class="col-sm-10">
                            <input type="text" name="title" id="event-title" class="form-control" placeholder="{-"e.g. Your Birthdayparty"|translate}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="event-description" class="col-sm-2 control-label">{-"Details"|translate}</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="event-description" name="description" placeholder="{-"Add more Information"|translate}"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="event-place" class="col-sm-2 control-label">{-"Place"|translate}</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="event-place" name="place" placeholder="{-"Where will your event take place?"|translate}"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="event-place" class="col-sm-2 control-label">{-"Date"|translate}</label>
                        <div class="col-sm-5">
                            <div class="input-group date"> 
                                <input type="text" class="form-control" placeholder="{-"Select a date"|translate}"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>                               
                            </div>
                            <input type="hidden" id="startDate" name="start">
                        </div>
                        <div class="col-sm-5">
                            <div class="input-group time"> 
                                <input type="text" class="form-control" placeholder="{-"Select a time"|translate}"><span class="input-group-addon"><i class="fa fa-clock-o"></i></span>                               
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="event-privacy" class="col-sm-2 control-label">{-"Privacy"|translate}</label>
                        <div class="col-sm-10">
                            <select id="event-privacy" name="privacy" class="form-control">
                                <option value="0">{-"Public"|translate}</option>
                                <option value="1">{-"Friends"|translate}</option>
                                <option value="2">{-"Invited Users"|translate}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="guest_invitation" value="1">&nbsp;{-"Guests can invite other users"|translate}
                                </label>
                            </div>
                        </div>
                    </div>                                
                    <input type="hidden" class="ajaxform-callback" value="eventCreated">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{-"Close"|translate}</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="$('#createEventForm').submit();">{-"Create"|translate}</button>
            </div>
        </div>
    </div>
</div>
<div class="calendar-head clearfix">
    <button class="btn btn-primary pull-left" data-calendar-nav="prev"><i class="fa fa-chevron-left"></i>&nbsp;{-"Prev"|translate}</button>
    <h2 class="calendar-month pull-left">April 2014</h2>
    <button class="btn btn-primary pull-right" data-calendar-nav="next">{-"Next"|translate}&nbsp;<i class="fa fa-chevron-right"></i></button>
</div>
<div id="calendar"></div>