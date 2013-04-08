<?php require_once($this->pathView() . 'header.php'); ?>

<div class="content player single">

<?php echo ($this->urlPrevious() ? '<a class="back" href="' . $this->urlPrevious() . '">Back</a>' : ''); ?>	

	<h1><?php echo $modelTtplayer->get('full_name'); ?></h1>

	<table width="100%" cellspacing="0" cellpadding="0">
		<tr class="played">
			<th>Played</th>
			<td><?php echo $modelTtplayer->get('played'); ?></td>
		</tr>		
		<tr class="won">
			<th>Won</th>
			<td><?php echo $modelTtplayer->get('won'); ?></td>
		</tr>		
		<tr class="lost">
			<th>Lost</th>
			<td><?php echo $modelTtplayer->get('lost'); ?></td>
		</tr>		
		<tr class="average">
			<th>Average</th>
			<td><?php echo $modelTtplayer->get('average'); ?></td>
		</tr>		
	</table>

	<div class="accordion progress" data-player-id="<?php echo $modelTtplayer->get('id'); ?>">
		<h2><span></span>Progress</h2>
		<section></section>
	</div>

	<ul>
		<li>results (personal results, vs martin 3-1, vs david 3-2)
			[load 10 more results button]
		</li>
		<li>venue and team</li>
	</ul>

</div> <!-- styling aid -->

<?php require_once($this->pathView() . 'footer.php'); ?>