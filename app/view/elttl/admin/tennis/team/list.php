<?php require_once($this->pathView('admin/_header')) ?>

<div class="page tennis-team-list js-tennis-team-list">
	<span class="button-primary table-crud-button-create js-grid-button-create">Create</span>
	<h1 class="page-heading-first">Teams</h1>
	<table class="table-crud js-table-crud" width="100%">
		<tr class="js-grid-table-headings">
			<th class="table-crud-heading">Name</th>
			<th class="table-crud-heading">Home Weekday</th>
			<th class="table-crud-heading">Secretary</th>
			<th class="table-crud-heading">Venue</th>
			<th class="table-crud-heading">Division</th>
			<th class="table-crud-heading"></th>
		</tr>
		<tr class="js-grid-create-target"></tr>

<?php if ($teams): ?>
	<?php foreach ($teams as $team): ?>

		<tr class="table-crud-row js-table-crud-row">
			<td class="table-crud-cell js-table-crud-cell">
				<input class="table-crud-input js-grid-cell" name="id" type="hidden" value="<?php echo $team->getId() ?>">
				<input class="table-crud-input js-grid-cell" name="name" type="text" value="<?php echo $team->getName() ?>">
			</td>
			<td class="table-crud-cell js-table-crud-cell">
				
		<?php if ($weekdays): ?>

				<select class="table-crud-select js-grid-cell" name="home_weekday">

			<?php foreach ($weekdays as $weekdayId => $weekday): ?>
				<?php $isSelected = $team->getHomeWeekday() == $weekdayId ?>
				
					<option value="<?php echo $weekdayId ?>" <?php echo $isSelected ? 'selected="selected"' : '' ?>><?php echo $weekday ?></option>

			<?php endforeach ?>

				</select>

		<?php endif ?>

			</td>
			<td class="table-crud-cell js-table-crud-cell">
				
		<?php if ($players): ?>

				<select class="table-crud-select js-grid-cell" name="secretary_id">

			<?php foreach ($players as $player): ?>
				<?php $isSelected = $player->getId() == $team->getSecretaryId() ?>
				
					<option value="<?php echo $player->getId() ?>" <?php echo $isSelected ? 'selected="selected"' : '' ?>><?php echo $player->getNameFull() ?></option>

			<?php endforeach ?>

				</select>

		<?php endif ?>

			</td>
			<td class="table-crud-cell js-table-crud-cell">
				
		<?php if ($venues): ?>

				<select class="table-crud-select js-grid-cell" name="venue_id">

			<?php foreach ($venues as $venue): ?>
				<?php $isSelected = $venue->getId() == $team->getVenueId() ?>
				
					<option value="<?php echo $venue->getId() ?>" <?php echo $isSelected ? 'selected="selected"' : '' ?>><?php echo $venue->getName() ?></option>

			<?php endforeach ?>

				</select>

		<?php endif ?>

			</td>
			<td class="table-crud-cell js-table-crud-cell">
				
		<?php if ($divisions): ?>

				<select class="table-crud-select js-grid-cell" name="division_id">

			<?php foreach ($divisions as $division): ?>
				<?php $isSelected = $division->getId() == $team->getDivisionId() ?>
				
					<option value="<?php echo $division->getId() ?>" <?php echo $isSelected ? 'selected="selected"' : '' ?>><?php echo $division->getName() ?></option>

			<?php endforeach ?>

				</select>

		<?php endif ?>

			</td>
			<td>
				<span class="table-crud-button-delete js-grid-button-delete">Delete</span>
				<span class="button-primary table-crud-button-save js-grid-button-save">Save</span>
			</td>
		</tr>

	<?php endforeach ?>
<?php endif ?>
		
	</table>
</div>

<?php require_once($this->pathView('admin/_footer')) ?>
