<?php require_once($this->pathView() . 'header.php'); ?>

<div class="content team single">

	<ul>
		<li>add in link to league table</li>
	</ul>
	
	<div class="bread"><< Back to Here</div>

	<h1><?php echo $ttTeam->get('name'); ?></h1>

	<table width="100%" cellspacing="0" cellpadding="0">
		<tr class="home-night">
			<th>Home Night</th>
			<td><?php echo $ttTeam->get('home_night'); ?></td>
		</tr>		
		<tr class="venue">
			<th>Venue</th>
			<td><?php echo $ttTeam->get('venue_name'); ?></td>
		</tr>		
		<tr class="player">
			<th>Players</th>
			<td>
				<a href="<?php echo $ttTeam->get('guid'); ?>" title="View Team <?php echo $ttTeam->get('name'); ?>"><?php echo $ttTeam->get('name'); ?></a>
			</td>
		</tr>		
		<tr class="division">
			<th>Division</th>
			<td><?php echo $ttTeam->get('division_name'); ?></td>
		</tr>		
		<tr>
	</table>

	<div class="accordion player" data-team-id="<?php echo $ttTeam->get('id'); ?>">
		<h2>Players <span>8</span></h2>
		<section></section>
	</div>

</div> <!-- styling aid -->

<?php require_once($this->pathView() . 'footer.php'); ?>