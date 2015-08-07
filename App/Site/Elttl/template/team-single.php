<?php include $this->getTemplatePath('_header') ?>

<div class="page team-single js-page-team-single">
	<h1 class="page-primary-title"><?php echo $team->name ?></h1>
	<div class="block-margins">
		<h2 class="team-single-secondary-title">General information</h2>
		<table class="elttl-table is-general">
			<tr class="elttl-table-row">
				<th class="elttl-table-cell elttl-table-heading">Division</th>
				<td class="elttl-table-cell"><?php echo $division->name ?></td>
			</tr>
			<tr class="elttl-table-row">
				<th class="elttl-table-cell elttl-table-heading">Home night</th>
				<td class="elttl-table-cell"><?php echo $team->getHomeWeekdayName() ?></td>
			</tr>
			<tr class="elttl-table-row">
				<th class="elttl-table-cell elttl-table-heading">Venue</th>
				<td class="elttl-table-cell"><?php echo $venue->name ?></td>
			</tr>

<?php if ($secretary) : ?>
	
			<tr class="elttl-table-row">
				<th class="elttl-table-cell elttl-table-heading">Secretary</th>
				<td class="elttl-table-cell">
					<div class="team-single-secretary">
						<a class="team-single-secretary-name" href="<?php echo $this->url->generate('player/single', ['yearName' => $yearSingle->name, 'playerSlug' => $secretary->slug]) ?>"><?php echo $secretary->getNameFull() ?></a>

	<?php if ($secretary->phoneLandline) : ?>

						<span class="team-single-secretary-telephone-landline">
							<strong>Landline:</strong> <?php echo $secretary->phoneLandline ?></span>
							
	<?php
endif ?>
	<?php if ($secretary->phoneMobile) : ?>

						<span class="team-single-secretary-telephone-mobile">
							<strong>Mobile:</strong> <?php echo $secretary->phoneMobile ?></span>
							
	<?php
endif ?>

					</div>
				</td>
			</tr>

<?php endif ?>

		</table>
	</div>

<?php if ($players) : ?>

	<div class="block-margins">
		<h2 class="team-single-secondary-title">Registered players</h2>
		<table class="elttl-table is-general">
		
	<?php if (!empty($meritStats)) : ?>
		<?php foreach ($meritStats as $playerId => $meritStat) : ?>
			<?php if (!empty($players[$playerId])) : ?>
				<?php $player = $players[$playerId] ?>

			<tr class="elttl-table-row">
				<td class="elttl-table-cell is-name">
					<a href="<?php echo $this->url->generate('player/single', ['yearName' => $yearSingle->name, 'playerSlug' => $player->slug]) ?>"><?php echo $player->getNameFull() ?></a>
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
endforeach ?>
	<?php
endif ?>

		</table>
	</div>

<?php endif ?>
<?php if ($fixtures && $fixtureResults && $teams) : ?>
	
	<div class="block-margins">
		<h2 class="team-single-secondary-title">Fixtures</h2>

	<?php include $this->getTemplatePath('_fixtures') ?>

	</div>

<?php endif ?>

</div>

<?php include $this->getTemplatePath('_footer') ?>
