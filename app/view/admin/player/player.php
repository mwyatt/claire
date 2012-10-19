<?php require_once('header.php'); ?>

<div class="teams">
	
	<h2>Teams</h2>

	<?php if ($ttplayer->getResult()) : ?>	

	<table width="100%" cellspacing="0" cellpadding="0">

		<tr>
			<th>Name</th>
			<th>Players</th>
			<th>Home Night</th>
			<th>Venue</th>
		</tr>

		<?php while ($ttplayer->nextRow()) : ?>

		<tr>
			<td><?php echo $ttplayer->getRow('name'); ?></td>
		</tr>		

		<?php endwhile; ?>

	</table>
	
	<?php endif; ?>	



</div> <!-- styling aid -->

<?php require_once('footer.php'); ?>