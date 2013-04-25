<?php require_once($this->pathView() . 'admin/header.php'); ?>
<?php $tabIndex = 0; ?>	

<div class="content fixtures fulfill clearfix">
	<h2>Submit Scorecard</h2>
	<form method="post">

<?php if ($this->get('model_ttdivision')): ?>

		<div class="row division">
			<select name="division_id">
				<option value="0">Division</option>
				 
	<?php foreach ($this->get('model_ttdivision') as $division): ?>
		
				<option value="<?php echo $this->get($division, 'id'); ?>" <?php echo ($this->get($division, 'id') == $this->get('model_ttplayer', 'division_id') ? 'selected' : false); ?>><?php echo $this->get($division, 'name'); ?></option>

	<?php endforeach ?>

			</select>
		</div>
	
<?php endif ?>

<?php foreach ($this->get('encounter_structure') as $side => $parts) : ?>
    
		<div class="<?php echo $side; ?>">
			<div class="team">
				<select name="team[<?php echo $side; ?>]">
					<option value="0"></option>
				</select>
			</div>
			<div class="player">

	<?php for ($player_row = 1; $player_row <= 3; $player_row ++) { ?>

				<div class="player-<?php echo $player_row; ?>">

		<?php echo ($side == 'left' ? '<span class="play-up">Play up</span>' : '') ?>

					<select name="player[<?php echo $side; ?>][<?php echo $player_row; ?>]" tabindex="2">
						<option value="0"></option>
					</select>

		<?php echo ($side == 'right' ? '<span class="play-up">Play up</span>' : '') ?>

				</div>

	<?php } ?>
			
			</div>
			<div class="score">

	<?php $row = 0; ?>
	<?php foreach ($parts as $part) : ?>

				<div class="score-<?php echo $part; ?>">

		<?php $name = 'encounter_' . (($part !== 'doubles') ? $row : $part) . '_' . $side; ?>

		<?php if (($side == 'left') && ($part !== 'doubles')) : ?>

					<label for="disable-<?php echo $row ?>">Excluude from merit</label>
					<input id="disable-<?php echo $row ?>" type="checkbox" name="encounter[<?php echo $row; ?>][exclude]">

		<?php endif; ?>

		<?php if ($side == 'left'): ?>

					<label for="<?php echo $name ?>" class=""><?php echo (($part !== 'doubles') ? '' : ucfirst($part)); ?></label>
	
		<?php endif ?>

					<input id="<?php echo $name ?>" name="encounter[<?php echo $row; ?>][<?php echo $side; ?>]" type="text" size="1" maxlength="1" tabindex="<?php echo $tabIndex ++; ?>">

		<?php if ($side == 'right'): ?>

					<label for="<?php echo $name ?>" class=""><?php echo (($part !== 'doubles') ? '' : ucfirst($part)); ?></label>
		
		<?php endif ?>
		
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

		<input name="form_<?php echo ($this->get('model_ttfixture') ? 'update' : 'fulfill'); ?>" type="hidden" value="true">
		<a href="#" class="submit button"><?php echo ($this->get('model_ttfixture') ? 'Save' : 'Fulfill'); ?></a>
		<input type="submit">

		<input name="form_fulfill" type="submit">
	</form>
</div>

<?php require_once($this->pathView() . 'admin/footer.php'); ?>