<div class="typography">
	<p>The colour palette is as follows:</p>
</div>
<div class="color-palette-container">

<?php foreach (['primary', 'secondary 1', 'secondary 2'] as $group): ?>

	<div class="color-palette-column">
		<h3 class="color-palette-heading"><?php echo ucfirst($group) ?></h3>
		<div class="color-palette-colors">
	
	<?php foreach ([0, 1, 2, 3, 4] as $variation): ?>

			<div class="color-palette-color color-<?php echo str_replace(' ', '-', $group) ?>-<?php echo $variation ?>"><?php echo ucfirst($group) ?> <?php echo $variation ?></div>
		
	<?php endforeach ?>

		</div>
	</div>

<?php endforeach ?>

</div>
