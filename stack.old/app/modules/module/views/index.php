<div class="wrap-content container module" style="max-width: 700px;">
	<div class="users app-table">
			<div class="row">
				<div class="col-md-12 mb15">
					<a href="<?=PATH?>module/popup_install" class="btn btn-success pull-right ajaxModal" title=""><span class="ft-plus-circle"></span> <?=lang('install')?></a>
					<div class="clearfix"></div>
				</div>
			</div>
		  	<div class="card">
		  		<div class="card-body">
		  			<?php if(count($result) > 0){
		  				foreach ($result as $row) {
		  			?>
		  			<div class="item <?=$key%2==0?"even":"odd"?>">
		  				<img src="<?=$row->thumbnail?>">
		  				<div class="module-info">
		  					<div class="name"><?=$row->name?></div>
		  					<div class="desc"><?=$row->description?></div>
		  					<div class="version">Version <?=$row->version?> <?php if(isset($row->author)){?> | By <a href=""><?=$row->author?></a><?php }?></div>
		  				</div>
		  				<div class="btn-group">
		  					<a href="javascript:void(0);" target="_blank" class="btn btn-success uc"> <?=lang('purchased')?></a>
		  				</div>
 				
		  			</div>
		  			<?php }}?>
		  		</div>
		  	</div>
		</div>
	</div>
</div>
