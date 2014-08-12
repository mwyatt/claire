<?php require_once($this->pathView('admin/_header')) ?>

<div class="page tennis-fixture-list">
	<h1>Fixtures</h1>

<?php if ($fixtures) : ?>

	<div>
		<a class="button-new" href="fulfill/" title="Submit scorecard">Submit scorecard</a>
	</div>
	
	<?php foreach ($divisions as $division): ?>

	<h2><?php echo $division->getName() ?> division</h2>
	<table class="table-crud" width="100%">	
		<tr>
			<th class="table-crud-heading">Home Team</th>
			<th class="table-crud-heading">Away Team</th>
			<th class="table-crud-heading">Date Fulfilled</th>
		</tr>

		<?php foreach ($fixtures as $fixture): ?>
			<?php $isInDivision = $teams[$fixture->getTeamIdLeft()]->getDivisionId() == $division->getId() ?>
			<?php if ($isInDivision): ?>

		<tr class="table-crud-row js-table-crud-row">
			<td class="table-crud-cell js-table-crud-cell"><?php echo $teams[$fixture->getTeamIdLeft()]->getName() ?></td>
			<td class="table-crud-cell js-table-crud-cell"><?php echo $teams[$fixture->getTeamIdRight()]->getName() ?></td>
			<td class="table-crud-cell js-table-crud-cell"><?php echo $fixture->getTimeFulfilled() ?></td>
			<td class="table-crud-cell js-table-crud-cell">
				
				<?php if ($fixture->getTimeFulfilled()): ?>
						
				<a href="<?php echo $this->getUrl('current_sans_query') ?>?fixture_id=<?php echo $fixture->getId() ?>" class="button-edit" title="Edit fixture"></a>

				<?php endif ?>

			</td>
		</tr>

			<?php endif ?>
		<?php endforeach ?>

	</table>

	<?php endforeach ?>
<?php else: ?>

	<div class="message">There are no fixtures currently for this season.</div>

<?php endif ?>

</div>

<?php require_once($this->pathView('admin/_footer')) ?>
