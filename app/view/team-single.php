<?php require_once($this->pathView() . 'header.php'); ?>

<div class="content team single" data-id="<?php echo $this->get('model_ttteam', 'id'); ?>">
	<h1><?php echo $this->get('model_ttteam', 'name'); ?></h1>
	<div class="general-stats">
		<h2>General stats</h2>
		<table width="100%" cellspacing="0" cellpadding="0">
			<tr class="home-night">
				<th>Home Night</th>
				<td><?php echo $this->get('model_ttteam', 'home_night'); ?></td>
			</tr>			
			<tr class="venue">
				<th>Venue</th>
				<td><?php echo $this->get('model_ttteam', 'venue_name'); ?></td>
			</tr>		
			<tr class="division">
				<th>Division</th>
				<td><?php echo $this->get('model_ttteam', 'division_name'); ?> division</td>
			</tr>		
		</table>
	</div>
	<div class="fixture clearfix">
		<h2>Fixtures</h2>
	</div>
</div>

<?php require_once($this->pathView() . 'footer.php'); ?>
