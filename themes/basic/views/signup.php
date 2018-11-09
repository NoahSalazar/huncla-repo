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
    <link rel="stylesheet" type="text/css" href="<?=BASE?>assets/plugins/izitoast/css/iziToast.min.css">
    <link rel="stylesheet" type="text/css" href="<?=BASE?>assets/css/colors.min.css">
    <link rel="stylesheet" type="text/css" href="<?=BASE?>assets/css/layout.css">
    <link rel="stylesheet" type="text/css" href="<?=BASE?>assets/css/oauth-page.css">
    <script type="text/javascript" src="<?=BASE?>assets/plugins/jquery/jquery.min.js"></script>
    <?php load_css();?>
    <script type="text/javascript">
        var token = '<?=$this->security->get_csrf_hash()?>',
            PATH  = '<?=PATH?>',
            BASE  = '<?=BASE?>';
    </script>
</head>
<body>
    <div class="loading-overplay"><div class="cssload-container"><div class="cssload-speeding-wheel"></div></div></div>
    <div class="bg-svg">
        <svg jsname="" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 810" preserveAspectRatio="xMinYMin slice" aria-hidden="true">
        <path fill="#f6fafc" d="M592.66 0c-15 64.092-30.7 125.285-46.598 183.777C634.056 325.56 748.348 550.932 819.642 809.5h419.672C1184.518 593.727 1083.124 290.064 902.637 0H592.66z"></path>
        <path fill="#f4f8fb" d="M545.962 183.777c-53.796 196.576-111.592 361.156-163.49 490.74 11.7 44.494 22.8 89.49 33.1 134.883h404.07c-71.294-258.468-185.586-483.84-273.68-625.623z"></path>
        <path fill="#fcfdfe" d="M153.89 0c74.094 180.678 161.088 417.448 228.483 674.517C449.67 506.337 527.063 279.465 592.56 0H153.89z"></path>
        <path fill="#f2f6f9" d="M153.89 0H0v809.5h415.57C345.477 500.938 240.884 211.874 153.89 0z"></path>
        <path fill="#fcfdfe" d="M1144.22 501.538c52.596-134.583 101.492-290.964 134.09-463.343 1.2-6.1 2.3-12.298 3.4-18.497 0-.2.1-.4.1-.6 1.1-6.3 2.3-12.7 3.4-19.098H902.536c105.293 169.28 183.688 343.158 241.684 501.638v-.1z"></path>
        <path fill="#eef4f8" d="M1285.31 0c-2.2 12.798-4.5 25.597-6.9 38.195C1321.507 86.39 1379.603 158.98 1440 257.168V0h-154.69z"></path>
        <path fill="#f4f8fb" d="M1278.31,38.196C1245.81,209.874 1197.22,365.556 1144.82,499.838L1144.82,503.638C1185.82,615.924 1216.41,720.211 1239.11,809.6L1439.7,810L1439.7,256.768C1379.4,158.78 1321.41,86.288 1278.31,38.195L1278.31,38.196z"></path>
        </svg>
    </div>
    
    <div class="oauth-wrap">
        <div class="oauth-header">
            <div class="logo">
                <a href="<?=PATH?>"><img src="<?=get_option("website_logo_black", BASE.'assets/img/logo-black.png')?>"></a>
            </div>
            <div class="slogan"> <?=lang('great_tool_for_social_marketing')?></div>
        </div>
        <div class="oauth-form">
            <ul class="nav nav-tabs">
                <li><a href="<?=PATH."auth/login"?>">  <?=lang('login')?></a></li>
                <li  class="active"><a href="javascript:void(0);">  <?=lang('signup')?></a></li>
            </ul>

            <div class="tab-content pb15">
                <form action="<?=cn('auth/ajax_register')?>" data-redirect1="<?=cn('auth/login')?>" class="actionForm" method="POST">
                <div class="tab-pane fade in active">
                    <div class="form-group">
                        <label for="fullname"> <?=lang('fullname')?>:</label>
                        <input type="text" class="form-control" id="fullname" name="fullname">
                    </div>
                    <div class="form-group">
                        <label for="email"> <?=lang('email_address')?>:</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                    <div class="form-group">
                        <label for="pwd"> <?=lang('password')?>:</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="form-group">
                        <label for="rpwd"> <?=lang('confirm_password')?>:</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                    </div>
                    <div class="form-group">
                        <label for="pwd"> <?=lang('select_your_timezone')?>:</label>
                        <select name="timezone" class="form-control auto-select-timezone">
                            <?php if(!empty(tz_list())){
                            foreach (tz_list() as $value) {
                            ?>
                            <option value="<?=$value['zone']?>"><?=$value['time']?></option>
                            <?php }}?>
                        </select>
                    </div>
                    <div class="checkbox">
                        <div class="pure-checkbox grey mr15 mb15">
                            <input type="checkbox" id="md_checkbox_schedule" name="remember" class="filled-in chk-col-red enable_instagram_schedule" value="on">
                            <label class="p0 m0" for="md_checkbox_schedule">&nbsp;</label>
                            <span class="checkbox-text-right"> <a href="<?=PATH."p/terms_and_policies"?>"><?=lang('i_agree_to_terms_policies')?></a></span>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block"> <?=lang('get_started')?></button>
                </div>
                </form>     
            </div>
        </div>
    </div>

    <script type="text/javascript" src="<?=BASE?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?=BASE?>assets/plugins/izitoast/js/iziToast.min.js"></script>
    <script type="text/javascript" src="<?=BASE?>assets/js/landing-page.js"></script>
    <script type="text/javascript" src="<?=BASE?>assets/js/main.js"></script>
    <?=htmlspecialchars_decode(get_option('embed_javascript', ''), ENT_QUOTES)?>
</body>
</html>

