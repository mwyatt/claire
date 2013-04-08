<?php require_once($this->pathView() . 'header.php'); ?>

<div class="content league">
	
	<h1><?php echo $modelTtdivision->get('name') ?> Divsion League</h1>

	<?php if ($modelTtteam->getData()) : ?>	

	<table width="100%" cellspacing="0" cellpadding="0">

		<tr>
			<th class="name">Name</th>
			<th class="won">Won</th>
			<th class="draw">Draw</th>
			<th class="loss">Loss</th>
			<th class="played">Played</th>
			<th class="points">Points</th>
		</tr>

		<?php while ($modelTtteam->nextRow()) : ?>

		<tr>
			<td class="name">
				<a href="<?php echo $modelTtteam->getRow('guid'); ?>" title="View <?php echo $modelTtteam->getRow('name'); ?>"><?php echo $modelTtteam->getRow('name'); ?></a>
			</td>
			<td class="won"><?php echo $modelTtteam->getRow('won'); ?></td>
			<td class="draw"><?php echo $modelTtteam->getRow('draw'); ?></td>
			<td class="loss"><?php echo $modelTtteam->getRow('lost'); ?></td>
			<td class="played"><?php echo $modelTtteam->getRow('played'); ?></td>
			<td class="points"><?php echo $modelTtteam->getRow('points'); ?></td>
		</tr>		

		<?php endwhile; ?>

	</table>
	
	<?php endif; ?>	

</div> <!-- styling aid -->

<?php require_once($this->pathView() . 'footer.php'); ?>