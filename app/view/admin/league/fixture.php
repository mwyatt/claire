<?php require_once($this->pathView() . 'admin/header.php'); ?>

<div class="content league fixtures clearfix">
	<h1>Fulfilled Fixtures</h1>
	<div class="clearfix text-right row">
		<a class="new button" href="<?php echo $this->url('current_noquery'); ?>fulfill/" title="Add a new fixture">Submit Scorecard</a>
	</div>

<?php foreach ($this->get('model_ttdivision') as $division): ?>
	<h2 class="clearfix"><?php echo $this->get($division, 'name') ?> division</h2>

	<?php if ($this->get('model_ttfixture')) : ?>
		<?php foreach ($this->get('model_ttfixture') as $fixture): ?>
			<?php if ($this->get($fixture, 'division_id') == $this->get($division, 'id')): ?>

	<a href="<?php echo $this->url('current_noquery'); ?>?edit=<?php echo $this->get($fixture, 'id'); ?>" class="card clearfix" title="Edit fixture">
		<span class="date-fulfilled"><?php echo date('D jS F Y', $this->get($fixture, 'date_fulfilled')) ?></span>
		<div class="team-left"><?php echo $this->get($fixture, 'team_left_name'); ?></div>
		<div class="score-left"><?php echo $this->get($fixture, 'score_left'); ?></div>
		<div class="team-right"><?php echo $this->get($fixture, 'team_right_name'); ?></div>
		<div class="score-right"><?php echo $this->get($fixture, 'score_right'); ?></div>
	</a>


			<?php endif ?>
		<?php endforeach ?>

	<div class="clearfix"></div>

	<?php else: ?>
	
	<div class="nothing-yet">
		<p>No scorecards have been submitted yet, why not <a href="<?php echo $this->url('current_noquery'); ?>fulfill/">submit</a> one now?</p>
	</div>

	<?php endif ?>
<?php endforeach ?>

</div>

<?php require_once($this->pathView() . 'admin/footer.php'); ?>