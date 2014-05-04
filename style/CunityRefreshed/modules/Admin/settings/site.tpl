<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">{-"Site"|translate}<button class="btn btn-success pull-right saveButton"><i class="fa fa-save"></i>&nbsp;{-"Save"|translate}</button></h1>
        <ol class="breadcrumb">
            <li><a href="{-"siteurl"|setting}admin"><i class="fa fa-home"></i></a></li>
            <li class="active">{-"Settings"|translate}</li>
            <li class="active">{-"Site"|translate}</li>
        </ol>
    </div>
</div>          
<div class="row">
    <div class="col-lg-6">        
        <div class="panel panel-default" id="general-panel">
            <div class="panel-heading">
                <i class="fa fa-wrench fa-fw"></i>&nbsp;{-"General"|translate}
                <span class="pull-right text-success hidden panel-feedback-success"><i class="fa fa-check"></i>&nbsp;{-"Changes Saved"|translate}</span>
                <span class="pull-right text-danger hidden panel-feedback-error"><i class="fa fa-warning"></i>&nbsp;{-"An error occurred"|translate}</span>
            </div>
            <div class="panel-body">
                <form class="form-horizontal ajaxform" method="post" action="{-"index.php?m=admin&action=save"|URL}">
                    <div class="form-group">
                        <label for="cunity-name" class="col-sm-4 control-label">{-"Name of the Cunity"|translate}</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" value="{-"sitename"|setting}" id="cunity-name" name="settings-sitename">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="cunity-name" class="col-sm-4 control-label">{-"Url of the Cunity"|translate}</label>
                        <div class="col-sm-8">
                            <input type="url" class="form-control" placeholder="e.g. (http://www.example.com)" id="cunity-name" value="{-"siteurl"|setting}" name="settings-siteurl">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="cunity-description" class="col-sm-4 control-label">{-"Description for this Cunity"|translate}</label>
                        <div class="col-sm-8">
                            <textarea id="cunity-description" rows="3" class="form-control" name="settings-description">{-"description"|setting}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="contact-mail" class="col-sm-4 control-label">{-"Contact E-Mail"|translate}</label>
                        <div class="col-sm-8">
                            <input type="email" class="form-control" value="{-"contact_mail"|setting}" id="contact-mail" name="settings-contact_mail">
                        </div>
                    </div>
                    <input type="hidden" name="form" value="settings">
                    <input type="hidden" name="panel" value="general-panel">
                    <input class="ajaxform-callback" type="hidden" value="showPanelResult">
                </form>
            </div>
        </div>     
    </div>
    <div class="col-lg-6">        
        <div class="panel panel-default" id="language-panel">
            <div class="panel-heading">
                <i class="fa fa-globe fa-fw"></i>&nbsp;{-"Localization"|translate}
                <span class="pull-right text-success hidden panel-feedback-success"><i class="fa fa-check"></i>&nbsp;{-"Changes Saved"|translate}</span>
                <span class="pull-right text-danger hidden panel-feedback-error"><i class="fa fa-warning"></i>&nbsp;{-"An error occurred"|translate}</span>
            </div>
            <div class="panel-body ">
                <form class="form-horizontal ajaxform" method="post" action="{-"index.php?m=admin&action=save"|URL}">
                    <div class="form-group">
                        <label for="cunity-name" class="col-sm-4 control-label">{-"Language"|translate}</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="settings-language">
                                {-foreach $availableLanguages AS $language}
                                    {-if "lang"|setting eq $language[1]}
                                        <option value="{-$language[1]}" selected>{-$language[0]|translate}</option>
                                    {-else}
                                        <option value="{-$language[1]}">{-$language[0]|translate}</option>
                                    {-/if}
                                {-/foreach}
                            </select>
                        </div>
                    </div>         
                    <input type="hidden" name="form" value="settings">
                    <input type="hidden" name="panel" value="language-panel">
                    <input class="ajaxform-callback" type="hidden" value="showPanelResult">
                </form>
            </div>
        </div>     
        <div class="panel panel-default" id="theme-panel">
            <div class="panel-heading">
                <i class="fa fa-picture-o fa-fw"></i>&nbsp;{-"Theme"|translate}
                <span class="pull-right text-success hidden panel-feedback-success"><i class="fa fa-check"></i>&nbsp;{-"Changes Saved"|translate}</span>
                <span class="pull-right text-danger hidden panel-feedback-error"><i class="fa fa-warning"></i>&nbsp;{-"An error occurred"|translate}</span>
            </div>
            <div class="panel-body ">
                <form class="form-horizontal ajaxform" method="post" action="{-"index.php?m=admin&action=save"|URL}">
                    <div class="form-group">
                        <label for="cunity-name" class="col-sm-4 control-label">{-"Select a Theme"|translate}</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="settings-design">
                                {-foreach $availableDesigns AS $design}
                                    {-if "design"|setting eq $design[0]}
                                        <option value="{-$design[0]}" selected>{-$design[1]|translate}</option>
                                    {-else}
                                        <option value="{-$design[0]}">{-$design[1]|translate}</option>
                                    {-/if}
                                {-/foreach}
                            </select>
                        </div>
                    </div>         
                    <input type="hidden" name="form" value="settings">
                    <input type="hidden" name="panel" value="theme-panel">
                    <input class="ajaxform-callback" type="hidden" value="showPanelResult">
                </form>
            </div>
        </div>     
    </div>
</div>       