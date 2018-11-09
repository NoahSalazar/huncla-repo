<?php if(!empty($schedules)){
    foreach ($schedules as $key => $row) {
        $data = json_decode($row->data);

        $type = "text";
        $media = $data->media;
        $image = "";
        $link = "";
        $images = array();

        if(isset($data->link)){
            $link = $data->link;
        }

        if($link == "" && $image == "" && empty($images)){
            $type = "text";
        }

        if(count($data->media) == 1 && $link == ""){
            $image = $media[0];
            $type = "media";
        }

        if(count($data->media) > 1){
            $images = $media;
            $type = "multi_media";
        }

        if(count($data->media) == 0 && $link != ""){
            $type = "link";
        }

        if(count($data->media) == 1 && $link != ""){
            $images = $media[0];
            $type = "media_link";
        }

?>
<div class="col-md-3 col-sm-4 col-xs-6">
    <div class="item">
        <div class="sc-user">
            <i class="ft-user"></i> <?=$row->username?>
        </div>
        <div class="sc-option">
            <div class="dropdown">
                <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                    <i class="ft-more-vertical"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-right">
                    <li><a href="<?=cn(segment(1)."/post/ajax_delete_schedules")?>" class="actionItem" data-id="<?=$row->ids?>"><?=lang('delete')?></a></li>
                </ul>
            </div>
        </div>

        <?php if($type == "text"){?>
        <div class="img">
            <i class="sc-link ft-align-center"></i>
        </div>
        <?php }?>

        <?php if($type == "link"){?>
        <div class="img">
            <a href="<?=$link?>" target="_blank"><i class="sc-link ft-link"></i></a>
        </div>
        <?php }?>

        <?php if($type == "media"){?>
            <?php if(check_image($image)){?>
            <div class="img" style="background-image: url(<?=$image?>);"></div>
            <?php }else{?>
            <div class="img">
                <video src="<?=$image?>" playsinline="" muted="" loop=""></video>
                <i class="btn-play ft-play"></i>
            </div>
            <?php }?>
        <?php }?>

        <?php if($type == "multi_media" && !empty($images)){?>
        <div class="img">
            <div class="owl-carousel">
                <?php foreach ($images as $key => $image) {?>
                    <?php if(check_image($image)){?>
                    <div style="background-image: url(<?=$image?>);"></div>
                    <?php }else{?>
                    <div>
                        <video src="<?=$image?>" playsinline="" muted="" loop=""></video>
                        <i class="btn-play ft-play"></i>
                    </div>
                    <?php }?>
                <?php }?>
            </div>
        </div>
        <?php }?>

        <?php if($type == "media_link"){?>
            <?php if(check_image($image)){?>
            <div class="img" style="background-image: url(<?=$image?>);">
                <a href="<?=$link?>" target="_blank"><i class="sc-link-small ft-link"></i></a>
            </div>
            <?php }else{?>
            <div class="img">
                <video src="<?=$image?>" playsinline="" muted="" loop=""></video>
                <i class="btn-play ft-play"></i>
                <a href="<?=$link?>" target="_blank"><i class="sc-link-small ft-link"></i></a>
            </div>
            <?php }?>
        <?php }?>

        <div class="sc-info">
            <div class="caption"><?=$data->caption?></div>
            <div class="time"><span class="ft-calendar"></span> <?=get_timezone_user($row->time_post, true)?></div>
        </div>
        <div class="sc-btn">
            
        </div>
    </div>
</div>
<?php }}else{?>
<div class="schedule_empty">
    
</div>
<?php }?>

<script type="text/javascript">
    $(function(){
        $(".owl-carousel").owlCarousel({
            items: 1,
            dots: true,
        });
    });
</script>