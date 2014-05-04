<link rel="stylesheet" href="{-"siteurl"|setting}style/CunityRefreshed/css/summernote.css">
<script src="{-"siteurl"|setting}style/CunityRefreshed/javascript/summernote.min.js"></script>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">{-"Mailing"|translate}
            <button class="btn btn-success pull-right saveButton"><i class="fa fa-save"></i>&nbsp;{-"Save"|translate}</button>
            <button class="btn btn-primary pull-right" onclick="sendTestMail();"><i class="fa fa-envelope"></i>&nbsp;{-"Send me a Testmail"|translate}</button>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{-"siteurl"|setting}admin"><i class="fa fa-home"></i></a></li>
            <li class="active">{-"Settings"|translate}</li>
            <li class="active">{-"Mailing"|translate}</li>
        </ol>
    </div>
</div>            
<div class="row">
    <div class="col-lg-6">        
        <div class="panel panel-default" id="smtp-panel">
            <div class="panel-heading">
                <i class="fa fa-envelope fa-fw"></i>&nbsp;{-"SMTP-Settings"|translate}
                <span class="pull-right text-success hidden panel-feedback-success"><i class="fa fa-check"></i>&nbsp;{-"Changes Saved"|translate}</span>
                <span class="pull-right text-danger hidden panel-feedback-error"><i class="fa fa-warning"></i>&nbsp;{-"An error occurred"|translate}</span>
            </div>
            <div class="panel-body ">
                <form class="form-horizontal ajaxform" method="post" action="{-"index.php?m=admin&action=save"|URL}">
                    <div class="form-group">
                        <label for="smtp-host" class="col-sm-4 control-label">{-"SMTP-Host"|translate}</label>
                        <div class="col-sm-8">
                            <input type="url" class="form-control" value="{-$config->mail->params->host}" id="smtp-host" name="config[mail][params][host]">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="smtp-port" class="col-sm-4 control-label">{-"SMTP-Port"|translate}</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" value="{-$config->mail->params->port}" id="smtp-port" name="config[mail][params][port]">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="smtp-auth" class="col-sm-4 control-label">{-"SMTP-Authentication"|translate}</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="smtp-auth" name="config[mail][params][auth]">

                                <option {-if $config->mail->params->auth eq "login"}selected{-/if} value="login">{-"Yes"|translate}</option>
                                <option {-if !$config->mail->params->auth eq "login"}selected{-/if}value="plain">{-"No"|translate}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="smtp-username" class="col-sm-4 control-label">{-"SMTP-Username"|translate}</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" value="{-$config->mail->params->username}" id="smtp-username" name="config[mail][params][username]">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="smtp-password" class="col-sm-4 control-label">{-"SMTP-Password"|translate}</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" value="{-$config->mail->params->password}" id="smtp-password" name="config[mail][params][password]">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="smtp-ssl" class="col-sm-4 control-label">{-"SMTP-Security"|translate}</label>
                        <div class="col-sm-8">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="config[mail][params][ssl]" {-if $config->mail->params->ssl eq "ssl"}checked{-/if} value="ssl">&nbsp;{-"Use SSL"|translate}
                                </label>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="form" value="config">                    
                    <input type="hidden" name="panel" value="smtp-panel">
                    <input class="ajaxform-callback" type="hidden" value="showPanelResult">
                </form>
            </div>            
        </div>     
    </div>
    <div class="col-lg-6">        
        <div class="panel panel-default" id="mailsender-panel">
            <div class="panel-heading">
                <i class="fa fa-user fa-fw"></i>&nbsp;{-"Sender"|translate}
                <span class="pull-right text-success hidden panel-feedback-success"><i class="fa fa-check"></i>&nbsp;{-"Changes Saved"|translate}</span>
                <span class="pull-right text-danger hidden panel-feedback-error"><i class="fa fa-warning"></i>&nbsp;{-"An error occurred"|translate}</span>
            </div>
            <div class="panel-body ">
                <form class="form-horizontal ajaxform" method="post" action="{-"index.php?m=admin&action=save"|URL}">
                    <div class="form-group">
                        <label for="mail-sendername" class="col-sm-4 control-label">{-"Sender-Name"|translate}</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" value="{-$config->mail->sendername}" id="mail-sendername" name="config[mail][sendername]">
                        </div>
                    </div>                 
                    <div class="form-group">
                        <label for="mail-senderaddress" class="col-sm-4 control-label">{-"Sender-Address"|translate}</label>
                        <div class="col-sm-8">
                            <input type="email" class="form-control" value="{-$config->mail->sendermail}" id="mail-senderaddress" name="config[mail][sendermail]">
                        </div>
                    </div>    
                    <input type="hidden" name="form" value="config">
                    <input type="hidden" name="panel" value="mailsender-panel">
                    <input class="ajaxform-callback" type="hidden" value="showPanelResult">
                </form>
            </div>
        </div>     
    </div>
    <div class="col-lg-12">        
        <div class="panel panel-default" id="mailtemplates-panel">
            <div class="panel-heading">
                <i class="fa fa-files-o fa-fw"></i>&nbsp;{-"Mail-Templates"|translate}
                <span class="pull-right text-success hidden panel-feedback-success"><i class="fa fa-check"></i>&nbsp;{-"Changes Saved"|translate}</span>
                <span class="pull-right text-danger hidden panel-feedback-error"><i class="fa fa-warning"></i>&nbsp;{-"An error occurred"|translate}</span>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <strong>{-"Mail-Header"|translate}</strong>
                        <div id="summernote-mail-header" class="loaderbox" data-source="{-"mail_header"|setting}"></div>
                    </div>
                    <div class="col-sm-6">
                        <strong>{-"Mail-Footer"|translate}</strong>
                        <div id="summernote-mail-footer" class="loaderbox" data-source="{-"mail_footer"|setting}"></div>
                    </div>
                </div>
                <form class="form-horizontal ajaxform" method="post" action="{-"index.php?m=admin&action=save"|URL}">
                    <input type="hidden" name="mail_header">
                    <input type="hidden" name="mail_footer">
                    <input type="hidden" name="form" value="mailtemplates">
                    <input type="hidden" name="panel" value="mailtemplates-panel">
                    <input class="ajaxform-callback" type="hidden" value="showPanelResult">
                </form>
            </div>
        </div>     
    </div>
</div>       