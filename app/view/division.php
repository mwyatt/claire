<?php require_once($this->pathView() . 'header.php'); ?>

<div class="content division overview" data-division-id="<?php echo $this->get('division', 'id') ?>">
	<h1><?php echo ucfirst($this->get('division', 'name')) ?> division overview</h1>

<?php if ($this->get('player') || $this->get('team')): ?>
	
	<a href="merit/" class="button">Merit Table</a>
	<a href="league/" class="button">League Table</a>

	<?php if ($this->get('player')) : ?>
	
	<h2>Top 3 players</h2>
	<table class="main" width="100%" cellspacing="0" cellpadding="0">
		<thead>
			<tr>
				<th class="full-name text-left">Name</th>
				<th class="average">Average</th>
			</tr>
		</thead>
		<tbody>
			
		<?php foreach ($this->get('player') as $player): ?>

		<tr>
			<td class="full-name">
				<a href="<?php echo $this->get($player, 'guid'); ?>" title="View player <?php echo $this->get($player, 'full_name'); ?>"><?php echo $this->get($player, 'full_name'); ?></a>
			</td>
			<td class="average text-right"><?php echo $this->get($player, 'average'); ?></td>
		</tr>		

		<?php endforeach ?>

		</tbody>			
	</table>
	
	<?php endif; ?>	

	<?php if ($this->get('team')) : ?>
	
	<h2>Top 3 teams</h2>
	<table class="main" width="100%" cellspacing="0" cellpadding="0">
		<thead>
			<tr>
				<th class="name text-left">Name</th>
				<th class="points">Points</th>
			</tr>
		</thead>
		<tbody>
			
		<?php foreach ($this->get('team') as $team): ?>

		<tr>
			<td class="name">
				<a href="<?php echo $this->get($team, 'guid'); ?>" title="View team <?php echo $this->get($team, 'name'); ?>"><?php echo $this->get($team, 'name'); ?></a>
			</td>
			<td class="points text-right"><?php echo $this->get($team, 'points'); ?></td>
		</tr>		

		<?php endforeach ?>

		</tbody>			
	</table>
	
	<?php endif; ?>
<?php else: ?>
	
	<div class="nothing-yet">
		<p>No scorecards have been submitted yet.</p>
	</div>

<?php endif ?>

	

</div>

<?php require_once($this->pathView() . 'footer.php'); ?>
