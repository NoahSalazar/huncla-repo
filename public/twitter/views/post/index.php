<div class="wrap-content container twitter-app">
    <form action="<?=PATH?>twitter/post/ajax_post" method="POST" class="actionForm">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="fa fa-twitter" aria-hidden="true"></i> <?=lang('twitter_accounts')?>
                        </div>
                    </div>
                    <div class="card-block p0">
                        <div class="list-account max scrollbar scrollbar-dynamic">
                            <?php if(!empty($accounts)){
                                foreach ($accounts as $key => $row) {
                            ?>

                            <a href="javascript:void(0);" class="item">
                                <img class="img-circle" src="<?=$row->avatar?>">
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
                    <?=modules::run("caption/popup")?>

                    <div class="card-overplay"><i class="pe-7s-config pe-spin"></i></div>
                    <div class="card-header">
                        <div class="card-title">
                            <i class="fa ft-edit" aria-hidden="true"></i> <?=lang('new_post')?>
                        </div>
                    </div>
                    <div class="card-block pt0">
                        <div class="row">
                            <div class="tab-type schedule-twitter-type file-manager-change-type">
                                <a href="javascript:void(0);" class="col-md-4 col-sm-4 col-xs-4 item active" data-type="photo" data-type-image="multi">
                                    <i class="ft-image"></i> <?=lang('photo')?>
                                    <input type="radio" name="type" class="hide" value="photo" checked="">
                                </a>
                                <a href="javascript:void(0);" class="col-md-4 col-sm-4 col-xs-4 item" data-type="video" data-type-image="single">
                                    <i class="ft-camera"></i> <?=lang('video')?>
                                    <input type="radio" name="type" class="hide" value="video">
                                </a>
                                <a href="javascript:void(0);" class="col-md-4 col-sm-4 col-xs-4 item" data-type="text" data-type-image="single">
                                    <i class="ft-file-text"></i> <?=lang('text')?>
                                    <input type="radio" name="type" value="text" class="hide">
                                </a>
                            </div>
                        </div>

                        <?=modules::run("file_manager/block_file_manager", "multi")?>

                        <div class="form-group form-caption twitter-text">
                            <div class="list-icon">
                                <a href="javascript:void(0);" class="getCaption" data-toggle="tooltip" data-placement="left" title="<?=lang("get_caption")?>"><i class="ft-command"></i></a>
                                <a href="javascript:void(0);" data-toggle="tooltip" class="saveCaption" data-placement="left" title="<?=lang("save_caption")?>"><i class="ft-save"></i></a>
                            </div>
                            <textarea class="form-control post-message" name="caption" rows="3" placeholder="<?=lang('add_a_caption')?>" style="height: 114px;"></textarea>
                        </div>

                        <div class="form-group">
                            <div class="pure-checkbox grey mr15">
                                <input type="checkbox" id="md_checkbox_schedule" name="is_schedule" class="filled-in chk-col-red enable_twitter_schedule" value="on">
                                <label class="p0 m0" for="md_checkbox_schedule">&nbsp;</label>
                                <span class="checkbox-text-right"> <?=lang('schedule')?></span>
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
                        <button type="button" class="btn btn-primary pull-right btnPostNow"> <?=lang('post_now')?></button>
                        <button type="submit" class="btn btn-primary pull-right btnSchedulePost hide"> <?=lang('schedule_post')?></button>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 hidden-sm hidden-xs">
                <div class="card">
                    <div class="card-block p0">
                        <div class="preview-twitter preview-twitter-photo">
                            <div class="preview-header">
                                <div class="twitter-logo"><i class="fa fa-twitter"></i></div>
                            </div>
                            <div class="preview-content">
                                <div class="user-info">
                                    <img class="img-circle" src="<?=BASE?>public/twitter/assets/img/avatar.png">
                                    <div class="text">
                                        <div class="name"><?=lang('anonymous')?></div>
                                        <span>@<?=lang('anonymous')?></span>
                                    </div>
                                </div>
                                <div class="caption-info">
                                    <div class="line-no-text"></div>
                                    <div class="line-no-text"></div>
                                    <div class="line-no-text w50"></div>
                                </div>
                                <div class="preview-image">
                                </div>

                                <div class="post-info">
                                    <div class="info-active">09:00 AM  16 Feb, 2018</div>
                                    <div class="clearfix"></div>
                                </div>
                                
                                <div class="preview-comment">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <i class="fa fa-comment-o" aria-hidden="true"></i>
                                        </div>
                                        <div class="col-md-3">
                                            <i class="fa fa-retweet" aria-hidden="true"></i>
                                        </div>
                                        <div class="col-md-3">
                                            <i class="fa fa-heart-o" aria-hidden="true"></i>
                                        </div>
                                        <div class="col-md-3">
                                            <i class="fa fa-bar-chart" aria-hidden="true"></i>
                                        </div>
                                    </div>  
                                </div>
                            </div>
                        </div>

                        <div class="preview-twitter preview-twitter-video hide">
                            <div class="preview-header">
                                <div class="twitter-logo"><i class="fa fa-twitter"></i></div>
                            </div>
                            <div class="preview-content">
                                <div class="user-info">
                                    <img class="img-circle" src="<?=BASE?>public/twitter/assets/img/avatar.png">
                                    <div class="text">
                                        <div class="name"><?=lang('anonymous')?></div>
                                        <span>@<?=lang('anonymous')?></span>
                                    </div>
                                </div>
                                <div class="caption-info">
                                    <div class="line-no-text"></div>
                                    <div class="line-no-text"></div>
                                    <div class="line-no-text w50"></div>
                                </div>
                                <div class="preview-image">
                                </div>

                                <div class="post-info">
                                    <div class="info-active">09:00 AM  16 Nov, 2017</div>
                                    <div class="clearfix"></div>
                                </div>
                                
                                <div class="preview-comment">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <i class="fa fa-comment-o" aria-hidden="true"></i>
                                        </div>
                                        <div class="col-md-3">
                                            <i class="fa fa-retweet" aria-hidden="true"></i>
                                        </div>
                                        <div class="col-md-3">
                                            <i class="fa fa-heart-o" aria-hidden="true"></i>
                                        </div>
                                        <div class="col-md-3">
                                            <i class="fa fa-bar-chart" aria-hidden="true"></i>
                                        </div>
                                    </div>  
                                </div>
                            </div>
                        </div>

                        <div class="preview-twitter preview-twitter-text hide">
                            <div class="preview-header">
                                <div class="twitter-logo"><i class="fa fa-twitter"></i></div>
                            </div>
                            <div class="preview-content">
                                <div class="user-info">
                                    <img class="img-circle" src="<?=BASE?>public/twitter/assets/img/avatar.png">
                                    <div class="text">
                                        <div class="name"><?=lang('anonymous')?></div>
                                        <span>@<?=lang('anonymous')?></span>
                                    </div>
                                </div>
                                <div class="caption-info">
                                    <div class="line-no-text"></div>
                                    <div class="line-no-text"></div>
                                    <div class="line-no-text w50"></div>
                                </div>
                                
                                <div class="post-info">
                                    <div class="info-active">09:00 AM  16 Nov, 2017</div>
                                    <div class="clearfix"></div>
                                </div>
                                
                                <div class="preview-comment">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <i class="fa fa-comment-o" aria-hidden="true"></i>
                                        </div>
                                        <div class="col-md-3">
                                            <i class="fa fa-retweet" aria-hidden="true"></i>
                                        </div>
                                        <div class="col-md-3">
                                            <i class="fa fa-heart-o" aria-hidden="true"></i>
                                        </div>
                                        <div class="col-md-3">
                                            <i class="fa fa-bar-chart" aria-hidden="true"></i>
                                        </div>
                                    </div>  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>