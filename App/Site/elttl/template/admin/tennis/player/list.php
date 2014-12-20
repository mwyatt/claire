<?php require_once($this->getTemplatePath('admin/_header')) ?>

<div class="page tennis-player-list js-tennis-player-list">
	<span class="button-primary js-grid-button-create table-crud-button-create">Create</span>
	<h1 class="page-heading-first">Players</h1>
	<table class="table-crud js-table-crud" width="100%">
		<tr class="js-grid-table-headings">
			<th class="table-crud-heading">First Name</th>
			<th class="table-crud-heading">Last Name</th>
			<th class="table-crud-heading">Rank</th>
			<th class="table-crud-heading">Phone Landline</th>
			<th class="table-crud-heading">Phone Mobile</th>
			<th class="table-crud-heading">ETTA license Number</th>
			<th class="table-crud-heading">Team</th>
			<th class="table-crud-heading"></th>
		</tr>
		<tr class="js-grid-create-target"></tr>

<?php if ($players): ?>
	<?php foreach ($players as $player): ?>

		<tr class="table-crud-row js-table-crud-row">
			<td class="table-crud-cell js-table-crud-cell">
				<input class="table-crud-input js-grid-cell" name="id" type="hidden" value="<?php echo $player->getId() ?>">
				<input class="table-crud-input js-grid-cell" name="name_first" type="text" value="<?php echo $player->getNameFirst() ?>">
			</td>
			<td class="table-crud-cell js-table-crud-cell">
				<input class="table-crud-input js-grid-cell" name="name_last" type="text" value="<?php echo $player->getNameLast() ?>">
			</td>
			<td class="table-crud-cell js-table-crud-cell">
				<input class="table-crud-input js-grid-cell" name="rank" type="text" value="<?php echo $player->getRank() ?>">
			</td>
			<td class="table-crud-cell js-table-crud-cell">
				<input class="table-crud-input js-grid-cell" name="phone_landline" type="text" value="<?php echo $player->getPhoneLandline() ?>">
			</td>
			<td class="table-crud-cell js-table-crud-cell">
				<input class="table-crud-input js-grid-cell" name="phone_mobile" type="text" value="<?php echo $player->getPhoneMobile() ?>">
			</td>
			<td class="table-crud-cell js-table-crud-cell">
				<input class="table-crud-input js-grid-cell" name="etta_license_number" type="number" value="<?php echo $player->getEttaLicenseNumber() ?>">
			</td>
			<td class="table-crud-cell js-table-crud-cell">
				
		<?php if ($teams): ?>

				<select class="table-crud-select js-grid-cell" name="team_id">

			<?php foreach ($teams as $team): ?>
				<?php $isSelected = $player->getTeamId() == $team->getId() ?>
				
					<option value="<?php echo $team->getId() ?>" <?php echo $isSelected ? 'selected="selected"' : '' ?>><?php echo $team->getName() ?></option>

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

<?php require_once($this->getTemplatePath('admin/_footer')) ?>
