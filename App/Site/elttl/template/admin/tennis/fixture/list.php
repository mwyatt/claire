<?php require_once($this->getTemplatePath('admin/_header')) ?>

<div class="page tennis-fixture-list">
	<h1 class="page-primary-title">Fixtures</h1>
	<div class="admin-block-controls">
		<a class="button-new" href="fulfill/" title="Fulfill scorecard">Fulfill scorecard</a>
	</div>

<?php if ($fixtures) : ?>
	<?php foreach ($divisions as $division): ?>

	<h2 class="page-heading-first"><?php echo $division->getName() ?> division</h2>
	<table class="table" width="100%">	
		<tr>
			<th>Home Team</th>
			<th>Away Team</th>
			<th>Date Fulfilled</th>
		</tr>

		<?php foreach ($fixtures as $fixture): ?>
			<?php $isInDivision = $teams[$fixture->getTeamIdLeft()]->getDivisionId() == $division->getId() ?>
			<?php if ($isInDivision): ?>

		<tr>
			<td><?php echo $teams[$fixture->getTeamIdLeft()]->getName() ?></td>
			<td><?php echo $teams[$fixture->getTeamIdRight()]->getName() ?></td>
			<td><?php echo $fixture->getTimeFulfilled() ? date('D jS F Y', $fixture->getTimeFulfilled()) : ''; ?></td>
			<td>
				
				<?php if ($fixture->getTimeFulfilled()): ?>
						
				<a href="<?php echo $this->getUrl('current_sans_query') ?>?fixture_id=<?php echo $fixture->getId() ?>" class="button-edit">Edit</a>

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

<?php require_once($this->getTemplatePath('admin/_footer')) ?>
