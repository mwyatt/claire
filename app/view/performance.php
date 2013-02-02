<?php require_once($this->pathView() . 'header.php'); ?>

<div class="content performance">
	
	<h1>Player Performance</h1>

	<?php if ($ttEncounterPart->getData()) : ?>	

	<table width="100%" cellspacing="0" cellpadding="0">

		<tr>
			<th class="player_name">Name</th>
			<th class="team_name">Team</th>
			<th class="player_rank_change">Performance</th>
		</tr>

		<?php while ($ttEncounterPart->nextRow()) : ?>

		<tr>
			<td class="player_name">
				<a href="<?php echo $ttEncounterPart->getRow('player_guid'); ?>" title="View Player <?php echo $ttEncounterPart->getRow('player_name'); ?>"><?php echo $ttEncounterPart->getRow('player_name'); ?></a>
			</td>
			<td class="team_name">
				<a href="<?php echo $ttEncounterPart->getRow('team_guid'); ?>" title="View Team <?php echo $ttEncounterPart->getRow('team_name'); ?>"><?php echo $ttEncounterPart->getRow('team_name'); ?></a>
			</td>
			<td class="player_rank_change"><?php echo $ttEncounterPart->getRow('player_rank_change'); ?></td>
		</tr>		

		<?php endwhile; ?>

	</table>
	
	<?php endif; ?>	

</div> <!-- styling aid -->

<?php require_once($this->pathView() . 'footer.php'); ?>