<div class="wrap-content">
	<form action="<?=cn($module."/ajax_update")?>" data-redirect="<?=cn($module)?>" class="actionForm" method="POST">
	<input type="hidden" name="ids" value="<?=!empty($result)?$result->ids:""?>">

	<div class="row">
		<div class="col-md-12">
			<div class="users">
			  	<div class="card">
			  		<div class="card-header">
			  			<div class="card-title">
	                        <i class="<?=$module_icon?>" aria-hidden="true"></i> <?=$module_name?>
	                    </div>
	                    <div class="clearfix"></div>
			  		</div>
			  		<div class="card-body pl15 pr15">
			  			<div class="row">
			  				<div class="col-md-3">
                                <div class="form-group">
                                    <label for="name"><?=lang("name")?></label>
                                    <input type="text" class="form-control" name="name" id="name" value="<?=!empty($result)?$result->name:""?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="code">Code</label>
                                    <input type="text" class="form-control" name="code" id="code" value="<?=!empty($result)?$result->code:""?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group select-language">
                                    <label for="price_default_month">Icon</label>
                                    <select class="form-control selectpicker" name="icon">
                                        <?php $fileList = glob(APPPATH.'../assets/plugins/flags/flags/4x3/*');
                                        foreach($fileList as $filename){
                                            $directory_list = explode("/", $filename);
                                            $filename = end($directory_list);
                                            $ext = explode(".", $filename);
                                            if(count($ext) == 2 && $ext[1] == "svg"){
                                                echo $result->icon. " == flag-icon flag-icon-<?=$ext[0]?>";
                                        ?>
                                                <option class="flag-icon flag-icon-<?=$ext[0]?>" <?=(!empty($result) && $result->icon == "flag-icon flag-icon-".$ext[0])?"selected":""?> value="flag-icon flag-icon-<?=$ext[0]?>"><?=$ext[0]?></option>
                                        <?php
                                            }
                                            
                                        }?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="name"><?=lang("default")?></label>
                                    <select class="form-control" name="is_default">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                            </div>
			  			</div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="lead"><?=lang('list_text')?></div>
                            </div>

                            <table class="table table-bordered table-datatable mb0" style="border-top: 1px solid #e5e5e5" width="100%">
                                <thead>
                                    <tr>
                                        <th>
                                            <a href="javascript:void(0);">
                                                <span class="text"><?=lang('slug')?></span>
                                            </a>
                                        </th>
                                        <th>
                                            <a href="javascript:void(0);">
                                                <span class="text"><?=lang('Text')?></span>
                                            </a>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if(!empty($default_language)){
                                foreach ($default_language as $key => $value) {
                                ?>
                                    <tr>
                                        <td style="width: 50%;"><?=(strlen($value->slug) < 40)?$value->slug:substr($value->slug, 0, 40).'...';?></td>
                                        <td style="width: 50%;">
                                            <?php if(strlen($value->text) < 100){?>
                                            <input type="text" class="form-control" name="lang[<?=$value->slug?>]" value="<?=(isset($language[$value->slug]))?$language[$value->slug]:$value->text?>">
                                            <?php }else{ ?>
                                            <textarea name="lang[<?=$value->slug?>]" rows="3" class="form-control"><?=(isset($language[$value->slug]))?$language[$value->slug]:trim(preg_replace('/\s+/', ' ', $value->text))?></textarea>
                                            <?php }?>   
                                        </td>
                                    </tr>
                                <?php }}?>
                                </tbody>
                            </table>
                        </div>
			  		</div>
			  		<div class="card-footer">
	  					<a href="<?=cn($module)?>" class="btn btn-default"><?=lang('cancel')?></a>
	                    <button type="submit" class="btn btn-primary pull-right"><?=lang('update')?></button>
	                    <div class="clearfix"></div>
			  		</div>
			  	</div>
			</div>
		</div>
	</div>
	</form>
</div>