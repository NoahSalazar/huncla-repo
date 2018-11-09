<div class="lead"> <?=lang("general")?></div>
<div class="row">
	<div class="col-md-12">
        <div class="form-group">
            <span class="text"> <?=lang("verification_code_direct_on_website")?></span> <br/>
            <div class="pure-checkbox grey mr15 mb15">
                <input type="radio" id="md_checkbox_instagram_verification_code_enable" name="instagram_verify_code_enable" class="filled-in chk-col-red" <?=get_option('instagram_verify_code_enable', 1)==1?"checked":""?> value="1">
                <label class="p0 m0" for="md_checkbox_instagram_verification_code_enable">&nbsp;</label>
                <span class="checkbox-text-right"> <?=lang('enable')?></span>
            </div>
            <div class="pure-checkbox grey mr15 mb15">
                <input type="radio" id="md_checkbox_instagram_verification_code_disable" name="instagram_verify_code_enable" class="filled-in chk-col-red" <?=get_option('instagram_verify_code_enable', 1)==0?"checked":""?> value="0">
                <label class="p0 m0" for="md_checkbox_instagram_verification_code_disable">&nbsp;</label>
                <span class="checkbox-text-right"> <?=lang('disable')?></span>
            </div>
        </div>
	</div>
</div>