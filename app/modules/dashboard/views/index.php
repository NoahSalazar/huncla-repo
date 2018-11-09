<?php
$report = block_report();
$report_lists = json_decode($report->report_lists);
?>
<div class="wrap-content container tab-list box-report">
    <div class="row">
        <div class="col-md-12">
            <?php if(!empty($report_lists)){?>
            <div class="card">
                <div class="card-header p0">
                    <ul class="nav nav-tabs">
                    	<?php 
                    	if(!empty($report_lists)){
                    		foreach ($report_lists as $key => $name) {
                    	?>
                        <li class="<?=$key==0?"active":""?>"><a href="<?=cn("dashboard/report/".$name)?>" data-content="report-content" data-result="html" class="actionItem"><i class="fa fa-<?=$name?>"></i> <?=ucfirst(lang(strtolower($name)))?></a></li>
                        <?php }}?>
                    </ul>
                </div>
                <div class="card-block p0">
                    <div class="tab-content p15 report-content">
                		<?=$report->data?>
                    </div>
                </div>
            </div>
            <?php }else{?>
            <div class="ml15 mr15 bg-white dataTables_empty"></div>
            <?php }?>
        </div>
    </div>
</div>
