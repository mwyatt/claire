<?php require_once($this->pathView() . 'header.php'); ?>

<div class="content team">
	
	<h1>All Teams</h1>

	<?php if ($ttTeam->getData()) : ?>	

	<table width="100%" cellspacing="0" cellpadding="0">

		<tr>
			<th class="name">Name</th>
			<th class="player">Players</th>
			<th class="home-night">Home Night</th>
			<th class="venue">Venue</th>
			<th class="division">Division</th>
		</tr>

		<?php while ($ttTeam->nextRow()) : ?>

		<tr>
			<td class="name">
				<a href="<?php echo $ttTeam->getRow('guid'); ?>" title="View Team <?php echo $ttTeam->getRow('name'); ?>"><?php echo $ttTeam->getRow('name'); ?></a>
			</td>
			<td class="player"><?php echo $ttTeam->getRow('player_count'); ?></td>
			<td class="home-night"><?php echo $ttTeam->getRow('home_night'); ?></td>
			<td class="venue"><?php echo $ttTeam->getRow('venue_name'); ?></td>
			<td class="division"><?php echo $ttTeam->getRow('division_name'); ?></td>
		</tr>		

		<?php endwhile; ?>

	</table>
	
	<?php endif; ?>	

</div> <!-- styling aid -->

<?php require_once($this->pathView() . 'footer.php'); ?>