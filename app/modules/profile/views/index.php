<div class="wrap-content container tab-list profile-page">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <form action="<?=cn("profile/ajax_update_account")?>" class="actionForm">
                <div class="card-header">
                    <div class="card-title">
                        <i class="ft-user" aria-hidden="true"></i> <?=lang("my_account")?>
                    </div>
                </div>
                <div class="card-block p0">
                    <div class="tab-content p15 report-content">
                        <div id="profile" class="tab-pane fade in active">
                            <div class="form-group">
                                <label for="fullname"><?=lang("fullname")?></label>
                                <input type="text" class="form-control" name="fullname" id="fullname" value="<?=!empty($account)?$account->fullname:""?>">
                            </div>
                            <div class="form-group">
                                <label for="email"><?=lang("email")?></label>
                                <input type="text" class="form-control" name="email" id="email" value="<?=!empty($account)?$account->email:""?>">
                            </div>
                            <div class="form-group">
                                <label for="email"><?=lang("timezone")?></label>
                                <select  class="form-control" name="timezone" id="timezone" >
                                    <?php if(!empty(tz_list())){
                                    foreach (tz_list() as $value) {
                                    ?>
                                    <option value="<?=$value['zone']?>" <?=(!empty($account) && $value['zone'] == $account->timezone)?"selected":""?> ><?=$value['time']?></option>
                                    <?php }}?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary"> <?=lang("Update")?></button>
                </div>
                </form>
            </div>

            <div class="card">
                <form action="<?=cn("profile/ajax_change_password")?>" class="actionForm">
                <div class="card-header">
                    <div class="card-title">
                        <i class="ft-lock" aria-hidden="true"></i> <?=lang("change_password")?>
                    </div>
                </div>
                <div class="card-block p0">
                    <div class="tab-content p15 report-content">
                        <div id="profile" class="tab-pane fade in active">
                            <div class="form-group">
                                <label for="password"><?=lang("password")?></label>
                                <input type="password" class="form-control" name="password" id="password">
                            </div>
                            <div class="form-group">
                                <label for="confirm_password"><?=lang("confirm_password")?></label>
                                <input type="password" class="form-control" name="confirm_password" id="confirm_password">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary"> <?=lang("Update")?></button>
                </div>
                </form>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card profile-package">
                <div class="card-header">
                    <div class="card-title">
                        <i class="ft-package" aria-hidden="true"></i> <?=lang("package")?>
                    </div>
                </div>
                <div class="card-block p0">
                    <div class="tab-content report-content">
                        <div id="profile" class="tab-pane fade in active">
                            <ul class="list-group">
                              <li class="list-group-item"><span class="name"><?=lang("your_package")?></span> <span class="pull-right"><?=(!empty($account) && $account->package_name != "")?$account->package_name:"None"?></span></li>
                              <li class="list-group-item"><span class="name"><?=lang("expire_date")?></span> <span class="pull-right"><?=(!empty($account) && $account->package_name != "")?convert_date($account->expiration_date):"None"?></span></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php if(get_payment()){?>
                <div class="card-footer">
                    <a href="<?=cn("pricing")?>" class="btn btn-primary"> <?=lang("renew_account")?></a>
                </div>
                <?php }?>
            </div>
        </div>
    </div>
</div>