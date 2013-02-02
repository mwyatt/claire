<?php require_once($this->pathView() . 'header.php'); ?>

<div class="content league">
	
	<h1><?php echo $ttDivision->get('name') ?> Divsion League</h1>

	<?php if ($ttTeam->getData()) : ?>	

	<table width="100%" cellspacing="0" cellpadding="0">

		<tr>
			<th class="name">Name</th>
			<th class="won">Won</th>
			<th class="draw">Draw</th>
			<th class="loss">Loss</th>
			<th class="played">Played</th>
			<th class="points">Points</th>
		</tr>

		<?php while ($ttTeam->nextRow()) : ?>

		<tr>
			<td class="name">
				<a href="<?php echo $ttTeam->getRow('guid'); ?>" title="View <?php echo $ttTeam->getRow('name'); ?>"><?php echo $ttTeam->getRow('name'); ?></a>
			</td>
			<td class="won"><?php echo $ttTeam->getRow('won'); ?></td>
			<td class="draw"><?php echo $ttTeam->getRow('draw'); ?></td>
			<td class="loss"><?php echo $ttTeam->getRow('simplexml_load_string(data)'); ?></td>
			<td class="played"><?php echo $ttTeam->getRow('played'); ?></td>
			<td class="points"><?php echo $ttTeam->getRow('points'); ?></td>
		</tr>		

		<?php endwhile; ?>

	</table>
	
	<?php endif; ?>	

</div> <!-- styling aid -->

<?php require_once($this->pathView() . 'footer.php'); ?>