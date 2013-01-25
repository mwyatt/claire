<?php require_once($this->pathView() . 'header.php'); ?>

<div class="content player">
	
	<h1>All Players</h1>

	<?php if ($ttPlayer->getData()) : ?>	

	<table width="100%" cellspacing="0" cellpadding="0">

		<tr>
			<th class="full_name">Name</th>
			<th class="rank">Rank</th>
			<th class="team">Team</th>
			<th class="division">Division</th>
		</tr>

		<?php while ($ttPlayer->nextRow()) : ?>

		<tr>
			<td class="full_name">
				<a href="<?php echo $ttPlayer->getRow('guid'); ?>" title="View Player <?php echo $ttPlayer->getRow('full_name'); ?>"><?php echo $ttPlayer->getRow('full_name'); ?></a>
			</td>
			<td class="rank"><?php echo $ttPlayer->getRow('rank'); ?></td>
			<td class="team"><?php echo $ttPlayer->getRow('team_name'); ?></td>
			<td class="division"><?php echo $ttPlayer->getRow('division_name'); ?></td>
		</tr>		

		<?php endwhile; ?>

	</table>
	
	<?php endif; ?>	

</div> <!-- styling aid -->

<?php require_once($this->pathView() . 'footer.php'); ?>