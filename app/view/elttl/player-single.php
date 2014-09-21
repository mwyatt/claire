<?php require_once($this->pathView('_header')) ?>

<div class="page player-single js-page-player-single">
	<h1 class="page-primary-title"><?php echo $player->getNameFull() ?></h1>
	<div class="block-margins">
		<h2 class="player-single-secondary-title">General information</h2>
		<table class="elttl-table is-general">
			<tr class="elttl-table-row">
				<th class="elttl-table-cell elttl-table-heading">Team</th>
				<td class="elttl-table-cell">
					<a href="<?php echo $this->buildArchiveUrl(array('team', $team->getName())) ?>"><?php echo $team->getName() ?></a>
				</td>
			</tr>
			<tr class="elttl-table-row">
				<th class="elttl-table-cell elttl-table-heading">Rank</th>
				<td class="elttl-table-cell"><?php echo $player->getRank() ?></td>
			</tr>

<?php if ($player->getPhoneLandline()): ?>

			<tr class="elttl-table-row">
				<th class="elttl-table-cell elttl-table-heading">Landline</th>
				<td class="elttl-table-cell"><?php echo $player->getPhoneLandline() ?></td>
			</tr>

<?php endif ?>
<?php if ($player->getPhoneMobile()): ?>

			<tr class="elttl-table-row">
				<th class="elttl-table-cell elttl-table-heading">Mobile</th>
				<td class="elttl-table-cell"><?php echo $player->getPhoneMobile() ?></td>
			</tr>

<?php endif ?>

		</table>
	</div>

<?php if ($fixtures && $fixtureResults && $teams): ?>

	<div class="block-margins">
		<h2 class="player-single-secondary-title">Fixtures</h2>

<?php include($this->pathView('_fixtures')) ?>

	</div>

<?php endif ?>
<?php if ($encounters): ?>

	<div class="block-margins">
		<h2 class="player-single-secondary-title">Performance</h2>
		<table class="elttl-table is-encounter">

	<?php include($this->pathView('_encounters')) ?>

		</table>
	</div>

<?php endif ?>

</div>

<?php require_once($this->pathView('_footer')) ?>
