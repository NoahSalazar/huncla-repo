
<div class="lead"> <?=lang('post')?></div>
<div class="row">
	<div class="col-md-3">
		<div class="item form-group">
			<span class="text"> <?=lang('min_post_interval_seconds')?></span> 
			<div class="activity-option-input">
				<input type="number" class="form-control" name="fb_min_post_interval_seconds" value="<?=get_option("fb_min_post_interval_seconds", 50)?>">
		  </div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="item form-group">
			<span class="text"> <?=lang('auto_pause_after_posts')?></span> 
			<div class="activity-option-input">
				<input type="number" class="form-control" name="fb_post_auto_pause_after_post" value="<?=get_option("fb_post_auto_pause_after_post", 50)?>">
		  </div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="item form-group">
			<span class="text"> <?=lang('auto_resume_after_minutes/hours')?></span> 
			<div class="activity-option-input">
				<input type="number" class="form-control" name="fb_post_auto_resume_after_minute_hours" value="<?=get_option("fb_post_auto_resume_after_minute_hours", 50)?>">
		  </div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="item form-group">
			<span class="text"> <?=lang('repeat_frequency')?></span> 
			<div class="activity-option-input">
				<input type="number" class="form-control" name="fb_post_repeat_frequency" value="<?=get_option("fb_post_repeat_frequency", 50)?>">
		  </div>
		</div>
	</div>
</div>