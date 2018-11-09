<div class="wrap-content container schedules schedules-list" data-action="<?=cn(segment(1)."/post/ajax_schedules")?>" data-content="ajax-sc-list" data-append_content="1" data-result="html" data-page="0" data-hide-overplay="0">
    <div class="row">
        <div class="col-md-12">
            <div class="sc-head">
                <div class="item sc-processing <?=!get("t")?"active":""?>">
                    <a href="<?=cn(segment(1)."/post/schedules/{$date}")?>" class="name"><?=lang('processing')?> <span><?=($count_status && isset($count_status[1]))?$count_status[1]:0?></span></a>
                </div>
                <div class="item sc-complete <?=get("t")==2?"active":""?>">
                    <?php
                    $count_total = 0;
                    if(isset($count_status[2])) $count_total += $count_status[2];
                    if(isset($count_status[3])) $count_total += $count_status[3];
                    ?>
                    <a href="<?=cn(segment(1)."/post/schedules/{$date}?t=2")?>" class="name"><?=lang('complete')?> <span><?=$count_total?></span></a>
                </div>
            </div>
            <div class="sc-actions mb15">
                <div class="sc-form form-inline">
                    <span class="small"> <?=lang('select_account')?> </span>
                    <input type="hidden" name="schedule_type" value="<?=get("t")?>" >
                    <div class="form-group">
                        <select class="form-control" name="schedule_account">
                            <?php if(!empty($accounts)){
                            foreach ($accounts as $key => $row) {
                            ?>
                            <option value="<?=$row->ids?>"><?=$row->username." (".$row->total.")"?></option>
                            <?php }}?>
                        </select>
                    </div>
                    <a href="<?=cn(segment(1)."/post/ajax_delete_schedules")?>" data-redirect="<?=current_url()?>" data-id="-1" class="btn btn-danger pull-right actionItem" data-confirm="Are you sure want delete it?"> <?=lang('delete_all')?></a>
                    <div class="clearfix"></div>
                </div>  
            </div>
            <div class="sc-list">
                <div class="row ajax-sc-list">
                    
                </div>
            </div>
        </div>
    </div>
</div>