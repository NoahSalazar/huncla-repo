<div class="wrap-content container facebook-app">
    <div class="row">
        <div class="col-md-8">
            <form action="<?=PATH?>facebook/post/ajax_post" method="POST" class="actionForm">
            <input type="hidden" class="form-control" name="list_ids" value="">
            <div class="card">
                <?=modules::run("caption/popup")?>

                <div class="card-overplay" style="display: none;"><i class="pe-7s-config pe-spin"></i></div>
                <div class="card-header">
                    <div class="card-title">
                        <i class="fa ft-edit" aria-hidden="true"></i> <?=lang('new_post')?> 
                    </div>
                </div>
                <div class="card-block pt0">
                    <div class="row">
                        <div class="tab-type schedule-facebook-type file-manager-change-type">
                            <a href="#media" class="col-xs-4 col-sm-4 col-md-4 item active" data-toggle="tab" data-type="media" data-type-image="multi">
                                <i class="ft-camera"></i> <?=lang('media')?>
                                <input type="radio" name="type" class="hide" value="media" checked="">
                            </a>
                            <a href="#link" class="col-xs-4 col-sm-4 col-md-4 item" data-toggle="tab" data-type="link">
                                <i class="ft-link"></i> <?=lang('link')?>
                                <input type="radio" name="type" class="hide" value="link">
                            </a>
                            <a href="#text" class="col-xs-4 col-sm-4 col-md-4 item" data-toggle="tab" data-type="text">
                                <i class="ft-file"></i> <?=lang('text')?>
                                <input type="radio" name="type" class="hide" value="text">
                            </a>
                        </div>
                    </div> 
                    
                    <?=modules::run("file_manager/block_file_manager", "multi")?>

                    <div class="form-group form-caption facebook-text max">
                        <div class="list-icon">
                            <a href="javascript:void(0);" class="getCaption" data-toggle="tooltip" data-placement="left" title="<?=lang("get_caption")?>"><i class="ft-command"></i></a>
                            <a href="javascript:void(0);" data-toggle="tooltip" class="saveCaption" data-placement="left" title="<?=lang("save_caption")?>"><i class="ft-save"></i></a>
                        </div>
                        <textarea class="form-control post-message" name="caption" rows="3" placeholder="<?=lang('add_a_caption')?>" style="height: 114px;"></textarea>
                    </div>

                    <div class="tab-content b0">
                        <div id="link" class="tab-pane fade in">
                            <div class="form-group form-help">
                                <!-- <i class="webuiPopover  fa fa-question-circle" data-content="<p>Only working when</p>" data-delay-show="300" data-title="Limit search members on group"></i> -->
                                <input type="input" class="form-control" name="link" placeholder=" <?=lang('enter_link')?>" value="">
                            </div>
                        </div>
                    </div>
                    <div class="row hide">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email"> <?=lang('auto_delete')?></label>
                                <select class="form-control">
                                    <option value="1">1</option>
                                    <option value="1">2</option>
                                    <option value="1">3</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="pure-checkbox grey mr15">
                            <input type="checkbox" id="md_checkbox_schedule" name="is_schedule" class="filled-in chk-col-red enable_facebook_schedule" value="on">
                            <label class="p0 m0" for="md_checkbox_schedule">&nbsp;</label>
                            <span class="checkbox-text-right"> <?=lang('schedule')?></span>
                        </div>
                    </div>

                    <div class="postnow-option" id="postnow-option">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label> <?=lang('post_interval_seconds')?></label>
                                    <select name="postnow_delay" class="form-control">
                                        <?php for ($i=1; $i < 1000; $i++) {
                                        if($i%10 == 0){
                                        ?>
                                            <option value="<?=$i?>"><?=$i?></option>
                                        <?php }}?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div> 

                    <div class="schedule-option hide" id="schedule-option">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="time_post"> <?=lang('time_post')?></label>
                                    <input type="text" name="time_post" class="form-control datetime" id="time_post">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label> <?=lang('post_interval_minutes/hours')?></label>
                                    <select name="delay" class="form-control">
                                        <optgroup label="Minutes">
                                            <?php for ($i=1; $i <= 60; $i++) {
                                            ?>
                                                <option value="<?=$i*60?>"><?=$i?> <?=lang('minutes')?></option>
                                            <?php }?>
                                        </optgroup>
                                        <optgroup label="Hours">
                                            <?php for ($i=1; $i <= 60; $i++) {
                                            ?>
                                                <option value="<?=$i*60*60?>"><?=$i?> <?=lang('hours')?></option>
                                            <?php }?>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label> <?=lang('auto_pause_after_posts')?></label>
                                    <select name="pause" class="form-control">
                                        <?php for ($i=1; $i <= 60; $i++) {
                                        ?>
                                            <option value="<?=$i*60?>"><?=$i?></option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label> <?=lang('auto_resume_after_minutes/hours')?></label>
                                    <select name="delay" class="form-control">
                                        <optgroup label="Minutes">
                                            <?php for ($i=1; $i <= 60; $i++) {
                                            ?>
                                                <option value="<?=$i*60?>"><?=$i?> <?=lang('minutes')?></option>
                                            <?php }?>
                                        </optgroup>
                                        <optgroup label="Hours">
                                            <?php for ($i=1; $i <= 60; $i++) {
                                            ?>
                                                <option value="<?=$i*60*60?>"><?=$i?> <?=lang('hours')?></option>
                                            <?php }?>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label> <?=lang('repeat_frequency')?></label>
                                    <select name="repeat_every" id="repeat_every" class="form-control">
                                        <option value="0"> <?=lang('once')?></option>
                                        <option value="1"> <?=lang('every_day')?> </option>
                                        <?php for ($i=2; $i <=60 ; $i++) { 
                                        ?>
                                        <option value="<?=$i?>"><?=sprintf(lang('every_x_days'),$i)?></option>
                                        <?php  }?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label> <?=lang('end_on')?>:</label>
                                    <input type="text" name="repeat_end" class="form-control datetime" id="repeat_end">
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
            </form>

            <div class="card">
                <div class="card-header p0">
                    <ul class="nav nav-tabs">
                        <li class="active"><a class="actionLoadFB" data-toggle="tab" href="#profiles"><i class="fa fa-facebook-square"></i> <?=lang('profiles')?></a></li>
                        <li><a data-toggle="tab" href="#groups"><i class="fa fa-users"></i> <?=lang('groups')?></a></li>
                        <li><a data-toggle="tab" href="#pages"><i class="fa fa-font-awesome"></i> <?=lang('pages')?></a></li>
                        <li><a data-toggle="tab" href="#friends"><i class="fa fa-user"></i> <?=lang('friends')?></a></li>
                    </ul>
                </div>
                <div class="card-block p0">
                    <div class="tab-content">
                        <div id="profiles" class="tab-pane fade in active">
                            <a class="actionItem" href="<?=PATH?>facebook/ajax_get_accounts" data-content="facebook-post-content" data-result="html"></a>
                        </div>
                        <div id="groups" class="tab-pane fade">
                            <form action="<?=PATH?>facebook/ajax_get_groups/group" method="POST" class="actionForm" data-content="facebook-post-content" data-result="html">
                            <div class="input-group">
                                <select class="form-control selectpicker" data-live-search="true" name="id" ria-describedby="button-addon" >
                                    <?php if(!empty($accounts)){
                                        foreach ($accounts as $row) {
                                    ?>
                                    <option value="<?=$row->ids?>"><?=$row->fullname?></option>
                                    <?php }}?>
                                </select>
                                <span class="input-group-btn" id="button-addon">
                                    <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
                                </span>
                            </div>
                            </form>
                        </div>
                        <div id="pages" class="tab-pane fade">
                            <form action="<?=PATH?>facebook/ajax_get_groups/page" method="POST" class="actionForm" data-content="facebook-post-content" data-result="html">
                            <div class="input-group">
                                <select class="form-control selectpicker" data-live-search="true" name="id" ria-describedby="button-addon" >
                                    <?php if(!empty($accounts)){
                                        foreach ($accounts as $row) {
                                    ?>
                                    <option value="<?=$row->ids?>"><?=$row->fullname?></option>
                                    <?php }}?>
                                </select>
                                <span class="input-group-btn" id="button-addon">
                                    <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
                                </span>
                            </div>
                            </form>
                        </div>
                        <div id="friends" class="tab-pane fade">
                            <form action="<?=PATH?>facebook/ajax_get_groups/friend" method="POST" class="actionForm" data-content="facebook-post-content" data-result="html">
                            <div class="input-group">
                                <select class="form-control selectpicker" data-live-search="true" name="id" ria-describedby="button-addon" >
                                    <?php if(!empty($accounts)){
                                        foreach ($accounts as $row) {
                                    ?>
                                    <option value="<?=$row->ids?>"><?=$row->fullname?></option>
                                    <?php }}?>
                                </select>
                                <span class="input-group-btn" id="button-addon">
                                    <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
                                </span>
                            </div>
                            </form>
                        </div>
                    </div>

                    <div class="facebook-post-content">
                        
                    </div>
                </div>
            </div>
        </div>
        <?=Modules::run("facebook/post/preview")?>
    </div>
</div>