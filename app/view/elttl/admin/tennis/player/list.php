<?php require_once($this->pathView('admin/_header')) ?>

<div class="page tennis-player-list">
	<h1>Players</h1>
	<table class="table-crud" width="100%">
		<tr>
			<th class="table-crud-heading">First Name</th>
			<th class="table-crud-heading">Last Name</th>
			<th class="table-crud-heading">Rank</th>
			<th class="table-crud-heading">Phone Landline</th>
			<th class="table-crud-heading">Phone Mobile</th>
			<th class="table-crud-heading">ETTA license Number</th>
			<th class="table-crud-heading">Team</th>
			<th class="table-crud-heading"></th>
		</tr>

<?php if ($players): ?>
	<?php foreach ($players as $player): ?>

		<tr class="table-crud-row js-table-crud-row">
			<td class="table-crud-cell js-table-crud-cell">
				<input class="table-crud-input" name="name_first" type="text" value="<?php echo $player->getNameFirst() ?>">
			</td>
			<td class="table-crud-cell js-table-crud-cell">
				<input class="table-crud-input" name="name_last" type="text" value="<?php echo $player->getNameLast() ?>">
			</td>
			<td class="table-crud-cell js-table-crud-cell">
				<input class="table-crud-input" name="rank" type="text" value="<?php echo $player->getRank() ?>">
			</td>
			<td class="table-crud-cell js-table-crud-cell">
				<input class="table-crud-input" name="phone_landline" type="number" value="<?php echo $player->getPhoneLandline() ?>">
			</td>
			<td class="table-crud-cell js-table-crud-cell">
				<input class="table-crud-input" name="phone_mobile" type="number" value="<?php echo $player->getPhoneMobile() ?>">
			</td>
			<td class="table-crud-cell js-table-crud-cell">
				<input class="table-crud-input" name="etta_license_number" type="number" value="<?php echo $player->getEttaLicenseNumber() ?>">
			</td>
			<td class="table-crud-cell js-table-crud-cell">
				
		<?php if ($teams): ?>

				<select class="table-crud-select" name="team_id">

			<?php foreach ($teams as $team): ?>
				<?php $isSelected = $player->getTeamId() == $team->getId() ?>
				
					<option value="<?php echo $team->getId() ?>" <?php echo $isSelected ? 'selected="selected"' : '' ?>><?php echo $team->getName() ?></option>

			<?php endforeach ?>

				</select>

		<?php endif ?>

			</td>
			<td>
				<span class="button-primary">Save</span>
			</td>
		</tr>

	<?php endforeach ?>
<?php endif ?>
		
	</table>
</div>

<?php require_once($this->pathView('admin/_footer')) ?>
