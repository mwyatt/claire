<?php require_once($this->pathView() . 'admin/header.php'); ?>

<div id="content" class="league fixtures clearfix">
	<h2>Fixtures</h2>
	<a class="new button" href="<?php echo $this->url('current_noquery'); ?>fulfill/" title="Add a new fixture">Submit Scorecard</a>

<?php if ($this->get('model_ttfixture')) : ?>
	<?php foreach ($this->get('model_ttfixture') as $fixture): ?>

<div class="fixture">
	<span class="date-fulfilled"><?php echo date('D jS F Y', $this->get($fixture, 'date_fulfilled')) ?></span>
	<a href="<?php echo $this->url('current_noquery'); ?>?edit=<?php echo $this->get($fixture, 'id'); ?>" title="Edit <?php echo $this->get($fixture, 'name'); ?>">Edit</a>
	<a href="<?php echo $this->url('current_noquery'); ?>?reset=<?php echo $this->get($fixture, 'id'); ?>" title="Reset <?php echo $this->get($fixture, 'name'); ?>">Reset</a>
	<table width="100%" cellspacing="0" cellpadding="0" data-id="<?php echo $this->get($fixture, 'id'); ?>">
		<tr>
			<th><?php echo $this->get($fixture, 'team_left_name'); ?></th>
			<th><?php echo $this->get($fixture, 'team_right_name'); ?></th>
		</tr>
		<tr>
			<td><?php echo $this->get($fixture, 'score_left'); ?></td>
			<td><?php echo $this->get($fixture, 'score_right'); ?></td>
		</tr>
	</table>
</div>

	<?php endforeach ?>
<?php endif ?>

</div>

<?php require_once($this->pathView() . 'admin/footer.php'); ?>