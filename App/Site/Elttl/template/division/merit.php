<?php include $this->getTemplatePath('_header') ?>

<div class="page division-merit js-page-division-merit">
	<h1 class="page-primary-title"><?php echo $division->name ?> division merit table</h1>

<?php if ($meritStats) : ?>

	<p class="p dont-print">This is the merit table for the <?php echo $division->name ?> division.</p>

	<?php include($this->getTemplatePath('division/_menu-tables')) ?>
	
	<table class="elttl-table">
		<tr class="elttl-table-row elttl-table-headings">
			<th class="elttl-table-cell elttl-table-heading is-name">Name</th>
			<th class="elttl-table-cell elttl-table-heading is-team">Team</th>
			<th class="elttl-table-cell elttl-table-heading is-rank">Rank</th>
			<th class="elttl-table-cell elttl-table-heading is-won">Won</th>
			<th class="elttl-table-cell elttl-table-heading is-played">Played</th>
			<th class="elttl-table-cell elttl-table-heading is-average">Average</th>
			<th class="elttl-table-cell elttl-table-heading is-encounter">Encounters</th>
		</tr>

	<?php foreach ($meritStats as $playerId => $meritStat) : ?>
		<?php if (!empty($players[$playerId])) : ?>
			<?php $player = $players[$playerId] ?>
			<?php if (!empty($teams[$player->teamId])) : ?>
				<?php $team = $teams[$player->teamId] ?>

		<tr class="elttl-table-row">
			<td class="elttl-table-cell is-name">
				<a href="<?php echo $this->url->generate('player/single', ['yearName' => $yearSingle->name, 'playerSlug' => $player->slug]) ?>"><?php echo $player->getNameFull() ?></a>
			</td>
			<td class="elttl-table-cell is-team">
				<a href="<?php echo $this->url->generate('team/single', ['yearName' => $yearSingle->name, 'teamSlug' => $team->slug]) ?>"><?php echo $team->name ?></a>
			</td>
			<td class="elttl-table-cell is-rank"><?php echo $player->rank ?></td>
			<td class="elttl-table-cell is-won"><?php echo $meritStat->won ?></td>
			<td class="elttl-table-cell is-played"><?php echo $meritStat->played ?></td>
			<td class="elttl-table-cell is-average"><?php echo $meritStat->average ?>%</td>
			<td class="elttl-table-cell is-encounter"><?php echo $meritStat->encounter ?></td>
		</tr>

			<?php
endif ?>
		<?php
endif ?>
	<?php
endforeach ?>

	</table>

<?php else : ?>
	
	<p>No fixtures have been fulfilled yet.</p>

<?php endif ?>
<?php include $this->getTemplatePath('_footer') ?>
