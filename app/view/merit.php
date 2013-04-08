<?php require_once($this->pathView() . 'header.php'); ?>

<div class="content merit">
	
	<h1><?php echo $modelTtdivision->get('name') ?> Divsion Merit</h1>

	<?php if ($modelTtplayer->getData()) : ?>	

	<table width="100%" cellspacing="0" cellpadding="0">

		<tr>
			<th class="full_name">Name</th>
			<th class="team">Team</th>
			<th class="rank">Rank</th>
			<th class="won">Won</th>
			<th class="played">Played</th>
			<th class="average">Average</th>
		</tr>

		<?php while ($modelTtplayer->nextRow()) : ?>

		<tr>
			<td class="full_name">
				<a href="<?php echo $modelTtplayer->getRow('guid'); ?>" title="View Player <?php echo $modelTtplayer->getRow('full_name'); ?>"><?php echo $modelTtplayer->getRow('full_name'); ?></a>
			</td>
			<td class="team"><?php echo $modelTtplayer->getRow('team_name'); ?></td>
			<td class="rank"><?php echo $modelTtplayer->getRow('rank'); ?></td>
			<td class="won"><?php echo $modelTtplayer->getRow('won'); ?></td>
			<td class="played"><?php echo $modelTtplayer->getRow('played'); ?></td>
			<td class="average"><?php echo $modelTtplayer->getRow('average'); ?></td>
		</tr>		

		<?php endwhile; ?>

	</table>
	
	<?php endif; ?>	

</div> <!-- styling aid -->

<?php require_once($this->pathView() . 'footer.php'); ?>