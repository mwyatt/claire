<?php require_once($this->pathView() . 'header.php'); ?>

<div class="content team single" data-id="<?php echo $this->get('model_ttteam', 'id'); ?>">
	<h1><?php echo $this->get('model_ttteam', 'name'); ?></h1>
	<div class="general-stats">
		<h2>General stats</h2>
		<table class="main" width="100%" cellspacing="0" cellpadding="0">
			<tr class="home-night">
				<th>Home Night</th>
				<td><?php echo $this->get('model_ttteam', 'home_night'); ?></td>
			</tr>			
			<tr class="venue">
				<th>Venue</th>
				<td><?php echo $this->get('model_ttteam', 'venue_name'); ?></td>
			</tr>		
			<tr class="division">
				<th>Division</th>
				<td><?php echo $this->get('model_ttteam', 'division_name'); ?></td>
			</tr>		
		</table>
	</div>

<?php if ($this->get('model_ttplayer')): ?>

	<div class="players clearfix">
		<h2>Registered players</h2>
		<table class="main" width="100%" cellspacing="0" cellpadding="0">
			<thead>
				<tr>
					<th class="full-name text-left">Name</th>
					<th class="rank text-center">Rank</th>
					<th class="won text-center">Won</th>
					<th class="played text-center">Played</th>
					<th class="average">Average</th>
				</tr>
			</thead>
			<tbody>
			
	<?php foreach ($this->get('model_ttplayer') as $player): ?>

			<tr>
				<td class="full-name">
					<a href="<?php echo $this->get($player, 'guid'); ?>" title="View player <?php echo $this->get($player, 'full_name'); ?>"><?php echo $this->get($player, 'full_name'); ?></a>
				</td>
				<td class="won text-center"><?php echo $this->get($player, 'won'); ?></td>
				<td class="played text-center"><?php echo $this->get($player, 'played'); ?></td>
				<td class="average text-right"><?php echo $this->displayAverage($player['average']); ?></td>
			</tr>		

	<?php endforeach ?>

			</tbody>			
		</table>
	</div>

<?php endif ?>

</div>

<?php require_once($this->pathView() . 'footer.php'); ?>