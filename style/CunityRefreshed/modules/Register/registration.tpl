<div class="page-buttonbar">
    <h1 class="page-header">{-"Registration"|translate}</h1>
</div>
{-if $success}
    <div class="alert alert-block alert-success"><h4 class="alert-heading">{-"Ready!"|translate}</h4><p>{-"We have sent you an activation link to your email to confirm your address!"|translate}</p></div>
        {-else}    
    <form class="form-horizontal registration-form" action="{-"index.php?m=register&action=sendRegistration"|URL}" method="POST" onsubmit="return checkRegistration();">
        <div class="form-group {-if !empty($error_messages.username)}has-feedback has-error{-/if}">
            <label class="control-label col-lg-4" for="input-username">{-"Username"|translate}</label>
            <div class="col-lg-8">
                <input type="text" class="form-control" id="input-username" placeholder="{-"Username"|translate}" name="username" value="{-$values.username}">
                <span class="fa fa-exclamation-triangle form-control-feedback"></span>
                <span class="help-block">{-$error_messages.username}</span>
            </div>
        </div>
        <div class="form-group {-if !empty($error_messages.email)}has-feedback has-error{-/if}">
            <label class="control-label col-lg-4" for="input-email">{-"E-Mail"|translate}</label>
            <div class="col-lg-8">
                <input type="email" class="form-control" id="input-email" placeholder="{-"E-Mail"|translate}" name="email" value="{-$values.email}">
                <span class="fa fa-exclamation-triangle form-control-feedback"></span>
                <span class="help-block">{-$error_messages.email}</span>
            </div>
        </div>
        {-if "fullname"|setting}
            <div class="form-group {-if !empty($error_messages.firstname)}has-feedback has-error{-/if}">
                <label class="control-label col-lg-4" for="input-firstname">{-"Firstname"|translate}</label>
                <div class="col-lg-8">
                    <input type="text" class="form-control" id="input-firstname" placeholder="{-"Firstname"|translate}" name="firstname" value="{-$values.firstname}">                    
                    <span class="fa fa-exclamation-triangle form-control-feedback"></span>
                    <span class="help-block">{-$error_messages.firstname}</span>
                </div>
            </div>
            <div class="form-group {-if !empty($error_messages.lastname)}has-feedback has-error{-/if}">
                <label class="control-label col-lg-4" for="input-lastname">{-"Lastname"|translate}</label>
                <div class="col-lg-8">
                    <input type="text" class="form-control" id="input-lastname" placeholder="{-"Lastname"|translate}" name="lastname" value="{-$values.lastname}">
                    <span class="fa fa-exclamation-triangle form-control-feedback"></span>
                    <span class="help-block">{-$error_messages.lastname}</span>
                </div>
            </div>
        {-/if}
        <div class="form-group {-if !empty($error_messages.password)}has-feedback has-error{-/if}">
            <label class="control-label col-lg-4" for="input-password">{-"Password"|translate}</label>
            <div class="col-lg-8">
                <input type="password" class="form-control" id="input-password" placeholder="{-"Password"|translate}" name="password" value="{-$values.password}">
                <span class="fa fa-exclamation-triangle form-control-feedback"></span>
                <span class="help-block">{-$error_messages.password}</span>
            </div>
        </div>
        <div class="form-group {-if !empty($error_messages.password)}has-feedback has-error{-/if}">
            <label class="control-label col-lg-4" for="input-password-repeat">{-"Repeat password"|translate}</label>
            <div class="col-lg-8">
                <input type="password" class="form-control" id="input-password-repeat" placeholder="{-"Repeat password"|translate}" name="password_repeat" value="{-$values.password_repeat}">
                <span class="fa fa-exclamation-triangle form-control-feedback"></span>
                <span class="help-block">{-$error_messages.password_repeat}</span>
            </div>
        </div>
        <div class="form-group {-if !empty($error_messages.sex)}has-feedback has-error{-/if}" style="margin-bottom:10px">
            <label class="control-label col-lg-4">{-"I am"|translate}</label>
            <div class="col-lg-8">
                <select class="form-control" name="sex">
                    <option value="">{-"Select your gender"|translate}</option>
                    <option value="f" {-if $values.sex=='f'}selected{-/if}>{-"Female"|translate}</option>
                    <option value="m" {-if $values.sex=='m'}selected{-/if}>{-"Male"|translate}</option>
                </select>
                <span class="help-block">{-$error_messages.sex}</span>
            </div>
        </div> 
        {-if "register_min_age"|setting > 0}
            <div class="form-group {-if !empty($error_messages.birthday)}has-feedback has-error{-/if}" style="margin-bottom:10px">
                <label class="control-label col-lg-4">{-"Birthday"|translate}</label>
                <div class="col-lg-8">
                    <input type="number" class="form-control" name="birthday[day]" value="{-$values.birthday.day}" maxlength="2" style="width:28%;display:inline-block;padding:6px" min="1" max="31" placeholder="dd">                 
                    <input type="number" class="form-control" name="birthday[month]" value="{-$values.birthday.month}" maxlength="2" style="width:28%;display:inline-block;padding:6px" min="1" max="12" placeholder="mm">
                    <input type="number" class="form-control" name="birthday[year]" value="{-$values.birthday.year}" maxlength="4" style="width:36%;display:inline-block;padding:6px" min="1900" max="{-$smarty.now|date_format:"%Y"}" placeholder="yyyy">

                    <span class="help-block">{-$error_messages.birthday}</span>
                </div>
            </div>
        {-/if}
        <div class="form-group" style="margin-bottom:0">
            <div class="col-lg-offset-4 col-lg-8">
                <button class="btn btn-primary btn-block pull-right" type="submit" data-loading-text="{-"Checking..."|translate}">{-"Register"|translate}</button>
            </div>
        </div>
    </form>
{-/if}