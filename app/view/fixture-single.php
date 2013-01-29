<?php require_once($this->pathView() . 'header.php'); ?>

<?php $fixture = $ttFixture->get(0); ?>

<div class="content fixture single">
	
	<h1><?php echo $fixture['team_left_name'] . ' vs ' . $fixture['team_right_name']; ?></h1>

	<span>Fulfilled on: <?php echo date('d/m/Y', $fixture['date_fulfilled']); ?></span>

	<?php if ($ttFixture->getData()) : ?>

		<table width="100%" cellspacing="0" cellpadding="0">

		<?php while ($ttFixture->nextRow()) : ?>

			<tr<?php echo ($ttFixture->getRow('status') ? ' class="' . $ttFixture->getRow('status') . '"' : ''); ?>>
				<td>
					<?php if ($ttFixture->getRow('status') == 'doubles') : ?>
					Doubles
					<?php else : ?>
					<a href="<?php echo $ttFixture->getRow('player_left_guid'); ?>"><?php echo $ttFixture->getRow('player_left_full_name'); ?></a>
					<?php endif; ?>	
				</td>
				<td><?php echo $ttFixture->getRow('player_left_score'); ?></td>
				<td><?php echo $ttFixture->getRow('player_right_score'); ?></td>
				<td><a href="<?php echo $ttFixture->getRow('player_right_guid'); ?>"><?php echo $ttFixture->getRow('player_right_full_name'); ?></a></td>
			</tr>

		<?php endwhile; ?>

			<tr class="total">
				<th>Total</th>
				<td><?php echo $fixture['team_left_score']; ?></td>
				<td><?php echo $fixture['team_right_score']; ?></td>
				<td></td>
			</tr>
		</table>
	
	<?php endif; ?>	

</div> <!-- styling aid -->

<?php require_once($this->pathView() . 'footer.php'); ?>