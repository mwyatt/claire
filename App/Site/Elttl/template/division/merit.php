<?php include $this->getTemplatePath('_header') ?>

<div class="page division-merit js-page-division-merit">
	<h1 class="page-primary-title"><?php echo $division->getName() ?> division merit table</h1>

<?php if ($meritStats): ?>

	<p class="p dont-print">This is the merit table for the <?php echo $division->getName() ?> division.</p>

	<?php include($this->getTemplatePath('division/_menu-tables')) ?>
	
	<table class="elttl-table">
		<tr class="elttl-table-row elttl-table-headings">
			<th class="elttl-table-cell elttl-table-heading is-name">Name</th>
			<th class="elttl-table-cell elttl-table-heading is-team">Team</th>
			<th class="elttl-table-cell elttl-table-heading is-rank">Rank</th>
			<th class="elttl-table-cell elttl-table-heading is-won">Won</th>
			<th class="elttl-table-cell elttl-table-heading is-played">Played</th>
			<th class="elttl-table-cell elttl-table-heading is-average">Average</th>
		</tr>

	<?php foreach ($meritStats as $playerId => $meritStat): ?>
		<?php if (array_key_exists($playerId, $players)): ?>
			<?php $player = $players[$playerId] ?>
			<?php $team = $teams[$player->getTeamId()] ?>

		<tr class="elttl-table-row">
			<td class="elttl-table-cell is-name">
				<a href="<?php echo $this->buildArchiveUrl(array('player', $player->getNameFull())) ?>"><?php echo $player->getNameFull() ?></a>
			</td>
			<td class="elttl-table-cell is-team">
				<a href="<?php echo $this->buildArchiveUrl(array('team', $team->getName())) ?>"><?php echo $team->getName() ?></a>
			</td>
			<td class="elttl-table-cell is-rank"><?php echo $player->getRank() ?></td>
			<td class="elttl-table-cell is-won"><?php echo $meritStat->won ?></td>
			<td class="elttl-table-cell is-played"><?php echo $meritStat->played ?></td>
			<td class="elttl-table-cell is-average"><?php echo $meritStat->average ?>%</td>
		</tr>

		<?php endif ?>
	<?php endforeach ?>

	</table>

<?php else: ?>
	
	<p>No fixtures have been fulfilled yet.</p>

<?php endif ?>
<?php include $this->getTemplatePath('_footer') ?>
