<div class="wrap-content container schedules">
	<div class="monthly" id="mycalendar"></div>
</div>

<script type="text/javascript">
	$(function(){
		$('#mycalendar').monthly({
			mode: 'event',
  			xmlUrl: '<?=PATH?>schedules/xml',

		});
	});
</script>