<div class="wrap-content container linkedin-app">
    <form action="<?=PATH.segment(1)?>/post/ajax_post" method="POST" class="actionForm">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="fa fa-linkedin" aria-hidden="true"></i> <?=lang('linkedin_accounts')?>
                        </div>
                    </div>
                    <div class="card-block p0">
                        <div class="list-account max scrollbar scrollbar-dynamic">
                            <?php if(!empty($accounts)){
                                foreach ($accounts as $key => $row) {
                            ?>

                            <a href="javascript:void(0);" class="item">
                                <div class="image-box">
                                    <img class="img-circle" src="<?=$row->avatar?>">
                                    <i class="icon fa <?=($row->type == "page")?"fa-flag":"fa-user"?>"></i>
                                </div>
                                <div class="checked"><i class="ft-check"></i></div>
                                <input type="checkbox" name="account[]" value="<?=$row->ids?>" class="hide">
                                <div class="content">
                                    <span class="title"><?=$row->username?></span>
                                </div>
                                <div class="clearfix"></div>
                            </a>
                            <?php }}else{?>
                            <div class="empty">
                                <span><?=lang("add_an_account_to_begin")?></span>
                                <a href="<?=PATH?>account_manager" class="btn btn-primary"><?=lang("add_account")?></a>
                            </div>
                            <?php }?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card">
                    <div class="card-overplay"><i class="pe-7s-config pe-spin"></i></div>
                    <div class="card-header border">
                        <div class="card-title">
                            <i class="fa ft-edit" aria-hidden="true"></i> <?=lang('new_post')?>
                        </div>
                    </div>
                    <div class="card-block pt0">
                        <?=modules::run("file_manager/block_file_manager")?>

                        <div class="form-group">
                            <textarea class="form-control post-message" name="caption" rows="3" placeholder="<?=lang('add_a_caption')?>" style="height: 114px;"></textarea>
                        </div>

                        <div class="form-group form-help">
                            <input type="input" class="form-control" name="link" placeholder="<?=lang('enter_link')?>" value="">
                        </div>

                        <div class="form-group">
                            <div class="pure-checkbox grey mr15">
                                <input type="checkbox" id="md_checkbox_schedule" name="is_schedule" class="filled-in chk-col-red enable_linkedin_schedule" value="on">
                                <label class="p0 m0" for="md_checkbox_schedule">&nbsp;</label>
                                <span class="checkbox-text-right"><?=lang('schedule')?></span>
                            </div>
                        </div>
                        
                        <div class="schedule-option collapse in" id="schedule-option">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="time_post"><?=lang('time_post')?></label>
                                        <input type="text" name="time_post" class="form-control datetime time_post" id="time_post" disabled="true">
                                    </div>
                                </div>
                            </div>
                        </div>  
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-primary pull-right btnPostNow"><?=lang('post_now')?></button>
                        <button type="submit" class="btn btn-primary pull-right btnSchedulePost hide"><?=lang('schedule_post')?></button>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 hidden-sm hidden-xs">
                <div class="card">
                    <div class="card-block p0">
                        <div class="preview-linkedin preview-linkedin-link">
                            <div class="preview-header">
                                <div class="linkedin-logo"><i class="fa fa-linkedin"></i></div>
                            </div>
                            <div class="preview-content">
                                <div class="user-info">
                                    <img class="img-circle" src="<?=BASE?>public/facebook/assets/img/avatar.png">
                                    <div class="text">
                                        <div class="name"> <?=lang('anonymous')?></div>
                                        <span> <?=lang('Web_Developer_at_Home_Work')?> <br/><?=lang('just_now')?></span>
                                    </div>
                                </div>
                                <div class="caption-info">
                                    <div class="line-no-text"></div>
                                    <div class="line-no-text"></div>
                                    <div class="line-no-text w50"></div>
                                </div>

                                <div class="preview-link">
                                    <div class="image"></div>
                                    <div class="info">
                                        <div class="title"><div class="line-no-text"></div></div>
                                        <div class="website">
                                            <div class="line-no-text w50"></div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="preview-comment">
                                    <div class="item">
                                        <i class="linkedin-icon like" aria-hidden="true"></i> <?=lang('like')?>
                                    </div>
                                    <div class="item">
                                        <i class="linkedin-icon comment" aria-hidden="true"></i> <?=lang('comment')?>
                                    </div>
                                    <div class="item">
                                        <i class="linkedin-icon share" aria-hidden="true"></i> <?=lang('share')?>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>