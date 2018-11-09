<div class="oauth-wrap">
    <div class="oauth-header">
        <div class="logo">
            <a href="<?=PATH?>"><img src="<?=get_option("website_logo_black", BASE.'assets/img/logo-black.png')?>"></a>
        </div>
        <div class="slogan">  <?=lang('great_tool_for_social_marketing')?></div>
    </div>
    <div class="oauth-form">
        <ul class="nav nav-tabs">
            <li class="active" style="width: 100%"><a style="border-right: none;" href="javascript:void(0);"> Register your account</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade in active">
                <div class="text-center" style="margin: 30px 0 40px;">
                    Your account has been registered successfully.
                </div>  
                <div class="text-center">
                    <a href="<?=cn("oauth/login")?>" class="btn btn-primary"> Start now</a>
                </div>
            </div>      
        </div>
    </div>
</div>