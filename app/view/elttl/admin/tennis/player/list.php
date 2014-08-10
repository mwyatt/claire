<?php require_once($this->pathView('admin/_header')) ?>

<div class="page tennis-player-list">
	<table>
		<tr>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Rank</th>
			<th>Phone Landline</th>
			<th>Phone Mobile</th>
			<th>ETTA license Number</th>
			<th>Team</th>
		</tr>

<?php if ($players): ?>
	<?php foreach ($players as $player): ?>

		<tr>
			<td><input type="text" value="<?php echo $player->getNameFirst() ?>"></td>
			<td><input type="text" value="<?php echo $player->getNameLast() ?>"></td>
			<td><input type="text" value="<?php echo $player->getRank() ?>"></td>
			<td><input type="text" value="<?php echo $player->getPhoneLandline() ?>"></td>
			<td><input type="text" value="<?php echo $player->getPhoneMobile() ?>"></td>
			<td><input type="text" value="<?php echo $player->getEttaLicenseNumber() ?>"></td>
			<td>
				
		<?php if ($teams): ?>

				<select name="" id="">

			<?php foreach ($teams as $team): ?>
				
					<option value="<?php echo $team->getId() ?>"><?php echo $team->getName() ?></option>

			<?php endforeach ?>

				</select>

		<?php endif ?>

			</td>

		</tr>

	<?php endforeach ?>
<?php endif ?>
		
	</table>
</div>

<?php require_once($this->pathView('admin/_footer')) ?>
