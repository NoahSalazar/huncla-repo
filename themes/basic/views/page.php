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
    <link rel="stylesheet" type="text/css" href="<?=BASE?>assets/css/landing-page.css">
    <script type="text/javascript" src="<?=BASE?>assets/plugins/jquery/jquery.min.js"></script>
</head>
<body>

    <header class="">
        <nav class="navbar">
            <div class="container">
                <div class="navbar-header">
                    <div class="logo">
                        <a href="<?=PATH?>"><img src="<?=get_option("website_logo_white", BASE.'assets/img/logo-white.png')?>"></a>
                    </div>
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <ul class="menu collapse navbar-collapse" id="navbar-collapse">
                    <li><a href="<?=PATH?>#home" class=""> <?=lang('home')?></a></li>
                    <li><a href="<?=PATH?>#benefits"> <?=lang('benefits')?></a></li>
                    <?php if(get_payment()){?>
                    <li><a href="<?=PATH?>#pricing"> <?=lang('pricing')?></a></li>
                    <?php }?>
                    <?php if(session("uid")){?>
                    <li class="btn-oauth btn-dashboard">
                        <a href="<?=cn('dashboard')?>"><?=lang('dashboard')?> <i class="ft-arrow-right" aria-hidden="true"></i></a>
                    </li>
                    <?php }else{?>
                    <li class="btn-oauth btn-login"><a href="<?=PATH.'auth/login'?>"><?=lang('login')?></a></li>
                    <li class="btn-oauth btn-register"><a href="<?=PATH.'auth/signup'?>"><?=lang('signup')?></a></li>
                    <?php }?>
                </ul>
                <!-- <div class="clearfix"></div> -->
            </div>
        </nav>
    </header>
    
    <div class="container" style="margin-top: 130px; margin-bottom: 67px;">
	    <div class="custom-page">
	        <h3 class="title"></h3>

	        <div class="cp-content">
	            <?=$result->content?>
	        </div>
	    </div>
	</div>

    <footer>
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <img alt="Image" class="logo" src="<?=get_option("website_logo_black", BASE.'assets/img/logo-black.png')?>">
                        <ul class="list-inline list--hover">
                            <li class="list-inline-item">
                                <a href="<?=cn("auth/signup")?>">
                                    <span class="type--fine-print"> <?=lang('get_started')?></span>
                                </a>
                            </li>
                            <li>
                                <a href="mailto:<?=lang('contact_email')?>">
                                    <span class="type--fine-print"> <?=lang('contact_email')?></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6 text-right text-center-xs">
                        <ul class="social-list list-inline list--hover">
                            <?php if(get_option("social_page_facebook", "") != ""){?>
                            <li class="list-inline-item">
                                <a href="<?=get_option("social_page_facebook", "")?>">
                                    <i class="fa fa-facebook-square"></i>
                                </a>
                            </li>
                            <?php }?>
                            <?php if(get_option("social_page_google", "") != ""){?>
                            <li class="list-inline-item">
                                <a href="<?=get_option("social_page_google", "")?>">
                                    <i class="fa fa-google"></i>
                                </a>
                            </li>
                            <?php }?>
                            <?php if(get_option("social_page_twitter", "") != ""){?>
                            <li class="list-inline-item">
                                <a href="<?=get_option("social_page_twitter", "")?>">
                                    <i class="fa fa-twitter"></i>
                                </a>
                            </li>
                            <?php }?>
                            <?php if(get_option("social_page_instagram", "") != ""){?>
                            <li class="list-inline-item">
                                <a href="<?=get_option("social_page_instagram", "")?>">
                                    <i class="fa fa-instagram"></i>
                                </a>
                            </li>
                            <?php }?>
                            <?php if(get_option("social_page_pinterest", "") != ""){?>
                            <li class="list-inline-item">
                                <a href="<?=get_option("social_page_pinterest", "")?>">
                                    <i class="fa fa-pinterest"></i>
                                </a>
                            </li>
                            <?php }?>
                        </ul>
                    </div>
                </div>
                <!--end of row-->
                <div class="row">
                    <div class="col-md-6">
                        <p class="type--fine-print">
                            <?=lang('supercharge_your_web_workflow')?>
                        </p>
                    </div>
                    <div class="col-md-6 text-right text-center-xs">
                        <span class="type--fine-print">©
                            <span class="update-year"><?=lang('the_current_year')?></span> <?=lang('company_name')?></span>
                        <!-- <a class="type--fine-print" href="#"> <?=lang('privacy_policy')?></a> -->
                    </div>
                </div>
                <!--end of row-->
            </div>
        </div>
        <div class="clearfix"></div>
    </footer>
    <script type="text/javascript" src="<?=BASE?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?=BASE?>assets/js/landing-page.js"></script>
    <?=htmlspecialchars_decode(get_option('embed_javascript', ''), ENT_QUOTES)?>
</body>
</html>

