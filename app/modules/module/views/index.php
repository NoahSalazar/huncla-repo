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
		  			<?php if(!empty($result)){
		  				foreach ($result as $key => $row) {
		  			?>
		  			<div class="item <?=$key%2==0?"even":"odd"?>">
		  				<img src="<?=$row->thumbnail?>">
		  				<div class="module-info">
		  					<div class="name"><?=$row->name?></div>
		  					<div class="desc"><?=$row->description?></div>
		  					<div class="version">Version <?=$row->version?> <?php if(isset($row->author)){?> | By <a href=""><?=$row->author?></a><?php }?></div>
		  				</div>
		  				<?php if(!empty($purchases)){?>
		  					<?php 
		  					$check_purchase = false;
		  					$check_version = false;
		  					foreach ($purchases as $purchase) {?>

		  						
		  						<?php if($purchase->pid == $row->pid){?>

			  						<?php 
			  						$check_purchase = true;
			  						$script_version = $row->version;
									$current_version = $purchase->version;

									//check required php version
									$version_compare = version_compare($script_version, $current_version);
									if ($version_compare > 0) {
									    $check_version = true;
									}
									?>

			  						<?php if($check_version){?>
			  						<div class="btn-group">
					  					<a href="<?=PATH?>module/upgrade/<?=$purchase->purchase_code?>/<?=$current_version?>" data-redirect="<?=PATH?>module" class="btn btn-danger pull-right actionItem" title=""><span class="ft-arrow-up"></span> <?=lang('upgrade')?></a>
					  				</div>
					  				<?php }else{?>
					  				<div class="btn-group">
					  					<a href="javascript:void(0);" target="_blank" class="btn btn-success uc"> <?=lang('purchased')?></a>
					  				</div>
					  				<?php }?>

		  						<?php }?>
		  						
		  					<?php }?>

		  					<?php if(!$check_purchase){?>
		  					<div class="btn-group">
			  					<a href="<?=$row->link?>" target="_blank" class="btn btn-primary"> <?=lang('buy')?></a>
			  				</div>
		  					<?php }?>

		  				<?php }else{?>
		  				<div class="btn-group">
		  					<a href="<?=$row->link?>" target="_blank" class="btn btn-primary"> <?=lang('buy')?></a>
		  				</div>
		  				<?php }?>
		  				
		  			</div>
		  			<?php }}?>
		  		</div>
		  	</div>
		</div>
	</div>
</div>