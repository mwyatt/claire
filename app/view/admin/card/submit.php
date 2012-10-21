<?php require_once($this->pathView() . 'admin/header.php'); ?>

<div class="fulfill">
	
	<h2>Submit Scorecard</h2>

	<?php if ($ttDivision->getData()) : ?>	

	<form class="main" method="post">

		<div class="division">

			<select name="division_id" tabindex="1">

				<option value="0"></option>

				<?php while ($ttDivision->nextRow()) : ?>
			
				<option value="<?php echo $ttDivision->getRow('division_id'); ?>"><?php echo $ttDivision->getRow('division_name'); ?></option>

				<?php endwhile; ?>

			</select>

		</div>

		<?php foreach ($ttFixture->getEncounterParts() as $side => $parts) : ?>
    
		<div class="<?php echo $side; ?>">

			<div class="team">

				<select name="team_<?php echo $side; ?>_id">
					<option value="0"></option>
				</select>

			</div>

			<div class="player">

			<?php for ($player_row = 1; $player_row <= 3; $player_row ++) { ?>

				<div class="player-<?php echo $player_row; ?>">

					<img src="" title="Play Up" width="16" height="16">

					<select name="player_<?php echo $side . '_' . $player_row; ?>_id" tabindex="2">
						<option value="0"></option>
					</select>

				</div>

			<?php } ?>
			
			</div>

			<div class="score">
				
				<?php $row = 1; ?>

				<?php foreach ($parts as $part) : ?>

				<div class="score-<?php echo $part; ?>">

					<?php $name = 'encounter_' . $row . '_' . $side; ?>

					<label for="<?php echo $name ?>" class="">No Player Registered</label>

					<input id="<?php echo $name ?>" name="<?php echo $name ?>" type="text" size="1" maxlength="1">

				</div>

					<?php $row ++; ?>

				<?php endforeach; ?>

			</div>

			<div class="total"><p></p></div>

		</div>

		<?php endforeach; ?>

		<input name="form_card_new" type="submit">

	</form>

	<?php endif; ?>	

</div> <!-- styling aid -->

<?php require_once($this->pathView() . 'admin/footer.php'); ?>