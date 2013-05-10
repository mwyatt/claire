<?php require_once($this->pathView() . 'header.php'); ?>

<div class="content division league">
	<h1><?php echo ucfirst($this->get('division', 'name')) ?> division league</h1>
	<a href="<?php echo $this->url('back') ?>" class="button">Back to overview</a>

<?php if ($this->get('model_ttteam')) : ?>

	<table class="main" width="100%" cellspacing="0" cellpadding="0">
		<tr>
			<th class="name">Name</th>
			<th class="won">Won</th>
			<th class="draw">Draw</th>
			<th class="loss">Loss</th>
			<th class="played">Played</th>
			<th class="points">Points</th>
		</tr>

	<?php foreach ($this->get('model_ttteam') as $team): ?>

		<tr>
			<td class="name">
				<a href="<?php echo $this->get($team, 'guid'); ?>" title="View <?php echo $this->get($team, 'name'); ?>"><?php echo $this->get($team, 'name'); ?></a>
			</td>
			<td class="won"><?php echo $this->get($team, 'won'); ?></td>
			<td class="draw"><?php echo $this->get($team, 'draw'); ?></td>
			<td class="loss"><?php echo $this->get($team, 'lost'); ?></td>
			<td class="played"><?php echo $this->get($team, 'played'); ?></td>
			<td class="points"><?php echo $this->get($team, 'points'); ?></td>
		</tr>		

	<?php endforeach ?>


	</table>
	
<?php endif; ?>	

</div>

<?php require_once($this->pathView() . 'footer.php'); ?>