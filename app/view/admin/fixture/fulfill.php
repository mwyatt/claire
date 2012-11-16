<?php require_once($this->pathView() . 'admin/header.php'); ?>

<div id="content" class="fulfill">
	
	<h2>Submit Scorecard</h2>

	<?php
	// possible overview once submitted
	if ($this->getObject('Session')->get('fixture_overview')) :
	echo '<pre>';
	print_r($this->getObject('Session')->getUnset('fixture_overview'));
	echo '</pre>';
	endif;
	?>

	<?php echo $this->getFeedback(); ?>

	<?php if ($ttDivision->getData()) : ?>	

	<form class="main" method="post">

		<div class="division">

			<select name="division_id" tabindex="1">

				<option value=""></option>

				<?php while ($ttDivision->nextRow()) : ?>
			
				<option value="<?php echo $ttDivision->getRow('division_id'); ?>"><?php echo $ttDivision->getRow('division_name'); ?></option>

				<?php endwhile; ?>

			</select>

		</div>

		<?php foreach ($ttFixture->getEncounterStructure() as $side => $parts) : ?>
    
		<div class="<?php echo $side; ?>">

			<div class="team">

				<select name="team[<?php echo $side; ?>]">
					<option value="0"></option>
				</select>

			</div>

			<div class="player">

			<?php for ($player_row = 1; $player_row <= 3; $player_row ++) { ?>

				<div class="player-<?php echo $player_row; ?>">

					<img src="" title="Play Up" width="16" height="16">

					<select name="player[<?php echo $side; ?>][<?php echo $player_row; ?>]" tabindex="2">
						<option value="0"></option>
					</select>

				</div>

			<?php } ?>
			
			</div>

			<div class="score">

				<?php $row = 0; ?>

				<?php foreach ($parts as $part) : ?>


				<div class="score-<?php echo $part; ?>">

					<?php $name = 'encounter_' . (($part !== 'doubles') ? $row : $part) . '_' . $side; ?>

					<label for="<?php echo $name ?>" class=""><?php echo (($part !== 'doubles') ? 'No Player' : ucfirst($part)); ?></label>

					<input id="<?php echo $name ?>" name="encounter[<?php echo $row; ?>][<?php echo $side; ?>]" type="text" size="1" maxlength="1">

				</div>

					<?php $row ++; ?>

				<?php endforeach; ?>

			</div>

			<div class="total">
			
				<p></p>

				<input type="hidden" name="total[<?php echo $side; ?>]">

			</div>

		</div>

		<?php endforeach; ?>

		<input name="form_fixture_fulfill" type="submit">

	</form>

	<?php endif; ?>	

</div> <!-- styling aid -->

<?php require_once($this->pathView() . 'admin/footer.php'); ?>