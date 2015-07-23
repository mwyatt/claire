<?php require_once($this->getTemplatePath('admin/_header')) ?>

<script>
	var pageTennisFixtureSingleResource = {
		isFilled: <?php echo json_encode($isFilled) ?>,
		sides: <?php echo json_encode($sides) ?>,
		fixture: <?php echo json_encode($fixture) ?>,
		encounters: <?php echo json_encode($encounters) ?>,
		divisions: <?php echo json_encode($divisions) ?>,
		teams: <?php echo json_encode($teams) ?>,
		encounterStructure: <?php echo json_encode($encounterStructure) ?>,
		players: <?php echo json_encode($players) ?>
	};
</script>
<div class="page tennis-fixture-single js-tennis-fixture-single">
	<h1 class="page-primary-title"><?php echo ($isFilled ? 'Update' : 'Fulfill') ?> scorecard</h1>
	<form class="main" method="post" class="fixture-single-form">
		<!-- <input name="debug" type="hidden" value="Fulfill"> -->

<?php if ($isFilled) : ?>
	
		<span class="admin-button-primary-delete js-form-button-submit js-form-button-fixture-delete">Delete Fixture</span>

<?php endif ?>
<?php if ($divisions) : ?>

		<section class="fixture-single-section">
			<select id="division_id" name="division_id" class="fixture-single-select fixture-single-division js-fixture-single-division">
				<option value="0"></option>
				 
	<?php foreach ($divisions as $division) : ?>
		
				<option value="<?php echo $division->id ?>"><?php echo $division->name ?></option>

	<?php
endforeach ?>

			</select>
		</section>

<?php endif ?>

		<section class="fixture-single-section">

<?php foreach ($sides as $side) : ?>
	
			<select id="team_<?php echo $side ?>" name="team[<?php echo $side ?>]" class="fixture-single-select fixture-single-team js-fixture-single-team" data-side="<?php echo $side ?>">
				<option value="0"><?php echo ucfirst($side) ?> team</option>
			</select>

<?php endforeach ?>

		</section>
		<section class="fixture-single-section">

<?php foreach (array('1', '2', '3') as $playerPosition) : ?>
	<?php foreach ($sides as $side) : ?>
	
			<div class="fixture-single-player-row is-<?php echo $side ?>">
				<span class="fixture-single-button-play-up fixture-single-button-play-up-<?php echo $side ?> js-fixture-single-button-play-up" data-side="<?php echo $side ?>" data-position="<?php echo $playerPosition ?>">Play up</span>
				<select class="fixture-single-select fixture-single-player js-fixture-single-player fixture-single-player-<?php echo $side ?>" name="player[<?php echo $side ?>][<?php echo $playerPosition ?>]" data-side="<?php echo $side ?>" data-position="<?php echo $playerPosition ?>">
					<option value="0"><?php echo ucfirst($side) ?> Player <?php echo $playerPosition ?></option>
				</select>
			</div>
			
	<?php
endforeach ?>
<?php endforeach ?>

		</section>

<?php if ($encounterStructure) : ?>
		
		<section class="fixture-single-section">

	<?php foreach ($encounterStructure as $row => $playerPositions) : ?>

			<div class="fixture-single-score-row js-fixture-single-score-row" data-row="<?php echo $row ?>">
			
		<?php if (! in_array('doubles', $playerPositions)) : ?>
			
				<div class="fixture-single-score-row-exclude">
					<label for="exclude_<?php echo $row ?>" class="fixture-single-score-row-exclude-label">Exclude</label>
					<input id="exclude_<?php echo $row ?>" type="checkbox" name="encounter[<?php echo $row ?>][status]" class="fixture-single-score-row-exclude-checkbox js-fixture-single-score-row-exclude-checkbox" data-row="<?php echo $row ?>" value="exclude">
				</div>

		<?php
else : ?>

				<input name="encounter[<?php echo $row ?>][status]" type="hidden" value="doubles">

		<?php
endif ?>
		<?php foreach ($sides as $side) : ?>
			<?php $playerPosition = $playerPositions[$side == 'left' ? 0 : 1] ?>

				<label for="encounter_<?php echo $row ?>_<?php echo $side ?>" class="fixture-single-score-row-encounter-label js-fixture-single-score-row-encounter-label fixture-single-score-row-encounter-label-<?php echo $side ?>" data-position="<?php echo $playerPosition ?>" data-side="<?php echo $side ?>"></label>
				<input id="encounter_<?php echo $row ?>_<?php echo $side ?>" name="encounter[<?php echo $row ?>][<?php echo $side ?>]" class="fixture-single-encounter-input js-fixture-single-encounter-input" type="text" size="1" maxlength="1" value="" data-row="<?php echo $row ?>" data-side="<?php echo $side ?>">
			
		<?php
endforeach ?>

			</div>
		
	<?php
endforeach ?>

		</section>

<?php endif ?>
		
		<section class="fixture-single-section">

<?php foreach ($sides as $side) : ?>
	
			<span class="fixture-single-total-<?php echo $side ?> js-fixture-single-total" data-side="<?php echo $side ?>"></span>
	
<?php endforeach ?>

		</section>
		<section class="fixture-single-section">
			<button class="button-primary"><?php echo ($isFilled ? 'Update' : 'Fulfill') ?></button>
		</section>
	</form>
</div>

<?php require_once($this->getTemplatePath('admin/_footer')) ?>
