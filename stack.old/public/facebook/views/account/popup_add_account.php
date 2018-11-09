<div id="load_popup_modal_contant" class="facebook_popup_add" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class="modal-title"><i class="fa fa-facebook-square"></i> <?=lang('add_facebook_account')?> </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#home"> <?=lang('facebook_for_iphone/android')?></a></li>
                            <li class="hide"><a data-toggle="tab" href="#menu2"> <?=lang('htc_sence')?></a></li>
                        </ul>

                        <div class="tab-content p15">
                            <div id="home" class="tab-pane fade in active">
                                <form action="<?=BASE?>facebook/ajax_get_access_token" data-type-message="text" data-async role="form" class="actionForm" role="form" method="POST">
                                    <div class="form-notify"></div>
                                    <div class="form-group">
                                        <label class="control-label" for="username"><?=lang("facebook_username")?></label>
                                            <input type="text" name="username" id="username" class="form-control" id="username" value="">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="password"><?=lang("facebook_password")?></label>
                                        <input type="password" name="password" id="password" class="form-control" id="password" value="">
                                    </div>
                                    <div class="form-group hide">
                                        <label class="control-label"><?=lang("facebook_application")?></label>
                                        <select class="form-control" name="app">
                                            <option value="iphone"> <?=lang('facebook_for_iphone')?></option>
                                            <option value="android"> <?=lang('facebook_for_android')?></option>
                                        </select>
                                    </div>
                                    <div class="form-group mb0">
                                        <input type="submit" value="<?=lang('get_access_token')?>" class="btn btn-primary" />
                                    </div>
                                    <div class="mb0 iframe_access_token">

                                    </div>
                                </form>
                            </div>
                            <div id="menu2" class="tab-pane fade">
                                <?php if($user_agent != "Firefox"){?>
                                <div class="form-group">
                                    <label class="control-label">  <?=lang('step_1_click_button_authorize')?></label><br/>
                                    <input type="button" value="Authorize" onclick="window.open('https://goo.gl/ULGrXS', 'main_browser', 'height=550,width=650')" class="btn btn-primary" />
                                </div>
                                
                                <div class="form-group mb0">
                                    <label class="control-label" for="access_token">  <?=lang('step_2_get_access_token_copy_paste_code_below_on_browser_console')?><a href="#" class="label label-sm label-info" style="text-transform: uppercase;">  <?=lang('how_to_do_it')?></a>)</label>
                                    <textarea class="form-control" rows="5" id="access_token" name="access_token">var uid=document.cookie.match(/c_user=(\d+)/)[1],dtsg=document.getElementsByName("fb_dtsg")[0].value,http=new XMLHttpRequest,url="//"+location.host+"/v1.0/dialog/oauth/confirm",params="fb_dtsg="+dtsg+"&app_id=193278124048833&redirect_uri=fbconnect%3A%2F%2Fsuccess&display=page&access_token=&from_post=1&return_format=access_token&domain=&sso_device=ios&__CONFIRM__=1&__user="+uid;http.open("POST",url,!0),http.setRequestHeader("Content-type","application/x-www-form-urlencoded"),http.onreadystatechange=function(){if(4==http.readyState&&200==http.status){var a=http.responseText.match(/access_token=(.*)(?=&expires_in)/);a=a?a[1]:"Failed to get Access token make sure you authorized the HTC sense app",window.location.replace("https://developers.facebook.com/tools/debug/accesstoken/?q="+a+"&expires_in=0")}},http.send(params);</textarea>
                                </div>
                                <?php }else{?>
                                <div class="form-group">
                                    <input type="button" value="Authorize and get access token" onclick="window.open('https://goo.gl/ULGrXS', 'main_browser', 'height=550,width=650')" class="btn btn-primary" />
                                </div>
                                <?php }?>
                            </div>
                            <div class="clearfix"></div>
                        </div>

                        <form action="<?=PATH?>facebook/ajax_add_account" data-redirect="<?=PATH?>account_manager" data-type-message="text" data-async role="form" class="actionForm" role="form" method="POST">
                        <div class="pt15">
                            <div class="form-group mb0">
                                <label class="control-label"><?=lang("facebook_access_token")?></label>
                                <textarea class="form-control" rows="5" name="access_token"></textarea>
                            </div>
                        </div>

                        <div class="modal-footer row mt15 pb0">
                            <input name="submit_popup" id="submit_popup" type="submit" value="<?=lang('add_account')?>" class="btn btn-primary" />
                            <button type="button" class="btn btn-default" data-dismiss="modal"><?=lang("close")?></button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

