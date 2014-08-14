<?php require_once($this->pathView('admin/_header')) ?>
<?php $sides = array('left', 'right') ?>

<div class="page tennis-fixture-single js-tennis-fixture-single">
	<h2 class="page-heading"><?php echo ($fixture ? 'Update' : 'Fulfill') ?> scorecard</h2>
	<form class="main" method="post" class="fixture-single-form">

<?php if ($divisions): ?>

		<section class="fixture-single-section">
			<select id="division_id" name="division_id" class="fixture-single-select fixture-single-division">
				<option value="0"></option>
				 
	<?php foreach ($divisions as $division): ?>
		
				<option value="<?php echo $division->getId() ?>"><?php echo $division->getName() ?></option>

	<?php endforeach ?>

			</select>
		</section>

<?php endif ?>

		<section class="fixture-single-section">

<?php foreach ($sides as $side): ?>
	
			<select id="team_<?php echo $side ?>" name="team[<?php echo $side ?>]" class="fixture-single-select fixture-single-team">
				<option value="0"><?php echo ucfirst($side) ?> team</option>
			</select>

<?php endforeach ?>

		</section>
		<section class="fixture-single-section">

<?php foreach ($sides as $side): ?>

			<span class="fixture-single-button-play-up fixture-single-button-play-up-<?php echo $side ?> js-fixture-single-button-play-up">Play up</span>

	<?php foreach (array('1', '2', '3') as $playerPosition): ?>
	
			<select class="fixture-single-select fixture-single-player fixture-single-player-<?php echo $side ?>" name="player[<?php echo $side ?>][<?php echo $playerPosition ?>]" data-side="<?php echo $side ?>" data-position="<?php echo $playerPosition ?>">
				<option value="0"><?php echo ucfirst($side) ?> Player <?php echo $playerPosition ?></option>
			</select>
			
	<?php endforeach ?>
<?php endforeach ?>

		</section>

<?php if ($encounterStructure): ?>
		
		<section class="fixture-single-section">

	<?php foreach ($encounterStructure as $row => $playerPositions) : ?>

			<div class="fixture-single-score-row">
			
		<?php if (! in_array('doubles', $playerPositions)): ?>
			
				<div class="fixture-single-score-row-exclude">
					<label for="exclude_<?php echo $row ?>" class="fixture-single-score-row-exclude-label">Exclude</label>
					<input id="exclude_<?php echo $row ?>" type="checkbox" name="encounter[<?php echo $row ?>][exclude]">
				</div>

		<?php endif ?>
		<?php foreach ($sides as $side): ?>
			<?php $playerPosition = $playerPositions[$side == 'left' ? 0 : 1] ?>

				<label for="encounter_<?php echo $row ?>_<?php echo $side ?>" class="fixture-single-score-row-encounter-label fixture-single-score-row-encounter-label-<?php echo $side ?>" data-player-position="<?php echo $playerPosition ?>"></label>
				<input id="encounter_<?php echo $row ?>_<?php echo $side ?>" name="encounter[<?php echo $row ?>][<?php echo $side ?>]" type="text" size="1" maxlength="1" value="">
			
		<?php endforeach ?>

			</div>
		
	<?php endforeach ?>

		</section>

<?php endif ?>
		
		<section class="fixture-single-section">

<?php foreach ($sides as $side): ?>
	
			<span class="fixture-single-total-<?php echo $side ?>"></span>
	
<?php endforeach ?>

		</section>
		<section class="fixture-single-section">
			<span class="js-form-button-submit"><?php echo ($fixture ? 'Update' : 'Fulfill') ?></span>
		</section>
	</form>
</div>

<?php require_once($this->pathView('admin/_footer')) ?>
