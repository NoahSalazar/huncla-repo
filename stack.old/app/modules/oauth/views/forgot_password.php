<div class="oauth-wrap">
    <div class="oauth-header">
        <div class="logo">
            <a href="<?=PATH?>"><img src="<?=get_option("website_logo_black", BASE.'assets/img/logo-black.png')?>"></a>
        </div>
        <div class="slogan">  <?=lang('great_tool_for_social_marketing')?></div>
    </div>
    <div class="oauth-form">
        <ul class="nav nav-tabs">
            <li class="active" style="width: 100%"><a style="border-right: none;" href="javascript:void(0);"> <?=lang('password_recovery')?></a></li>
        </ul>
        <form class="actionForm" action="<?=cn("oauth/ajax_forgot_password")?>">
        <div class="tab-content pb15">
            <div class="tab-pane fade in active">
                <div class="form-group">
                    <label for="email">  <?=lang('email_address')?>:</label>
                    <input type="email" class="form-control" id="email" name="email">
                </div>
                <button type="submit" class="btn btn-success btn-block"> <?=lang('submit')?></button>
            </div>      
        </div>
        </form>
    </div>
</div>