<?php require_once($this->pathView() . 'header.php'); ?>

<div class="content merit">
	
	<h1>[division] Merit Table</h1>

	<?php if ($ttPlayer->getData()) : ?>	

	<table width="100%" cellspacing="0" cellpadding="0">

		<tr>
			<th class="full_name">Name</th>
			<th class="team">Team</th>
			<th class="rank">Rank</th>
			<th class="won">Won</th>
			<th class="played">Played</th>
			<th class="average">Average</th>
		</tr>

		<?php while ($ttPlayer->nextRow()) : ?>

		<tr>
			<td class="full_name">
				<a href="<?php echo $ttPlayer->getRow('guid'); ?>" title="View Player <?php echo $ttPlayer->getRow('full_name'); ?>"><?php echo $ttPlayer->getRow('full_name'); ?></a>
			</td>
			<td class="team"><?php echo $ttPlayer->getRow('team_name'); ?></td>
			<td class="rank"><?php echo $ttPlayer->getRow('rank'); ?></td>
			<td class="won"><?php echo $ttPlayer->getRow('won'); ?></td>
			<td class="played"><?php echo $ttPlayer->getRow('played'); ?></td>
			<td class="average"><?php echo $ttPlayer->getRow('average'); ?></td>
		</tr>		

		<?php endwhile; ?>

	</table>
	
	<?php endif; ?>	

</div> <!-- styling aid -->

<?php require_once($this->pathView() . 'footer.php'); ?>