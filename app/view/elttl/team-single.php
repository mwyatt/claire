<?php require_once($this->pathView('_header')) ?>

<div class="page team-single js-page-team-single">
	<h1 class="page-primary-title"><?php echo $team->getName() ?></h1>
	<div class="block-margins">
		<h2 class="team-single-secondary-title">General information</h2>
		<table class="elttl-table is-general">
			<tr class="elttl-table-row">
				<th class="elttl-table-cell elttl-table-heading">Division</th>
				<td class="elttl-table-cell"><?php echo $division->getName() ?></td>
			</tr>
			<tr class="elttl-table-row">
				<th class="elttl-table-cell elttl-table-heading">Home night</th>
				<td class="elttl-table-cell"><?php echo $team->getHomeWeekdayName() ?></td>
			</tr>
			<tr class="elttl-table-row">
				<th class="elttl-table-cell elttl-table-heading">Venue</th>
				<td class="elttl-table-cell"><?php echo $venue->getName() ?></td>
			</tr>

<?php if ($secretary): ?>
	
			<tr class="elttl-table-row">
				<th class="elttl-table-cell elttl-table-heading">Secretary</th>
				<td class="elttl-table-cell">
					<div class="team-single-secretary">
						<a class="team-single-secretary-name" href="<?php echo $this->buildArchiveUrl(array('player', $secretary->getNameFull())) ?>"><?php echo $secretary->getNameFull() ?></a>
						<span class="team-single-secretary-telephone-landline"><?php echo $secretary->getPhoneLandline() ?></span>
						<span class="team-single-secretary-telephone-mobile"><?php echo $secretary->getPhoneMobile() ?></span>
					</div>
				</td>
			</tr>

<?php endif ?>

		</table>
	</div>

<?php if ($players): ?>

	<div class="block-margins">
		<h2 class="team-single-secondary-title">Registered players</h2>
		<table class="elttl-table is-general">
		
	<?php foreach ($players as $player): ?>
		
			<tr class="elttl-table-row">
				<td class="elttl-table-cell">
					<a class="player" href="<?php echo $this->buildArchiveUrl(array('player', $player->getNameFull())) ?>"><?php echo $player->getNameFull() ?></a>
				</td>
			</tr>

	<?php endforeach ?>

		</table>
	</div>

<?php endif ?>

	<div class="block-margins">
		<h2 class="team-single-secondary-title">Fixtures</h2>

<?php include($this->pathView('_fixtures')) ?>

	</div>
</div>

<?php require_once($this->pathView('_footer')) ?>
