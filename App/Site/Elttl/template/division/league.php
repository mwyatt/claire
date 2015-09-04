<?php include $this->getTemplatePath('_header') ?>

<div class="page division-league js-page-division-league">
	<h1 class="page-primary-title"><?php echo $division->name ?> division <?php echo $tableName ?> table</h1>

<?php if ($leagueStats) : ?>
	<p class="page-primary-description">This is the <?php echo $tableName ?> table for the <?php echo $division->name ?> division.</p>

	<?php include($this->getTemplatePath('division/_menu-tables')) ?>
	
	<table class="elttl-table">
		<tr class="elttl-table-row elttl-table-headings">
			<th class="elttl-table-cell elttl-table-heading is-name">Name</th>
			<th class="elttl-table-cell elttl-table-heading is-won">Won</th>
			<th class="elttl-table-cell elttl-table-heading is-draw">Draw</th>
			<th class="elttl-table-cell elttl-table-heading is-loss">Loss</th>
			<th class="elttl-table-cell elttl-table-heading is-played">Played</th>
			<th class="elttl-table-cell elttl-table-heading is-points">Points</th>
		</tr>

	<?php foreach ($leagueStats as $teamId => $leagueStat) : ?>
		<?php if (array_key_exists($teamId, $teams)) : ?>
			<?php $team = $teams[$teamId] ?>

		<tr class="elttl-table-row">
			<td class="elttl-table-cell is-name">
				<a class="link-primary" href="<?php echo $this->url->generate('team/single', ['yearName' => $yearSingle->name, 'teamSlug' => $team->slug]) ?>"><?php echo $team->name ?></a>
			</td>
			<td class="elttl-table-cell is-won"><?php echo $leagueStat->won ?></td>
			<td class="elttl-table-cell is-draw"><?php echo $leagueStat->draw ?></td>
			<td class="elttl-table-cell is-loss"><?php echo $leagueStat->loss ?></td>
			<td class="elttl-table-cell is-played"><?php echo $leagueStat->played ?></td>
			<td class="elttl-table-cell is-points"><?php echo $leagueStat->points ?></td>
		</tr>

		<?php
endif ?>
	<?php
endforeach ?>

	</table>

<?php else : ?>
	
	<div class="blankslate">No fixtures have been fulfilled yet.</div>

<?php endif ?>
<?php include $this->getTemplatePath('_footer') ?>
