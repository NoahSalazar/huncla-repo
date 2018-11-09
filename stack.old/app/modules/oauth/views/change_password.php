<div class="oauth-wrap">
    <div class="oauth-header">
        <div class="logo">
            <a href="<?=PATH?>"><img src="<?=get_option("website_logo_black", BASE.'assets/img/logo-black.png')?>"></a>
        </div>
        <div class="slogan">  <?=lang('great_tool_for_social_marketing')?></div>
    </div>
    <div class="oauth-form">
        <ul class="nav nav-tabs">
            <li class="active" style="width: 100%"><a style="border-right: none;" href="javascript:void(0);"> Enter new password</a></li>
        </ul>
        <form class="actionForm" action="<?=cn("oauth/ajax_change_password")?>">
        <div class="tab-content">
            <div class="tab-pane fade in active">
                <div class="form-group">
                    <label for="password"> Password:</label>
                    <input type="password" class="form-control" id="password" name="password">
                    <input type="hidden" class="form-control" id="reset_key" name="reset_key" value="<?=segment(3)?>">
                </div>
                <div class="form-group">
                    <label for="confirm_password">  Confirm password:</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                </div>
                <button type="submit" class="btn btn-success btn-block"> <?=lang('submit')?></button>
            </div>      
        </div>
        </form>
    </div>
</div>