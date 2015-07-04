<?php include $this->getTemplatePath('admin/_header') ?>

<div class="page">
	<h1 class="page-primary-title">Fixtures</h1>
	<div class="page-actions">
		<a class="page-action button-primary right" href="<?php echo $urlCreate ?>" title="Create a new <?php echo ucwords($nameSingular) ?>">Fulfill Scorecard</a>
	</div>

<?php if (! empty($fixtures)): ?>
	<?php foreach ($divisions as $division): ?>

	<h2 class="h2"><?php echo $division->name ?> division</h2>
	<table class="table" width="100%">	
		<tr>
			<th>Home Team</th>
			<th>Away Team</th>
			<th>Date Fulfilled</th>
			<th>Edit</th>
		</tr>

		<?php foreach ($fixtures as $fixture): ?>
			<?php $isInDivision = $teams[$fixture->teamIdLeft]->divisionId == $division->id ?>
			<?php if ($isInDivision): ?>

		<tr>
			<td><?php echo $teams[$fixture->teamIdLeft]->name ?></td>
			<td><?php echo $teams[$fixture->teamIdRight]->name ?></td>
			<td><?php echo $fixture->timeFulfilled ? date('D jS F Y', $fixture->timeFulfilled) : ''; ?></td>
			<td>
				
				<?php if ($fixture->timeFulfilled): ?>
						
				<a href="<?php echo $this->url->generate('current_sans_query') ?>?fixture_id=<?php echo $fixture->id ?>" class="button-edit">Edit</a>

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

<?php include $this->getTemplatePath('admin/_footer') ?>
