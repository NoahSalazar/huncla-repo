<div class="instagram_search_media">
	<div class="row">
		<?php if(!empty($result)){
			foreach ($result->items as $row) {
				switch ($row->media_type) {
					case 8:
						$media = array();
						foreach ($row->carousel_media as $value) {
							$media_temp = explode("?", $value->image_versions2->candidates[0]->url);
							$media[] = $media_temp[0];
						}
						$bg = $row->carousel_media[0]->image_versions2->candidates[0]->url;
						$type = "Carousel";
						break;

					case 2:
						$media_temp = explode("?", $row->video_versions[0]->url);
						$media = array($media_temp[0]);
						$bg = $row->image_versions2->candidates[0]->url;
						$type = "Video";
						break;

					default:
						$media_temp = explode("?", $row->image_versions2->candidates[0]->url);
						$media = array($media_temp[0]);
						$bg = $row->image_versions2->candidates[0]->url;
						$type = "Photo";
						break;
				}

				$caption = is_object($row->caption)?$row->caption->text:"";
				$media = json_encode($media);
				
		?>
		<div class="col-md-3 col-sm-4 mb15">
			<div class="item" style="background-image: url(<?=$bg?>);">
				<?php if($row->media_type == 2){?>
			        <div class="btn-play"><i class="fa fa-play" aria-hidden="true"></i></div>
			    <?php }?>
			    <div class="type"><?=$type?></div>
				<img class="fake-bg popoverCaption" data-content="<?=$caption?>" data-delay-show="300" data-title="Caption" src="<?=BASE?>assets/img/transparent.png">
				<div class="list-option btn-group bg-white" role="group">
					<div class="col-md-4 col-sm-4 col-xs-4 btn btn-default btn-sm btnGetInstagramMedia" data-media='<?=$media?>' data-caption="<?=$caption?>" data-type='photo'>Post</div>
					<div class="col-md-4 col-sm-4 col-xs-4 btn btn-default btn-sm btnGetInstagramMedia" data-media='<?=$media?>' data-caption="<?=$caption?>" data-type='story'>Story</div>
					<div class="col-md-4 col-sm-4 col-xs-4 btn btn-default btn-sm btnGetInstagramMedia" data-media='<?=$media?>' data-caption="<?=$caption?>" data-type='carousel'>Carousel</div>
				</div>
			</div>
		</div>
		<?php }}?>
	</div>
</div>

<script type="text/javascript">
	$('.popoverCaption').webuiPopover({content: 'Content' , width: 300, trigger: 'click'});
</script>