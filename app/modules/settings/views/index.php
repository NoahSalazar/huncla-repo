
<div class="wrap-content container tab-list">
    <div class="lead"><a href="<?=cn('settings/general')?>" class="text-primary"><i class="fa fa-cog" aria-hidden="true"></i> <?=lang('general_settings')?></a> | <a href="<?=cn('settings/social')?>"><i class="fa fa-user-circle-o" aria-hidden="true"></i> <?=lang('social_settings')?></a></div>
    <form action="<?=PATH?>settings/ajax_settings" method="POST" class="actionForm">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header p0">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#general"><i class="ft-monitor" aria-hidden="true"></i> <?=lang('general')?>
                            <?php if(get_payment()){?>
                            <li><a data-toggle="tab" href="#payment"><i class="ft-credit-card" aria-hidden="true"></i> <?=lang('payment')?></a></li>
                            <?php }?>
                            <li><a data-toggle="tab" href="#oauth"><i class="ft-lock" aria-hidden="true"></i> <?=lang('oauth')?></a></li>
                            <li><a data-toggle="tab" href="#proxies"><i class="ft-shield" aria-hidden="true"></i> <?=lang('proxies')?></a></li>
                            <li><a data-toggle="tab" href="#file_manager"><i class="ft-folder" aria-hidden="true"></i> <?=lang('file_manager')?></a></li>
                            <li><a data-toggle="tab" href="#email"><i class="fa fa-envelope-o" aria-hidden="true"></i> <?=lang('mail')?></a></li>
                            <li><a data-toggle="tab" href="#social_page"><i class="ft-share-2" aria-hidden="true"></i> <?=lang('social_page')?></a></li>
                        	<li><a data-toggle="tab" href="#other"><i class="ft-sliders" aria-hidden="true"></i> <?=lang('other')?></a></li>
                        </ul>
                    </div>
                    <div class="card-block p0">
                        <div class="tab-content p15">
                            <div id="general" class="tab-pane fade in active">
                                <div class="row">
                                    <div class="col-md-12">
                                        <span class="text"> <?=lang('dark_menu')?></span><br/>
                                        <div class="pure-checkbox grey mr15 mb15">
                                            <input type="radio" id="md_checkbox_dark_menu_enable" name="dark_menu" class="filled-in chk-col-red" <?=get_option('dark_menu', 0)==1?"checked":""?> value="1">
                                            <label class="p0 m0" for="md_checkbox_dark_menu_enable">&nbsp;</label>
                                            <span class="checkbox-text-right"> <?=lang('on')?></span>
                                        </div>
                                        <div class="pure-checkbox grey mr15 mb15">
                                            <input type="radio" id="md_checkbox_dark_menu_disable" name="dark_menu" class="filled-in chk-col-red" <?=get_option('dark_menu', 0)==0?"checked":""?> value="0">
                                            <label class="p0 m0" for="md_checkbox_dark_menu_disable">&nbsp;</label>
                                            <span class="checkbox-text-right"> <?=lang('off')?></span>
                                        </div>
                                        
                                        <br/>
                                        <span class="text"> <?=lang('full_menu')?></span><br/>
                                        <div class="pure-checkbox grey mr15 mb15">
                                            <input type="radio" id="md_checkbox_full_menu_enable" name="full_menu" class="filled-in chk-col-red" <?=get_option('full_menu', 0)==1?"checked":""?> value="1">
                                            <label class="p0 m0" for="md_checkbox_full_menu_enable">&nbsp;</label>
                                            <span class="checkbox-text-right"> <?=lang('on')?></span>
                                        </div>
                                        <div class="pure-checkbox grey mr15 mb15">
                                            <input type="radio" id="md_checkbox_full_menu_disable" name="full_menu" class="filled-in chk-col-red" <?=get_option('full_menu', 0)==0?"checked":""?> value="0">
                                            <label class="p0 m0" for="md_checkbox_full_menu_disable">&nbsp;</label>
                                            <span class="checkbox-text-right"> <?=lang('off')?></span>
                                        </div>
                                        <div class="form-group">
                                            <?php
                                            $themes = scandir(APPPATH."../themes");
                                            ?>
                                            <span class="text"> <?=lang("theme")?></span> 
                                            <select name="theme" class="form-control">
                                                <?php foreach ($themes as $key => $theme) {
                                                if(strpos($theme,".") === FALSE){
                                                ?>
                                                <option value="<?=$theme?>" <?=get_theme()==$theme?"selected":""?>><?=ucfirst($theme)?></option>
                                                <?php }}?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <span class="text"> <?=lang('website_title')?></span> 
                                            <input type="text" class="form-control" name="website_title" value="<?=get_option("website_title", 'Stackposts - Social Marketing Tool')?>">
                                        </div>
                                        <div class="form-group">
                                            <span class="text"> <?=lang('website_description')?></span> 
                                            <input type="text" class="form-control" name="website_description" value="<?=get_option("website_description", 'save time, do more, manage multiple social networks at one place')?>">
                                        </div>
                                        <div class="form-group">
                                            <span class="text"> <?=lang('website_keyword')?></span> 
                                            <input type="text" class="form-control" name="website_keyword" value="<?=get_option("website_keyword", 'social marketing tool, social planner, automation, social schedule')?>">
                                        </div>
                                        <div class="form-group">
                                            <span class="text"> <?=lang('website_favicon')?></span>
                                     
                                            <div class="input-group p0">
                                                <input type="text" class="form-control" name="website_favicon" id="website_favicon" value="<?=get_option("website_favicon", BASE.'assets/img/favicon.png')?>">
                                                <span class="input-group-btn" id="button-addon">
                                                    <a class="btn btn-primary btnOpenFileManager" href="<?=PATH?>file_manager/popup_add_files?id=website_favicon">
                                                        <i class="ft-folder"></i>
                                                    </a>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <span class="text"> <?=lang('website_logo_white')?></span>
                                     
                                            <div class="input-group p0">
                                                <input type="text" class="form-control" name="website_logo_white" id="website_logo_white" value="<?=get_option("website_logo_white", BASE.'assets/img/logo-white.png')?>">
                                                <span class="input-group-btn" id="button-addon">
                                                    <a class="btn btn-primary btnOpenFileManager" href="<?=PATH?>file_manager/popup_add_files?id=website_logo_white">
                                                        <i class="ft-folder"></i>
                                                    </a>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <span class="text"><?=lang('website_logo_black')?></span>
                                     
                                            <div class="input-group p0">
                                                <input type="text" class="form-control" name="website_logo_black" id="website_logo_black" value="<?=get_option("website_logo_black", BASE.'assets/img/logo-black.png')?>">
                                                <span class="input-group-btn" id="button-addon">
                                                    <a class="btn btn-primary btnOpenFileManager" href="<?=PATH?>file_manager/popup_add_files?id=website_logo_black">
                                                        <i class="ft-folder"></i>
                                                    </a>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <span class="text"><?=lang('logo_mark')?></span>
                                     
                                            <div class="input-group p0">
                                                <input type="text" class="form-control" name="website_logo_mark" id="website_logo_mark" value="<?=get_option("website_logo_mark", BASE.'assets/img/logo-mark.png')?>">
                                                <span class="input-group-btn" id="button-addon">
                                                    <a class="btn btn-primary btnOpenFileManager" href="<?=PATH?>file_manager/popup_add_files?id=website_logo_mark">
                                                        <i class="ft-folder"></i>
                                                    </a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php if(get_payment()){?>
                            <div id="payment" class="tab-pane fade in">
                                <div class="row">
                                    <div class="col-md-12">
                                        <span class="text"> <?=lang('environment')?></span><br/>
                                        <div class="pure-checkbox grey mr15 mb15">
                                            <input type="radio" id="md_checkbox_payment_environment_enable" name="payment_environment" class="filled-in chk-col-red" <?=get_option('payment_environment', 0)==1?"checked":""?> value="1">
                                            <label class="p0 m0" for="md_checkbox_payment_environment_enable">&nbsp;</label>
                                            <span class="checkbox-text-right"> <?=lang('live')?></span>
                                        </div>
                                        <div class="pure-checkbox grey mr15 mb15">
                                            <input type="radio" id="md_checkbox_payment_environment_disable" name="payment_environment" class="filled-in chk-col-red" <?=get_option('payment_environment', 0)==0?"checked":""?> value="0">
                                            <label class="p0 m0" for="md_checkbox_payment_environment_disable">&nbsp;</label>
                                            <span class="checkbox-text-right"> <?=lang('sandbox')?></span>
                                        </div>
                                        <div class="form-group">
                                            <span class="text"> <?=lang('currency')?></span> 
                                            <select name="payment_currency" class="form-control">
                                                <option value="USD" <?=get_option('payment_currency', 'USD')=="USD"?"selected":""?>>USD</option>
                                                <option value="AUD" <?=get_option('payment_currency', 'USD')=="AUD"?"selected":""?>>AUD</option>
                                                <option value="CAD" <?=get_option('payment_currency', 'USD')=="CAD"?"selected":""?>>CAD</option>
                                                <option value="EUR" <?=get_option('payment_currency', 'USD')=="EUR"?"selected":""?>>EUR</option>
                                                <option value="ILS" <?=get_option('payment_currency', 'USD')=="ILS"?"selected":""?>>ILS</option>
                                                <option value="NZD" <?=get_option('payment_currency', 'USD')=="NZD"?"selected":""?>>NZD</option>
                                                <option value="RUB" <?=get_option('payment_currency', 'USD')=="RUB"?"selected":""?>>RUB</option>
                                                <option value="SGD" <?=get_option('payment_currency', 'USD')=="SGD"?"selected":""?>>SGD</option>
                                                <option value="SEK" <?=get_option('payment_currency', 'USD')=="SEK"?"selected":""?>>SEK</option>
                                                <option value="BRL" <?=get_option('payment_currency', 'USD')=="BRL"?"selected":""?>>BRL</option>
                                                <option value="MXN" <?=get_option('payment_currency', 'USD')=="MXN"?"selected":""?>>MXN</option>
                                                <option value="THB" <?=get_option('payment_currency', 'USD')=="THB"?"selected":""?>>THB</option>
                                                <option value="JPY" <?=get_option('payment_currency', 'USD')=="JPY"?"selected":""?>>JPY</option>
                                                <option value="MYR" <?=get_option('payment_currency', 'USD')=="MYR"?"selected":""?>>MYR</option>
                                                <option value="PHP" <?=get_option('payment_currency', 'USD')=="PHP"?"selected":""?>>PHP</option>
                                                <option value="TWD" <?=get_option('payment_currency', 'USD')=="TWD"?"selected":""?>>TWD</option>
                                                <option value="CZK" <?=get_option('payment_currency', 'USD')=="CZK"?"selected":""?>>CZK</option>
                                                <option value="PLN" <?=get_option('payment_currency', 'USD')=="PLN"?"selected":""?>>PLN</option>
                                                <option value="VND" <?=get_option('payment_currency', 'USD')=="VND"?"selected":""?>>VND</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <span class="text"> <?=lang('symbol')?></span> 
                                            <input type="text" class="form-control" name="payment_symbol" value="<?=get_option('payment_symbol', '$')?>">
                                        </div>

                                        <div class="lead"><?=lang('pagseguro')?></div>
                                        <div class="pure-checkbox grey mr15 mb15">
                                            <input type="radio" id="md_checkbox_pagseguro_enable" name="pagseguro_enable" class="filled-in chk-col-red" <?=get_option('pagseguro_enable', 0)==1?"checked":""?> value="1">
                                            <label class="p0 m0" for="md_checkbox_pagseguro_enable">&nbsp;</label>
                                            <span class="checkbox-text-right"> <?=lang('enable')?></span>
                                        </div>
                                        <div class="pure-checkbox grey mr15 mb15">
                                            <input type="radio" id="md_checkbox_pagseguro_enable_disable" name="pagseguro_enable" class="filled-in chk-col-red" <?=get_option('pagseguro_enable', 0)==0?"checked":""?> value="0">
                                            <label class="p0 m0" for="md_checkbox_pagseguro_enable_disable">&nbsp;</label>
                                            <span class="checkbox-text-right"> <?=lang('disable')?></span>
                                        </div>

                                        <div class="form-group">
                                            <span class="text"> <?=lang('email')?></span> 
                                            <input type="text" class="form-control" name="pagseguro_email" value="<?=get_option('pagseguro_email', '')?>">
                                        </div>
                                        <div class="form-group">
                                            <span class="text"> <?=lang('token')?></span> 
                                            <input type="text" class="form-control" name="pagseguro_token" value="<?=get_option('pagseguro_token', '')?>">
                                        </div>

                                        <div class="lead"><?=lang('stripe')?></div>
                                        <div class="pure-checkbox grey mr15 mb15">
                                            <input type="radio" id="md_checkbox_stripe_enable" name="stripe_enable" class="filled-in chk-col-red" <?=get_option('stripe_enable', 0)==1?"checked":""?> value="1">
                                            <label class="p0 m0" for="md_checkbox_stripe_enable">&nbsp;</label>
                                            <span class="checkbox-text-right"> <?=lang('enable')?></span>
                                        </div>
                                        <div class="pure-checkbox grey mr15 mb15">
                                            <input type="radio" id="md_checkbox_stripe_enable_disable" name="stripe_enable" class="filled-in chk-col-red" <?=get_option('stripe_enable', 0)==0?"checked":""?> value="0">
                                            <label class="p0 m0" for="md_checkbox_stripe_enable_disable">&nbsp;</label>
                                            <span class="checkbox-text-right"> <?=lang('disable')?></span>
                                        </div>

                                        <div class="form-group">
                                            <span class="text"> <?=lang('publishable_key')?></span> 
                                            <input type="text" class="form-control" name="stripe_publishable_key" value="<?=get_option('stripe_publishable_key', '')?>">
                                        </div>
                                        <div class="form-group">
                                            <span class="text"> <?=lang('secret_key')?></span> 
                                            <input type="text" class="form-control" name="stripe_secret_key" value="<?=get_option('stripe_secret_key', '')?>">
                                        </div>
                                        <div class="lead"><?=lang('paypal')?></div>
                                        <div class="pure-checkbox grey mr15 mb15">
                                            <input type="radio" id="md_checkbox_paypal_enable" name="paypal_enable" class="filled-in chk-col-red" <?=get_option('paypal_enable', 0)==1?"checked":""?> value="1">
                                            <label class="p0 m0" for="md_checkbox_paypal_enable">&nbsp;</label>
                                            <span class="checkbox-text-right"> <?=lang('enable')?></span>
                                        </div>
                                        <div class="pure-checkbox grey mr15 mb15">
                                            <input type="radio" id="md_checkbox_paypal_enable_disable" name="paypal_enable" class="filled-in chk-col-red" <?=get_option('paypal_enable', 0)==0?"checked":""?> value="0">
                                            <label class="p0 m0" for="md_checkbox_paypal_enable_disable">&nbsp;</label>
                                            <span class="checkbox-text-right"> <?=lang('disable')?></span>
                                        </div>
                                        <div class="form-group">
                                            <span class="text"> <?=lang('client_id')?></span> 
                                            <input type="text" class="form-control" name="paypal_client_id" value="<?=get_option('paypal_client_id', '')?>">
                                        </div>
                                        <div class="form-group">
                                            <span class="text"> <?=lang('client_secret_key')?></span> 
                                            <input type="text" class="form-control" name="paypal_client_secret" value="<?=get_option('paypal_client_secret', '')?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php }?>
                            <div id="oauth" class="tab-pane fade in">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <span class="text"> <?=lang('enable_signup')?></span> <br/>
                                            <div class="pure-checkbox grey mr15 mb15">
                                                <input type="radio" id="md_checkbox_singup_enable" name="singup_enable" class="filled-in chk-col-red" <?=get_option('singup_enable', 1)==1?"checked":""?> value="1">
                                                <label class="p0 m0" for="md_checkbox_singup_enable">&nbsp;</label>
                                                <span class="checkbox-text-right"> <?=lang('enable')?></span>
                                            </div>
                                            <div class="pure-checkbox grey mr15 mb15">
                                                <input type="radio" id="md_checkbox_singup_enable_disable" name="singup_enable" class="filled-in chk-col-red" <?=get_option('singup_enable', 1)==0?"checked":""?> value="0">
                                                <label class="p0 m0" for="md_checkbox_singup_enable_disable">&nbsp;</label>
                                                <span class="checkbox-text-right"> <?=lang('disable')?></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <span class="text"> <?=lang('verify_account_via_email')?></span> <br/>
                                            <div class="pure-checkbox grey mr15 mb15">
                                                <input type="radio" id="md_checkbox_singup_verify_email_enable" name="singup_verify_email_enable" class="filled-in chk-col-red" <?=get_option('singup_verify_email_enable', 1)==1?"checked":""?> value="1">
                                                <label class="p0 m0" for="md_checkbox_singup_verify_email_enable">&nbsp;</label>
                                                <span class="checkbox-text-right"> <?=lang('enable')?></span>
                                            </div>
                                            <div class="pure-checkbox grey mr15 mb15">
                                                <input type="radio" id="md_checkbox_singup_verify_email_disable" name="singup_verify_email_enable" class="filled-in chk-col-red" <?=get_option('singup_verify_email_enable', 1)==0?"checked":""?> value="0">
                                                <label class="p0 m0" for="md_checkbox_singup_verify_email_disable">&nbsp;</label>
                                                <span class="checkbox-text-right"> <?=lang('disable')?></span>
                                            </div>
                                        </div>

                                        <div class="lead"> <?=lang('google_login')?></div>
                                        <div class="pure-checkbox grey mr15 mb15">
                                            <input type="radio" id="md_checkbox_google_oauth_enable" name="google_oauth_enable" class="filled-in chk-col-red" <?=get_option('google_oauth_enable', 0)==1?"checked":""?> value="1">
                                            <label class="p0 m0" for="md_checkbox_google_oauth_enable">&nbsp;</label>
                                            <span class="checkbox-text-right"> <?=lang('enable')?></span>
                                        </div>
                                        <div class="pure-checkbox grey mr15 mb15">
                                            <input type="radio" id="md_checkbox_google_oauth_enable_disable" name="google_oauth_enable" class="filled-in chk-col-red" <?=get_option('google_oauth_enable', 0)==0?"checked":""?> value="0">
                                            <label class="p0 m0" for="md_checkbox_google_oauth_enable_disable">&nbsp;</label>
                                            <span class="checkbox-text-right"> <?=lang('disable')?></span>
                                        </div>

                                        <div class="form-group">
                                            <span class="text"> <?=lang('client_id')?></span> 
                                            <input type="text" class="form-control" name="google_oauth_client_id" value="<?=get_option('google_oauth_client_id', '')?>">
                                        </div>
                                        <div class="form-group">
                                            <span class="text"> <?=lang('client_secret_key')?></span> 
                                            <input type="text" class="form-control" name="google_oauth_client_secret" value="<?=get_option('google_oauth_client_secret', '')?>">
                                        </div>
                                        <div class="lead"> <?=lang('facebook_login')?></div>
                                        <div class="pure-checkbox grey mr15 mb15">
                                            <input type="radio" id="md_checkbox_facebook_oauth_enable" name="facebook_oauth_enable" class="filled-in chk-col-red" <?=get_option('facebook_oauth_enable', 0)==1?"checked":""?> value="1">
                                            <label class="p0 m0" for="md_checkbox_facebook_oauth_enable">&nbsp;</label>
                                            <span class="checkbox-text-right"> <?=lang('enable')?></span>
                                        </div>
                                        <div class="pure-checkbox grey mr15 mb15">
                                            <input type="radio" id="md_checkbox_facebook_oauth_enable_disable" name="facebook_oauth_enable" class="filled-in chk-col-red" <?=get_option('facebook_oauth_enable', 0)==0?"checked":""?> value="0">
                                            <label class="p0 m0" for="md_checkbox_facebook_oauth_enable_disable">&nbsp;</label>
                                            <span class="checkbox-text-right"> <?=lang('disable')?></span>
                                        </div> 
                                        <div class="form-group">
                                            <span class="text"> <?=lang('app_id')?></span> 
                                            <input type="text" class="form-control" name="facebook_oauth_app_id" value="<?=get_option('facebook_oauth_app_id', '')?>">
                                        </div>
                                        <div class="form-group">
                                            <span class="text"> <?=lang('app_secret')?></span> 
                                            <input type="text" class="form-control" name="facebook_oauth_app_secret" value="<?=get_option('facebook_oauth_app_secret', '')?>">
                                        </div>

                                       
                                        <div class="lead"> <?=lang('twitter_login')?></div>
                                        <div class="pure-checkbox grey mr15 mb15">
                                            <input type="radio" id="md_checkbox_twitter_oauth_enable" name="twitter_oauth_enable" class="filled-in chk-col-red" <?=get_option('twitter_oauth_enable', 0)==1?"checked":""?> value="1">
                                            <label class="p0 m0" for="md_checkbox_twitter_oauth_enable">&nbsp;</label>
                                            <span class="checkbox-text-right"> <?=lang('enable')?></span>
                                        </div>
                                        <div class="pure-checkbox grey mr15 mb15">
                                            <input type="radio" id="md_checkbox_twitter_oauth_enable_disable" name="twitter_oauth_enable" class="filled-in chk-col-red" <?=get_option('twitter_oauth_enable', 0)==0?"checked":""?> value="0">
                                            <label class="p0 m0" for="md_checkbox_twitter_oauth_enable_disable">&nbsp;</label>
                                            <span class="checkbox-text-right"> <?=lang('disable')?></span>
                                        </div>
                                        <div class="form-group">
                                            <span class="text"> <?=lang('consumer_key_(api_key)')?></span> 
                                            <input type="text" class="form-control" name="twitter_oauth_client_id" value="<?=get_option('twitter_oauth_client_id', '')?>">
                                        </div>
                                        <div class="form-group">
                                            <span class="text"> <?=lang('consumer_secret_(api_secret)')?></span> 
                                            <input type="text" class="form-control" name="twitter_oauth_client_secret" value="<?=get_option('twitter_oauth_client_secret', '')?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="proxies" class="tab-pane fade in">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <span class="text"> <?=lang('users_can_add_proxies')?></span> <br/>
                                            <div class="pure-checkbox grey mr15 mb15">
                                                <input type="radio" id="md_checkbox_user_proxy_enable" name="user_proxy" class="filled-in chk-col-red" <?=get_option('user_proxy', 1)==1?"checked":""?> value="1">
                                                <label class="p0 m0" for="md_checkbox_user_proxy_enable">&nbsp;</label>
                                                <span class="checkbox-text-right"> <?=lang('enable')?></span>
                                            </div>
                                            <div class="pure-checkbox grey mr15 mb15">
                                                <input type="radio" id="md_checkbox_user_proxy_disable" name="user_proxy" class="filled-in chk-col-red" <?=get_option('user_proxy', 1)==0?"checked":""?> value="0">
                                                <label class="p0 m0" for="md_checkbox_user_proxy_disable">&nbsp;</label>
                                                <span class="checkbox-text-right"> <?=lang('disable')?></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <span class="text"> <?=lang('users_can_use_the_system_proxy')?></span> <br/>
                                            <div class="pure-checkbox grey mr15 mb15">
                                                <input type="radio" id="md_checkbox_system_proxy_enable" name="system_proxy" class="filled-in chk-col-red" <?=get_option('system_proxy', 1)==1?"checked":""?> value="1">
                                                <label class="p0 m0" for="md_checkbox_system_proxy_enable">&nbsp;</label>
                                                <span class="checkbox-text-right"> <?=lang('enable')?></span>
                                            </div>
                                            <div class="pure-checkbox grey mr15 mb15">
                                                <input type="radio" id="md_checkbox_system_proxy_disable" name="system_proxy" class="filled-in chk-col-red" <?=get_option('system_proxy', 1)==0?"checked":""?> value="0">
                                                <label class="p0 m0" for="md_checkbox_system_proxy_disable">&nbsp;</label>
                                                <span class="checkbox-text-right"> <?=lang('disable')?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="file_manager" class="tab-pane fade in">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <span class="text"> <?=lang("aviary_api_key")?></span> 
                                            <input type="text" class="form-control" name="aviary_api_key" value="<?=get_option('aviary_api_key', '')?>">
                                        </div>
                                        <div class="lead">  <?=lang('google_drive')?></div>
                                        <div class="form-group">
                                            <span class="text">  <?=lang('google_api_key')?></span> 
                                            <input type="text" class="form-control" name="google_drive_api_key" value="<?=get_option('google_drive_api_key', '')?>">
                                        </div>
                                        <div class="form-group">
                                            <span class="text">  <?=lang('google_client_id')?></span> 
                                            <input type="text" class="form-control" name="google_drive_client_id" value="<?=get_option('google_drive_client_id', '')?>">
                                        </div>
                                       
                                        <div class="lead">  <?=lang('dropbox')?></div>
                                        <div class="form-group">
                                            <span class="text">  <?=lang('dropbox_api_key')?></span> 
                                            <input type="text" class="form-control" name="dropbox_api_key" value="<?=get_option('dropbox_api_key', '')?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="email" class="tab-pane fade in">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="lead"> <?=lang('general_settings')?></div>
                                        <div class="form-group">
                                            <span class="text"> Email from</span> 
                                            <input type="text" class="form-control" name="email_from" value="<?=get_option('email_from', '')?>">
                                        </div>
                                        <div class="form-group">
                                            <span class="text"> Your name</span> 
                                            <input type="text" class="form-control" name="email_name" value="<?=get_option('email_name', '')?>">
                                        </div>
                                        <div class="form-group">
                                            <span class="text"> <?=lang('email_protocol')?></span> <br/>
                                            <div class="pure-checkbox grey mr15 mb15">
                                                <input type="radio" id="md_checkbox_email_protocol_mail" name="email_protocol_type" class="filled-in chk-col-red" <?=get_option('email_protocol_type', 'mail')=='mail'?"checked":""?> value="mail">
                                                <label class="p0 m0" for="md_checkbox_email_protocol_mail">&nbsp;</label>
                                                <span class="checkbox-text-right"> <?=lang('mail')?></span>
                                            </div>
                                            <div class="pure-checkbox grey mr15 mb15">
                                                <input type="radio" id="md_checkbox_email_protocol_smpt" name="email_protocol_type" class="filled-in chk-col-red" <?=get_option('email_protocol_type', 'smtp')=='smtp'?"checked":""?> value="smtp">
                                                <label class="p0 m0" for="md_checkbox_email_protocol_smpt">&nbsp;</label>
                                                <span class="checkbox-text-right"> SMTP</span>
                                            </div>
                                        </div>
                                        <div class="form_smtp hide"> 
                                            <div class="form-group">
                                                <span class="text">  <?=lang('smtp_server')?></span> 
                                                <input type="text" class="form-control" name="email_smtp_server" value="<?=get_option('email_smtp_server', '')?>">
                                            </div>
                                            <div class="form-group">
                                                <span class="text">  <?=lang('smtp_port')?></span> 
                                                <input type="text" class="form-control" name="email_smtp_port" value="<?=get_option('email_smtp_port', '')?>">
                                            </div>
                                            <div class="form-group">
                                                <span class="text">  <?=lang('smtp_encryption')?></span> 
                                                <select name="email_smtp_encryption" class="form-control">
                                                    <option value="">None</option>
                                                    <option value="tls" <?=get_option('email_smtp_encryption', '') == "tls"?"selected":""?> >TLS</option>
                                                    <option value="ssl" <?=get_option('email_smtp_encryption', '') == "ssl"?"selected":""?> >SSL</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <span class="text">  <?=lang('smtp_username')?></span> 
                                                <input type="text" class="form-control" name="email_smtp_username" value="<?=get_option('email_smtp_username', '')?>">
                                            </div>
                                            <div class="form-group">
                                                <span class="text">  <?=lang('smtp_password')?></span> 
                                                <input type="text" class="form-control" name="email_smtp_password" value="<?=get_option('email_smtp_password', '')?>">
                                            </div>
                                        </div>

                                        <script type="text/javascript">
                                            $(function(){
                                                $type = $("[name='email_protocol_type']:checked").val();
                                                if($type == "smtp"){
                                                    $(".form_smtp").removeClass("hide");
                                                }else{
                                                    $(".form_smtp").addClass("hide");
                                                }

                                                $("[name='email_protocol_type']").change(function(){
                                                    $type = $("[name='email_protocol_type']:checked").val();
                                                    if($type == "smtp"){
                                                        $(".form_smtp").removeClass("hide");
                                                    }else{
                                                        $(".form_smtp").addClass("hide");
                                                    }
                                                }); 
                                            });
                                        </script>
                                        <div class="lead"> <?=lang('email_notifications')?></div>
                                        <div class="form-group">
                                            <span class="text"> <?=lang('welcome_email')?></span> <br/>
                                            <div class="pure-checkbox grey mr15 mb15">
                                                <input type="radio" id="md_checkbox_email_welcome_enable" name="email_welcome_enable" class="filled-in chk-col-red" <?=get_option('email_welcome_enable', 1)==1?"checked":""?> value="1">
                                                <label class="p0 m0" for="md_checkbox_email_welcome_enable">&nbsp;</label>
                                                <span class="checkbox-text-right"> <?=lang('enable')?></span>
                                            </div>
                                            <div class="pure-checkbox grey mr15 mb15">
                                                <input type="radio" id="md_checkbox_email_welcome_disable" name="email_welcome_enable" class="filled-in chk-col-red" <?=get_option('email_welcome_enable', 1)==0?"checked":""?> value="0">
                                                <label class="p0 m0" for="md_checkbox_email_welcome_disable">&nbsp;</label>
                                                <span class="checkbox-text-right"> <?=lang('disable')?></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <span class="text"> <?=lang('payment_email')?></span> <br/>
                                            <div class="pure-checkbox grey mr15 mb15">
                                                <input type="radio" id="md_checkbox_email_payment_enable" name="email_payment_enable" class="filled-in chk-col-red" <?=get_option('email_payment_enable', 1)==1?"checked":""?> value="1">
                                                <label class="p0 m0" for="md_checkbox_email_payment_enable">&nbsp;</label>
                                                <span class="checkbox-text-right"> <?=lang('enable')?></span>
                                            </div>
                                            <div class="pure-checkbox grey mr15 mb15">
                                                <input type="radio" id="md_checkbox_email_payment_disable" name="email_payment_enable" class="filled-in chk-col-red" <?=get_option('email_payment_enable', 1)==0?"checked":""?> value="0">
                                                <label class="p0 m0" for="md_checkbox_email_payment_disable">&nbsp;</label>
                                                <span class="checkbox-text-right"> <?=lang('disable')?></span>
                                            </div>
                                        </div>

                                        <div class="lead"> <?=lang('email_template')?></div>
                                        <h5 class="uc" style="color: #2196f3;"> <?=lang('activation_email')?></h5>
                                        <div class="form-group">
                                            <span class="text">  <?=lang('subject')?></span> 
                                            <input type="text" class="form-control" name="email_activation_subject" value="<?=get_option('email_activation_subject',getEmailTemplate('activate')->subject)?>">
                                        </div>
                                        <div class="form-group">
                                            <span class="text">  <?=lang('content')?></span> 
                                            <textarea class="form-control" style="height: 100px;" name="email_activation_content"><?=get_option('email_activation_content',getEmailTemplate('activate')->content)?></textarea>
                                        </div>
                                        
                                        <h5 class="uc" style="margin-top: 35px; color: #2196f3;">  <?=lang('new_customers')?> (Welcome email)</h5>
                                        <div class="form-group">
                                            <span class="text">  <?=lang('subject')?></span> 
                                            <input type="text" class="form-control" name="email_new_customers_subject" value="<?=get_option('email_new_customers_subject', getEmailTemplate('welcome')->subject)?>">
                                        </div>
                                        <div class="form-group">
                                            <span class="text">  <?=lang('content')?></span> 
                                            <textarea class="form-control" style="height: 100px;" name="email_new_customers_content"><?=get_option('email_new_customers_content', getEmailTemplate('welcome')->content)?></textarea>
                                        </div>

                                        <h5 class="uc" style="color: #2196f3; margin-top: 35px;"> <?=lang('forgot_password')?></h5>
                                        <div class="form-group">
                                            <span class="text">  <?=lang('subject')?></span> 
                                            <input type="text" class="form-control" name="email_forgot_password_subject" value="<?=get_option('email_forgot_password_subject', getEmailTemplate('forgot_password')->subject)?>">
                                        </div>
                                        <div class="form-group">
                                            <span class="text">  <?=lang('content')?></span> 
                                            <textarea class="form-control" style="height: 100px;" name="email_forgot_password_content"><?=get_option('email_forgot_password_content', getEmailTemplate('forgot_password')->content)?></textarea>
                                        </div>

                                        <h5 class="uc" style="margin-top: 35px; color: #2196f3;">  <?=lang('renewal_reminders')?></h5>
                                        <div class="form-group">
                                            <span class="text">  <?=lang('subject')?></span> 
                                            <input type="text" class="form-control" name="email_renewal_reminders_subject" value="<?=get_option('email_renewal_reminders_subject', getEmailTemplate('reminder')->subject)?>">
                                        </div>
                                        <div class="form-group">
                                            <span class="text">  <?=lang('content')?></span> 
                                            <textarea class="form-control" style="height: 100px;" name="email_renewal_reminders_content"><?=get_option('email_renewal_reminders_content', getEmailTemplate('reminder')->content)?></textarea>
                                        </div>

                                        <h5 class="uc" style="margin-top: 35px; color: #2196f3;"> <?=lang('payment_email')?> </h5>
                                        <div class="form-group">
                                            <span class="text">  <?=lang('subject')?></span> 
                                            <input type="text" class="form-control" name="email_payment_subject" value="<?=get_option('email_payment_subject', getEmailTemplate('payment')->subject)?>">
                                        </div>
                                        <div class="form-group">
                                            <span class="text">  <?=lang('content')?></span> 
                                            <textarea class="form-control" style="height: 100px;" name="email_payment_content"><?=get_option('email_payment_content', getEmailTemplate('payment')->content)?></textarea>
                                        </div>

                                        <div class="small">
                                            <?=lang('you_can_use_following_template_tags_within_the_message_template')?>:<br/> 
                                            {full_name} - <?=lang('displays_the_user_fullname')?>,<br/> 
                                            {email} - <?=lang('displays_the_user_email')?>,<br/> 
                                            {days_left} - <?=lang('displays_the_remaining_days')?>,<br/> 
                                            {expiration_date} - <?=lang('displays_the_expiration_date')?>,<br/> 
                                            {free_trial} - <?=lang('displays_the_trial_days')?>.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="social_page" class="tab-pane fade in">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <span class="text"> <?=lang('facebook_page')?></span> 
                                            <input type="text" class="form-control" name="social_page_facebook" value="<?=get_option('social_page_facebook', '')?>">
                                        </div>

                                        <div class="form-group">
                                            <span class="text"> <?=lang('instagram_page')?></span> 
                                            <input type="text" class="form-control" name="social_page_instagram" value="<?=get_option('social_page_instagram', '')?>">
                                        </div>

                                        <div class="form-group">
                                            <span class="text"> <?=lang('google_page')?></span> 
                                            <input type="text" class="form-control" name="social_page_google" value="<?=get_option('social_page_google', '')?>">
                                        </div>

                                        <div class="form-group">
                                            <span class="text"> <?=lang('twitter_page')?></span> 
                                            <input type="text" class="form-control" name="social_page_twitter" value="<?=get_option('social_page_twitter', '')?>">
                                        </div>

                                        <div class="form-group">
                                            <span class="text">  <?=lang('pinterest_page')?></span> 
                                            <input type="text" class="form-control" name="social_page_pinterest" value="<?=get_option('social_page_pinterest', '')?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="other" class="tab-pane fade in">
                                <div class="row">
                                    <div class="col-md-12">
                                        <span class="text"> <?=lang('enable_https')?></span><br/><span class="danger small"><?=lang("please_make_sure_your_hosting_supported_ssl_before_turn_on_it")?></span><br/>
                                        <div class="pure-checkbox grey mr15 mb15">
                                            <input type="radio" id="md_checkbox_enable_https_enable" name="enable_https" class="filled-in chk-col-red" <?=get_option('enable_https', 0)==1?"checked":""?> value="1">
                                            <label class="p0 m0" for="md_checkbox_enable_https_enable">&nbsp;</label>
                                            <span class="checkbox-text-right"> <?=lang('on')?></span>
                                        </div>
                                        <div class="pure-checkbox grey mr15 mb15">
                                            <input type="radio" id="md_checkbox_enable_https_disable" name="enable_https" class="filled-in chk-col-red" <?=get_option('enable_https', 0)==0?"checked":""?> value="0">
                                            <label class="p0 m0" for="md_checkbox_enable_https_disable">&nbsp;</label>
                                            <span class="checkbox-text-right"> <?=lang('off')?></span>
                                        </div>
                                        <div class="form-group">
                                            <span class="text"><?=lang('embed_code')?></span>
                                            <textarea class="form-control" name="embed_javascript" style="height: 200px;"><?=get_option('embed_javascript', '')?></textarea> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary"> <?=lang('save_changes')?></button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
