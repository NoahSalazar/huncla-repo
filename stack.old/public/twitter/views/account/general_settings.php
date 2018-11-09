<div class="lead"><?=lang('general')?></div>

<div class="row">
    <div class="col-md-12">
        <div class="item form-group">
            <span class="text"> <?=lang('twitter_consumer_key')?></span> 
            <!-- <i class="webuiPopover fa fa-question-circle" data-content="<p>Only working when</p>" data-delay-show="300" data-title="Twitter App ID"></i> -->
            <div class="activity-option-input">
                <input type="text" class="form-control" name="twitter_app_id" value="<?=get_option("twitter_app_id", "")?>">
          </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="item form-group">
            <span class="text">  <?=lang('twitter_consumer_secret')?></span> 
            <!-- <i class="webuiPopover fa fa-question-circle" data-content="<p>Only working when</p>" data-delay-show="300" data-title="Twitter App Secret"></i> -->
            <div class="activity-option-input">
                <input type="text" class="form-control" name="twitter_app_secret" value="<?=get_option("twitter_app_secret", "")?>">
          </div>
        </div>
    </div>
</div>
