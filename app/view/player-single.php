<?php require_once($this->pathView() . 'header.php'); ?>

<div class="content player single">
	
	<div class="bread"><< Back to Here</div>

	<h1><?php echo $ttPlayer->get('full_name'); ?></h1>

	<table width="100%" cellspacing="0" cellpadding="0">
		<tr class="played">
			<th>Played</th>
			<td><?php echo $ttPlayer->get('played'); ?></td>
		</tr>		
		<tr class="won">
			<th>Won</th>
			<td><?php echo $ttPlayer->get('won'); ?></td>
		</tr>		
		<tr class="lost">
			<th>Lost</th>
			<td><?php echo $ttPlayer->get('lost'); ?></td>
		</tr>		
		<tr class="average">
			<th>Average</th>
			<td><?php echo $ttPlayer->get('average'); ?></td>
		</tr>		
	</table>

	<div class="accordion progress" data-player-id="<?php echo $ttPlayer->get('id'); ?>">
		<h2>Progress <span>8</span></h2>
		<section></section>
	</div>

</div> <!-- styling aid -->

<?php require_once($this->pathView() . 'footer.php'); ?>