<div class="section-1" id="home">
    <div class="container">
        <div class="box-content">
            <div class="title-small"> <?=lang('we_are_your')?></div>
            <div class="title"> <?=lang('social_media_solutions')?></div>
            <span class="desc"> <?=lang('save_time_do_more_manage_multiple_social_networks_at_one_place')?> </span>
            <div class="btn-go">
                <a href="<?=(session("uid")?cn("dashboard"):"#pricing")?>" class="btn btn-large"> <?=lang('try_to_now')?></a>
            </div>
        </div>
    </div>
</div>
<div class="section-2" id="benefits">
    <div class="container">
        <div class="title">  <?=lang('benefits')?></div>
        <div class="desc">  <?=lang('why_our_tools_is_the_best_service_for_social_network_automation')?></div>

        <div class="col-md-4">
            <div class="item">
                <div class="icon"><span class="be be-download"></span></div>
                <div class="name"> <?=lang('no_downloads')?></div>
                <div class="caption">
                    <?=lang('no_downloads_desc')?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="item">
                <div class="icon"><span class="be be-clock"></span></div>
                <div class="name"><?=lang('saving_time')?></div>
                <div class="caption">
                    <?=lang('saving_time_desc')?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="item">
                <div class="icon"><span class="be be-smart"></span></div>
                <div class="name"><?=lang('set_schedule_your_posts')?> </div>
                <div class="caption">
                    <?=lang('set_schedule_your_posts_desc')?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="item">
                <div class="icon"><span class="be be-social"></span></div>
                <div class="name"><?=lang('analytics_performance_of_your_posts')?></div>
                <div class="caption">
                    <?=lang('analytics_performance_of_your_posts_desc')?>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="item">
                <div class="icon"><span class="be be-debt"></span></div>
                <div class="name"><?=lang('influencer_marketing')?></div>
                <div class="caption">
                    <?=lang('influencer_marketing_desc')?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="item">
                <div class="icon"><span class="be be-report"></span></div>
                <div class="name"><?=lang('safe_and_secure')?></div>
                <div class="caption">
                    <?=lang('safe_and_secure_desc')?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="section-7">
    <div class="wrap">
        <div class="title"><?=lang('why_choose_us')?>?</div>
        <div class="desc lead"><?=lang('why_choose_us_desc')?></div>

        <div class="content"> <?=lang('why_choose_us_content')?>
            
        </div>  
    </div>
</div>

<?php if(get_payment()){?>
<?=Modules::run("payment/block_pricing")?>
<?php }?>

