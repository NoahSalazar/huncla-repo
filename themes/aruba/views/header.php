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

    <link rel="stylesheet" type="text/css" href="<?=BASE?>themes/aruba/assets/plugins/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?=BASE?>themes/aruba/assets/plugins/ladda/ladda-themeless.min.css">
    <link rel="stylesheet" type="text/css" href="<?=BASE?>themes/aruba/assets/fonts/line-awesome/css/line-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?=BASE?>themes/aruba/assets/fonts/font-awesome/css/font-awesome.min.css">


    <link rel="stylesheet" type="text/css" href="<?=BASE?>themes/aruba/assets/css/animate.css">
    <link rel="stylesheet" type="text/css" href="<?=BASE?>themes/aruba/assets/css/style.css">
    <script type="text/javascript" src="<?=BASE?>assets/plugins/jquery/jquery.min.js"></script>
    <script type="text/javascript">
        var token = '<?=$this->security->get_csrf_hash()?>',
            PATH  = '<?=PATH?>',
            BASE  = '<?=BASE?>';
    </script>
</head>
<body class="aruba">

	<?php if($show){?>
	<!-- Header -->
	<header class="header">
		<nav class="navbar navbar-expand-lg navbar-light container">
		  	<a class="navbar-brand" href="<?=PATH?>">
		  		<img class="logo-white" src="<?=get_option("website_logo_white", BASE.'assets/img/logo-white.png')?>">
		  		<img class="logo-black" src="<?=get_option("website_logo_black", BASE.'assets/img/logo-black.png')?>">
		  	</a>
		  	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
		    	<i class="fa fa-bars"></i>
		  	</button>
		  	<div class="collapse navbar-collapse" id="navbarText">
			    <ul class="navbar-nav mr-auto">
			      	<li class="nav-item active">
			        	<a class="nav-link" href="<?=PATH?>#home"><?=lang("home")?></a>
			      	</li>
			      	<li class="nav-item">
			        	<a class="nav-link" href="<?=PATH?>#features"><?=lang("features")?></a>
			      	</li>
			      	<li class="nav-item">
			        	<a class="nav-link" href="<?=PATH?>#pricing"><?=lang("pricing")?></a>
			      	</li>
			    </ul>
			    <span class="navbar-btn">
			    	<?php if(!session("uid")){?>
				      	<a href="<?=cn("auth/login")?>" class="btn btn-login"><?=lang("login")?></a>
				      	<?php if(get_option("singup_enable", 1)){?>
				      		<a href="<?=cn("auth/signup")?>" class="btn btn-signup"><?=lang("signup")?></a>
			      		<?php }?>
			      	<?php }else{?>
			      	<a href="<?=cn("dashboard")?>" class="btn btn-signup"><?=lang("dashboard")?></a>
			      	<?php }?>

			      	<?php 
                    $lang_default = get_default_language();
                    if(!empty($lang_default)){
                    ?>
                    <div class="btn-group btn-lang">
					  	<button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					    	<?=$lang_default->name?>
					  	</button> 
					  	<div class="dropdown-menu">
					  		<?php if(!empty($languages)){
	                        foreach ($languages as $key => $value) {
	                        ?>
						    <a class="dropdown-item actionItem" href="<?=cn('set_language')?>" data-redirect="<?=current_url()?>" data-id="<?=$value->code?>"><?=$value->name?></a>
						    <?php }}?>
					  	</div>
					</div>

                    <?php }?>
					
			    </span>
		  	</div>
		</nav>
	</header>
	<!-- Header End -->
	<?php }?>