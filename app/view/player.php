<?php require_once($this->pathView() . 'header.php'); ?>

<div class="content player">
	
	<h1>All Players</h1>

	<?php if ($modelTtplayer->getData()) : ?>	

	<table width="100%" cellspacing="0" cellpadding="0">

		<tr>
			<th class="full_name">Name</th>
			<th class="rank">Rank</th>
			<th class="team">Team</th>
			<th class="division">Division</th>
		</tr>

		<?php while ($modelTtplayer->nextRow()) : ?>

		<tr>
			<td class="full_name">
				<a href="<?php echo $modelTtplayer->getRow('guid'); ?>" title="View Player <?php echo $modelTtplayer->getRow('full_name'); ?>"><?php echo $modelTtplayer->getRow('full_name'); ?></a>
			</td>
			<td class="rank"><?php echo $modelTtplayer->getRow('rank'); ?></td>
			<td class="team"><?php echo $modelTtplayer->getRow('team_name'); ?></td>
			<td class="division"><?php echo $modelTtplayer->getRow('division_name'); ?></td>
		</tr>		

		<?php endwhile; ?>

	</table>
	
	<?php endif; ?>	

</div> <!-- styling aid -->

<?php require_once($this->pathView() . 'footer.php'); ?>