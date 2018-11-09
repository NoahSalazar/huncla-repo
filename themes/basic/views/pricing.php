<!DOCTYPE html>
<html>
<head>
    <title><?=get_option("website_title", "Stackposts - Social Marketing Tool")?></title>
    <meta name="description" content="<?=get_option("website_description", "save time, do more, manage multiple social networks at one place")?>" />
    <meta name="keywords" content="<?=get_option("website_keyword", 'social marketing tool, social planner, automation, social schedule')?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/png" href="<?=get_option("website_favicon", BASE.'assets/img/favicon.png')?>" />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?=BASE?>assets/plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?=BASE?>assets/plugins/bootstrap/css/bootstrap-extended.min.css">
    <link rel="stylesheet" type="text/css" href="<?=BASE?>assets/plugins/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?=BASE?>assets/plugins/font-feather/feather.min.css">
    <link rel="stylesheet" type="text/css" href="<?=BASE?>assets/plugins/font-ps/css/pe-icon-7-stroke.css">
    <link rel="stylesheet" type="text/css" href="<?=BASE?>assets/css/colors.min.css">
    <link rel="stylesheet" type="text/css" href="<?=BASE?>assets/css/layout.css">
    <link rel="stylesheet" type="text/css" href="<?=BASE?>assets/css/pricing-page.css">
    <script type="text/javascript" src="<?=BASE?>assets/plugins/jquery/jquery.min.js"></script>
    <script type="text/javascript">
        var token = '<?=$this->security->get_csrf_hash()?>',
            PATH  = '<?=PATH?>',
            BASE  = '<?=BASE?>';
            GOOGLE_API_KEY   = 'AIzaSyA7rE-ngRgga_EJ38xZpAJkukB1bCoxOV0';
            GOOGLE_CLIENT_ID = '1088992811074-98f4e7d22gebaodjfa94hfdimnmvk6cl.apps.googleusercontent.com';
    </script>
</head>
<body>
    <div class="section-4" id="pricing">
        <div class="container content">
            <div class="row">
                <div class="title"> <?=lang('pricing')?></div>
                <div class="desc"> <?=lang('pick_the_best_plan_for_you')?>!</div>
                <!-- Pricing -->
                
                <div class="pricing-list-box centered">
                    <?php if(!empty($package)){
                    $social_list = load_social_list();
                    foreach ($package as $key => $row) {
                        $pricing_monthly = number_format($row->price_monthly,2);
                        $pricing_monthly_explode = explode(".", $pricing_monthly);
                        $pricing_anually = number_format($row->price_annually,2);
                        $pricing_discount = number_format(($row->price_monthly - $row->price_annually)*12, 2);
                        $permission = (array)json_decode($row->permission);

                        $social_list_permission = array();
                        foreach ($social_list as $name) {
                            if((in_array(strtolower($name)."_enable",$permission))){
                                $social_list_permission[] = $name;
                            }
                        }
                        $social_count = count($social_list_permission);
                     ?>

                    <div class="col-md-4 col-xs-10">
                        <div class="pricing hover-effect">
                            <div class="pricing-head">
                                <h3><?=$row->name?> <span> <?=$row->description?> </span> </h3>
                                <h4>
                                    <div class="monthly">
                                        <i><?=get_option('payment_symbol')?></i> <?=$pricing_monthly_explode[0]?><i>.<?=$pricing_monthly_explode[1]?></i>
                                        <span><?=get_option('payment_currency')?> / <?=lang('per_month')?> </span>
                                    </div>

                                    <div class="anually">
                                        <span class="small"><?=lang('annual_price')?>: <?=$pricing_anually?> <?=get_option('payment_currency')?></span>
                                        <?php if($pricing_discount > 0){?>
                                        <span class="small">
                                            <?=lang('you_save')?>: <div class="price-discount"><?=$pricing_discount." ".get_option('payment_currency')?></div>
                                        </span>
                                        <?php }?>
                                    </div>
                                </h4>
                            </div>
                            <ul class="pricing-content list-unstyled">
                                <li><?=sprintf(lang('add_up_to_social_accounts'),$social_count*$row->number_accounts)?> <br/> <div class="small note">(<?=sprintf(lang('social_account_on_each_platform'),$row->number_accounts)?>)</div></li>
                            </ul>
                            <div class="package-detail">
                                <ul class="pricing-content list-unstyled">
                                    <?php 
                                    if(!empty($social_list)){
                                        foreach ($social_list as $key => $name) {
                                    ?>
                                    <li class="<?=(in_array(strtolower($name)."_enable",$permission))?"":"underline note";?>"><b><?=lang(strtolower($name))?></b> <?=lang('scheduling_automation')?></li>
                                    <?php }}?>
                                </ul>
                            </div>
                            <ul class="pricing-content list-unstyled">
                                <li> <?=lang('premium_support')?></li>
                                <li> <?=lang('spintax_support')?></li>
                                <li class="cloud" style="min-height: 69px;"> <?=lang('cloud_import')?>: <br/>
                                    <?php if(in_array("google_drive",$permission) || in_array("dropbox",$permission)){?>
                                        <?php if(in_array("google_drive",$permission)){?>
                                        <i class="fa fa-google-drive" aria-hidden="true"></i>
                                        <?php }?>

                                        <?php if(in_array("dropbox",$permission)){?>
                                        <i class="fa fa-dropbox" aria-hidden="true"></i>
                                        <?php }?>
                                    <?php }else{?>
                                    <span class="note"><?=lang('not_available')?></span>
                                    <?php }?>
                                </li>
                                <li class="cloud"><?=lang('file_type_support')?>: <br/>
                                    <?php if(in_array("photo_type",$permission) || in_array("video_type",$permission)){?>
                                    <span class="filetype note <?=in_array("photo_type",$permission)?"":"underline"?>">Photo</span>, 
                                    <span class="filetype note <?=in_array("video_type", $permission)?"":"underline"?>">Video</span>
                                    <?php }else{?>
                                    <span class="note"><?=lang('not_available')?></span>
                                    <?php }?>
                                </li>
                                <li> <?=lang('max_storage_size_ouput')?> <strong class="blue"><?=get_value($permission, "max_storage_size")?> <?=lang("mb")?></strong></li>
                                <li> <?=lang('max_file_size_output')?> <strong class="blue"><?=get_value($permission, "max_file_size")?> <?=lang("mb")?></strong></li>
                            </ul>
                            <div class="pricing-footer">
                                <a href="<?=(session("uid"))?cn('payment/'.$row->ids):cn("auth/login?redirect=payment/".$row->ids)?>" class="btn yellow-crusta style="text-transform: uppercase;"> <?=lang('upgrade_now')?></a>
                            </div>
                        </div>
                    </div>

                    <?php }}?>

                    <div class="clearfix"></div>
                </div>
                <div class="text-center mt15"><a href="<?=PATH?>" style="color: #c7c7c7;"><i class="fa fa-angle-double-left" aria-hidden="true"></i> <?=lang('back_to_home')?></a></div>
                <!--//End Pricing -->
            </div>
        </div>
    </div>

    <script type="text/javascript" src="<?=BASE?>assets/js/moment.js"></script>
    <script src="https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>
    <script type="text/javascript" src="<?=BASE?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?=BASE?>assets/js/landing-page.js"></script>
    <script type="text/javascript" src="<?=BASE?>assets/js/main.js"></script>
    <?=htmlspecialchars_decode(get_option('embed_javascript', ''), ENT_QUOTES)?>
</body>
</html>

