<div class="oauth-wrap">
    <div class="oauth-header">
        <div class="logo">
            <a href="<?=PATH?>"><img src="<?=get_option("website_logo_black", BASE.'assets/img/logo-black.png')?>"></a>
        </div>
        <div class="slogan"> <?=lang('great_tool_for_social_marketing')?></div>
    </div>
    <div class="oauth-form">
        <ul class="nav nav-tabs">
            <li><a href="<?=PATH."oauth/login"?>">  <?=lang('login')?></a></li>
            <li  class="active"><a href="javascript:void(0);">  <?=lang('signup')?></a></li>
        </ul>

        <div class="tab-content pb15">
            <form action="<?=cn('oauth/ajax_register')?>" data-redirect1="<?=cn('oauth/login')?>" class="actionForm" method="POST">
            <div class="tab-pane fade in active">
                <div class="form-group">
                    <label for="fullname"> <?=lang('fullname')?>:</label>
                    <input type="text" class="form-control" id="fullname" name="fullname">
                </div>
                <div class="form-group">
                    <label for="email"> <?=lang('email_address')?>:</label>
                    <input type="email" class="form-control" id="email" name="email">
                </div>
                <div class="form-group">
                    <label for="pwd"> <?=lang('password')?>:</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <div class="form-group">
                    <label for="rpwd"> <?=lang('confirm_password')?>:</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                </div>
                <div class="form-group">
                    <label for="pwd"> <?=lang('select_your_timezone')?>:</label>
                    <select name="timezone" class="form-control auto-select-timezone">
                        <?php if(!empty(tz_list())){
                        foreach (tz_list() as $value) {
                        ?>
                        <option value="<?=$value['zone']?>"><?=$value['time']?></option>
                        <?php }}?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-block"> <?=lang('get_started')?></button>
            </div>
            </form>     
        </div>
    </div>
</div>