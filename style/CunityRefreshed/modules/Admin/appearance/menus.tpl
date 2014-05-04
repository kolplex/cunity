<script src="{-"siteurl"|setting}style/CunityRefreshed/javascript/jquery-ui-1.10.4.custom.min.js"></script>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">{-"Design & Menu"|translate}<button class="btn btn-success pull-right saveButton"><i class="fa fa-save"></i>&nbsp;{-"Save"|translate}</button></h1>
        <ol class="breadcrumb">
            <li><a href="{-"siteurl"|setting}admin"><i class="fa fa-home"></i></a></li>
            <li class="active">{-"Settings"|translate}</li>
            <li class="active">{-"Design"|translate}</li>
        </ol>
    </div>
</div>          
<div class="row">    
    <div class="col-lg-8">        
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-list fa-fw"></i>&nbsp;{-"Menu"|translate}
                <span class="pull-right text-success hidden panel-feedback-success"><i class="fa fa-check"></i>&nbsp;{-"Changes Saved"|translate}</span>
                <span class="pull-right text-danger hidden panel-feedback-error"><i class="fa fa-warning"></i>&nbsp;{-"An error occurred"|translate}</span>
            </div>
            <div class="panel-body">
                <div class="clearfix">
                    <div class="pull-left panel-group panel-menu" id="menu-add">                        
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#menu-add" href="#menu-add-modules">
                                        <i class="fa fa-sitemap"></i>&nbsp;{-"Add a module"|translate}
                                    </a>
                                </h4>
                            </div>
                            <div id="menu-add-modules" class="panel-collapse collapse in">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <a></a>
                                    </li>
                                    <li class="list-group-item">
                                        <a></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#menu-add" href="#menu-add-pages">
                                        <i class="fa fa-files-o"></i>&nbsp;{-"Add a page"|translate}
                                    </a>
                                </h4>
                            </div>
                            <div id="menu-add-pages" class="panel-collapse collapse">
                                <ul class="list-group"></ul>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#menu-add" href="#menu-add-custom">
                                        <i class="fa fa-link"></i>&nbsp;{-"Add a custom Link"|translate}
                                    </a>
                                </h4>
                            </div>
                            <div id="menu-add-custom" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <form class="form">
                                        <div class="form-group">
                                            <input type="text" class="form-control input-sm" placeholder="{-"Title"|translate}">
                                        </div><div class="form-group">
                                            <input type="url" class="form-control input-sm" placeholder="{-"URL (e.g. http://www.example.com)"|translate}">
                                        </div><div class="form-group clearfix">                                       
                                            <div class="btn-group btn-group-justified">
                                                <div class="btn-group btn-group-sm">
                                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                                        <span id="select-icon-toggle" data-orig="{-"Select an icon"|translate}">&nbsp;{-"Select an icon"|translate}</span>
                                                        <span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu" role="menu" id="select-icon-menu"></ul>
                                                </div>                                                     
                                            </div>  
                                        </div><div class="form-group clearfix">
                                            <select class="form-control pull-left input-sm" style="width:60%">
                                                <option>{-"Select Menu"|translate}...</option>
                                                <option>{-"Main-Menu"|translate}</option>
                                                <option>{-"Footer-Menu"|translate}</option>
                                            </select>
                                            <button class="pull-right btn btn-primary btn-sm"><i class="fa fa-plus"></i>&nbsp;{-"Add item"|translate}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <div class="pull-left panel-primary panel panel-menu">
                        <div class="panel-heading">
                            {-"Main-Menu"|translate}
                        </div>
                        <ul class="list-group sortable-list" id="main-menu-list">
                            <li class="list-group-item">asdfghjklöä</li>
                            <li class="list-group-item">234567890</li>
                        </ul>
                    </div>
                    <div class="pull-left panel panel-default panel-menu">
                        <div class="panel-heading">
                            {-"Footer-Menu"|translate}
                        </div>
                        <ul class="list-group sortable-list" id="footer-menu-list">
                            <li class="list-group-item">.,hgregfbhh</li>
                            <li class="list-group-item">3478kjhsfghjk</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>     
    </div>
</div>               
<script id="pages-list-item" type="text/html">
    <li class="list-group-item">
        <a href="{-"index.php?m=pages&action="|URL}{%=o.shortlink%}">{%#o.title%}</a>
        <div class="btn-group btn-group-xs pull-right">
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-chevron-down"></i>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li><a href="javascript:addMainItem('page','{%=o.shortlink%}','{%=o.title%}');"><i class="fa fa-plus"></i>&nbsp;{-"Add to Main-Menu"|translate}</a></li>
                <li><a href="javascript:addFooterItem('page','{%=o.shortlink%}','{%=o.title%}');"><i class="fa fa-plus"></i>&nbsp;{-"Add to Footer-Menu"|translate}</a></li>
            </ul>
        </div>
    </li>
</script>
<script id="menu-item" type="text/html">
    <li class="list-group-item">
        <strong><i class="fa fa-"></i>&nbsp;{%=o.title%}</strong>
    </li>
</script>