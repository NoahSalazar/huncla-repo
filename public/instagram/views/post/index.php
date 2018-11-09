<div class="wrap-content container instagram-app post-module">
    <form action="<?=PATH.segment(1)?>/post/ajax_post" method="POST" class="actionForm">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="fa fa-instagram" aria-hidden="true"></i> <?=lang('instagram_accounts')?>
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
                            <div class="pull-right card-option">
                                <a href="<?=cn("instagram/post/popup_search_media")?>" class="ajaxModal btn" data-toggle="tooltip" data-placement="left" title="" data-original-title="<?=lang('Search media on instagram')?>"><i class="ft-search"></i> <?=lang('search_media')?></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-block pt0">
                        <div class="row">
                            <div class="tab-type schedule-instagram-type file-manager-change-type">
                                <a href="javascript:void(0);" class="col-md-4 col-sm-4 col-xs-4 item active" data-type="photo" data-type-image="single">
                                    <i class="ft-image"></i> <?=lang('post')?>
                                    <input type="radio" name="type" value="photo" class="hide" checked="">
                                </a>
                                <a href="javascript:void(0);" class="col-md-4 col-sm-4 col-xs-4 item" data-type="story" data-type-image="single">
                                    <i class="ft-camera"></i> <?=lang('story')?>
                                    <input type="radio" name="type" class="hide" value="story">
                                </a>
                                <a href="javascript:void(0);" class="col-md-4 col-sm-4 col-xs-4 item" data-type="carousel" data-type-image="multi">
                                    <i class="ft-layers"></i> <?=lang('carousel')?>
                                    <input type="radio" name="type" class="hide" value="carousel">
                                </a>
                            </div>
                        </div>

                        <?=modules::run("file_manager/block_file_manager")?>

                        <div class="form-group form-caption">
                            <div class="list-icon">
                                <a href="javascript:void(0);" class="getCaption" data-toggle="tooltip" data-placement="left" title="<?=lang("get_caption")?>"><i class="ft-command"></i></a>
                                <a href="javascript:void(0);" data-toggle="tooltip" class="saveCaption" data-placement="left" title="<?=lang("save_caption")?>"><i class="ft-save"></i></a>
                            </div>
                            <textarea class="form-control post-message" name="caption" rows="3" placeholder="<?=lang('add_a_caption')?>" style="height: 114px;"></textarea>
                        </div>

                        <div class="form-group">
                            <div class="pure-checkbox grey mr15">
                                <input type="checkbox" id="md_checkbox_schedule" name="is_schedule" class="filled-in chk-col-red enable_instagram_schedule" value="on">
                                <label class="p0 m0" for="md_checkbox_schedule">&nbsp;</label>
                                <span class="checkbox-text-right"> <?=lang('schedule')?></span>
                            </div>
                            <?php 
                                $enable_advance_option = (int)get_option('enable_advance_option',1); 
                                if($enable_advance_option){
                            ?>
                            <div class="pure-checkbox grey">
                                <input type="checkbox" id="md_checkbox_comment" name="advance" class="filled-in chk-col-red enable_instagram_comment" value="on">
                                <label class="p0 m0" for="md_checkbox_comment" data-toggle="collapse" data-target="#comment-option">&nbsp;</label>
                                <span class="checkbox-text-right"> <?=lang('advance_option')?></span>
                            </div>
                            <?php } ?>
                        </div>
                        
                        <div class="form-group collapse form-caption" id="comment-option">
                            <div class="list-icon">
                                <a href="javascript:void(0);" class="getCaption" data-toggle="tooltip" data-placement="left" title="<?=lang("get_caption")?>"><i class="ft-command"></i></a>
                                <a href="" data-toggle="tooltip" data-placement="left" title="<?=lang("save_caption")?>"><i class="ft-save"></i></a>
                            </div>
                            <textarea class="form-control post-message" name="comment" rows="3" placeholder="<?=lang('add_a_first_comment_on_your_post')?>" style="height: 114px;"></textarea>
                        </div>

                        <div class="schedule-option collapse in" id="schedule-option">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="time_post"> <?=lang('time_post')?></label>
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
                        <div class="preview-instagram preview-instagram-photo">
                            <div class="preview-header">
                                <div class="pull-left"><i class="ft-camera"></i></div>
                                <div class="instagram-logo"><img src="<?=BASE?>public/instagram/assets/img/instagram-logo.png"></div>
                                <div class="pull-right"><i class="icon-paper-plane"></i></div>
                            </div>
                            <div class="preview-content">
                                <div class="user-info">
                                    <img class="img-circle" src="<?=BASE?>public/instagram/assets/img/avatar.png">
                                    <span><?=lang('anonymous')?></span>
                                </div>
                                <div class="preview-image">
                                </div>
                                <div class="post-info">
                                    <div class="info-active pull-left"> <?=lang('be_the_first_to_Like_this')?></div>
                                    <div class="pull-right">1s</div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="caption-info pt0">
                                    <div class="line-no-text"></div>
                                    <div class="line-no-text"></div>
                                    <div class="line-no-text w50"></div>
                                </div>
                                <div class="preview-comment">
                                    <?=lang("add_a_comment")?>…                                    
                                    <div class="icon-3dot"></div>
                                </div>
                            </div>
                        </div>
                        <div class="preview-instagram preview-instagram-story hide"></div>
                        <div class="preview-instagram preview-instagram-carousel hide">
                            <div class="preview-header">
                                <div class="pull-left"><i class="ft-camera"></i></div>
                                <div class="instagram-logo"><img src="<?=BASE?>public/instagram/assets/img/instagram-logo.png"></div>
                                <div class="pull-right"><i class="icon-paper-plane"></i></div>
                            </div>
                            <div class="preview-content">
                                <div class="user-info">
                                    <img class="img-circle" src="<?=BASE?>public/instagram/assets/img/avatar.png">
                                    <span><?=lang('anonymous')?></span>
                                </div>
                                <div class="preview-image">
                                    <div id="preview-carousel" class="preview-carousel carousel slide"></div>
                                </div>
                                <div class="post-info">
                                    <div class="info-active pull-left"> <?=lang('be_the_first_to_Like_this')?></div>
                                    <div class="pull-right">1s</div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="caption-info pt0">
                                    <div class="line-no-text"></div>
                                    <div class="line-no-text"></div>
                                    <div class="line-no-text w50"></div>
                                </div>
                                <div class="preview-comment">
                                    <?=lang("add_a_comment")?>… 
                                    <div class="icon-3dot"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>