<?php include $this->getTemplatePath('_header') ?>

<div class="page player-single js-page-player-single">
	<h1 class="page-primary-title"><?php echo $player->getNameFull() ?></h1>
	<div class="block-margins">
		<h2 class="player-single-secondary-title">General information</h2>
		<table class="elttl-table is-general">
			<tr class="elttl-table-row">
				<th class="elttl-table-cell elttl-table-heading">Team</th>
				<td class="elttl-table-cell">
					<a href="<?php echo $this->url->generate('team/single', ['yearName' => $year->name, 'teamSlug' => $team->slug]) ?>"><?php echo $team->name ?></a>
				</td>
			</tr>
			<tr class="elttl-table-row">
				<th class="elttl-table-cell elttl-table-heading">Rank</th>
				<td class="elttl-table-cell"><?php echo $player->rank ?></td>
			</tr>

<?php if ($player->phoneLandline) : ?>

			<tr class="elttl-table-row">
				<th class="elttl-table-cell elttl-table-heading">Landline</th>
				<td class="elttl-table-cell"><?php echo $player->phoneLandline ?></td>
			</tr>

<?php endif ?>
<?php if ($player->phoneMobile) : ?>

			<tr class="elttl-table-row">
				<th class="elttl-table-cell elttl-table-heading">Mobile</th>
				<td class="elttl-table-cell"><?php echo $player->phoneMobile ?></td>
			</tr>

<?php endif ?>

		</table>
	</div>

<?php if ($fixtures && $fixtureResults && $teams) : ?>

	<div class="block-margins">
		<h2 class="player-single-secondary-title">Fixtures</h2>

<?php include $this->getTemplatePath('_fixtures') ?>

	</div>

<?php endif ?>
<?php if ($encounters) : ?>

	<div class="block-margins">
		<h2 class="player-single-secondary-title">Performance</h2>
		<table class="elttl-table is-encounter">

	<?php include $this->getTemplatePath('_encounters') ?>

		</table>
	</div>

<?php endif ?>

</div>

<?php include $this->getTemplatePath('_footer') ?>
