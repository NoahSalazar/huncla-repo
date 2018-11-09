<?php 
$successed = get_schedule_report(TWITTER_POSTS, 2);
$failed = get_schedule_report(TWITTER_POSTS, 3);
?>

<div class="lead"><?=lang('post')?></div>

	<div class="row">
	<div class="col-md-8">
		<div class="card-body box-analytic">
            <canvas id="tw-post-line-stacked-area" height="300"></canvas>
            <script type="text/javascript">
            $(function(){
    			Layout.lineChart(
    				"tw-post-line-stacked-area",
    				<?=$successed->date?>, 
    				[
    					<?=$successed->value?>,
    					<?=$failed->value?>
    				],
    				[
    					"<?=lang('successed')?>",
    					"<?=lang('failed')?>"
    				]
    			);
    		});
    		</script>
        </div>
    </div>
	<div class="col-md-4">
		<div class="card-body box-analytic">
            <canvas id="tw-post-chart-area" height="283"></canvas>
            <script type="text/javascript">
            	$(function(){
        			Layout.pieChart(
        				"tw-post-chart-area",
        				["<?=lang('photo')?>", "<?=lang('video')?>", "<?=lang('text')?>"], 
        				[
        					<?=get_setting("tw_post_photo_count", 0)?>,
        					<?=get_setting("tw_post_video_count", 0)?>,
        					<?=get_setting("tw_post_text_count", 0)?>
        				]
        			);
        		});
            </script>
        </div>
    </div>
</div>

<div class="row">
	<div class="col-md-4">
		<div class="card-body box-analytic">
            <div class="media">
                <div class="media-body text-left w-100">
                    <h3 class="success"><?=get_setting("tw_post_success_count", 0)?></h3>
                    <span><?=lang('successed')?></span>
                </div>
                <div class="media-right media-middle">
                    <i class="icon-user-follow success font-large-2 float-right"></i>
                </div>
            </div>
        </div>
	</div>
	<div class="col-md-4">
		<div class="card-body box-analytic">
            <div class="media">
                <div class="media-body text-left w-100">
                    <h3 class="danger"><?=get_setting("tw_post_error_count", 0)?></h3>
                    <span><?=lang('failed')?></span>
                </div>
                <div class="media-right media-middle">
                    <i class="icon-user-follow danger font-large-2 float-right"></i>
                </div>
            </div>
        </div>
	</div>
	<div class="col-md-4">
		<div class="card-body box-analytic">
            <div class="media">
                <div class="media-body text-left w-100">
                    <h3 class="primary"><?=get_setting("tw_post_error_count", 0) + get_setting("tw_post_success_count", 0)?></h3>
                    <span><?=lang('completed')?></span>
                </div>
                <div class="media-right media-middle">
                    <i class="icon-user-follow primary font-large-2 float-right"></i>
                </div>
            </div>
        </div>
	</div>
</div>