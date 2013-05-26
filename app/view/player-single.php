<?php require_once($this->pathView() . 'header.php'); ?>

<div class="content player single" data-id="<?php echo $this->get('model_ttplayer', 'id'); ?>">
	<h1><?php echo $this->get('model_ttplayer', 'full_name'); ?></h1>
	<div class="general-stats">
		<h2>General</h2>
		<table class="main" width="100%" cellspacing="0" cellpadding="0">
			<tr class="played">
				<th>Played</th>
				<td><?php echo $this->get('model_ttplayer', 'played'); ?></td>
			</tr>		
			<tr class="won">
				<th>Won</th>
				<td><?php echo $this->get('model_ttplayer', 'won'); ?></td>
			</tr>		
			<tr class="lost">
				<th>Lost</th>
				<td><?php echo $this->get('model_ttplayer', 'lost'); ?></td>
			</tr>		
			<tr class="average">
				<th>Average</th>
				<td><?php echo $this->get('model_ttplayer', 'average'); ?>&#37;</td>
			</tr>		
		</table>
	</div>
</div>

<?php require_once($this->pathView() . 'footer.php'); ?>