<div class="oauth-wrap">
    <div class="oauth-header">
        <div class="logo">
            <a href="<?=PATH?>"><img src="<?=get_option("website_logo_black", BASE.'assets/img/logo-black.png')?>"></a>
        </div>
        <div class="slogan"> <?=lang('great_tool_for_social_marketing')?></div>
    </div>
    <div class="oauth-form">
        <ul class="nav nav-tabs">
            <li class="active <?=get_option("singup_enable", 1)?"":"w100"?>"><a href="javascript:void(0);"> <?=lang('login')?></a></li>
            <?php if(get_option("singup_enable", 1)){?>
            <li><a href="<?=PATH."oauth/signup"?>">  <?=lang('signup')?></a></li>
            <?php }?>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade in active">
                <form action="<?=cn('oauth/ajax_login')?>" data-redirect="<?=get("redirect")?cn(get("redirect")):cn('dashboard')?>" class="actionForm" method="POST">
                    <div class="form-group">
                        <label for="email"> <?=lang('email_address')?>:</label>
                        <input type="email" class="form-control" name="email" id="email">
                    </div>
                    <div class="form-group">
                        <label for="password"> <?=lang('password')?>:</label>
                        <input type="password" class="form-control" name="password" id="password">
                    </div>
                    <div class="checkbox">
                        <div class="pure-checkbox grey mr15 mb15">
                            <input type="checkbox" id="md_checkbox_schedule" name="remember" class="filled-in chk-col-red enable_instagram_schedule" value="on">
                            <label class="p0 m0" for="md_checkbox_schedule">&nbsp;</label>
                            <span class="checkbox-text-right"> <?=lang('remember')?></span>
                        </div>

                        <label class="pull-right"><a href="<?=PATH."oauth/forgot_password"?>"> <?=lang('forgot_password')?></a></label>
                    </div>
                    <button type="submit" class="btn btn-success btn-block"> <?=lang('login')?></button>
                </form>

                <?php
                $facebook_login = (int)get_option('facebook_oauth_enable', 0);
                $google_login = (int)get_option('google_oauth_enable', 0);
                $twitter_login = (int)get_option('twitter_oauth_enable', 0);
                $count_login = $facebook_login + $google_login + $twitter_login;
                $count_login = $count_login == 0?0:12/($count_login);
                ?>
                
                <div class="oauth-social mt15 <?=($count_login != 0)?"pb15":"";?>">
                    <?php if($facebook_login){?>
                    <div class="item col-md-<?=$count_login?> col-xs-<?=$count_login?> col-sm-<?=$count_login?>">
                        <a href="<?=PATH."oauth/facebook"?>" class="btn btn-default btn-block"><i class="fa fa-facebook" aria-hidden="true"></i> <?=lang('facebook')?> </a>
                    </div>
                    <?php }?>
                    <?php if($google_login){?>
                    <div class="item col-md-<?=$count_login?> col-xs-<?=$count_login?> col-sm-<?=$count_login?>">
                        <a href="<?=PATH."oauth/google"?>" class="btn btn-default btn-block"><i class="fa fa-google" aria-hidden="true"></i> <?=lang('google')?> </a>
                    </div>
                    <?php }?>
                    <?php if($twitter_login){?>
                    <div class="item col-md-<?=$count_login?> col-xs-<?=$count_login?> col-sm-<?=$count_login?>">
                        <a href="<?=PATH."oauth/twitter_oauth"?>" class="btn btn-default btn-block"><i class="fa fa-twitter" aria-hidden="true"></i> <?=lang('twitter')?> </a>
                    </div>
                    <?php }?>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</div>