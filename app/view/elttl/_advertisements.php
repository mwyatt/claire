<div class="advertisements">

<?php foreach ($ads as $ad): ?>

	<a href="<?php echo $ad->url ?>" class="advertisement">
		<h2 class="advertisement-title"><?php echo $ad->name ?></h2>
		<p class="advertisement-description"><?php echo $ad->description ?></p>
	</a>

<?php endforeach ?>

</div>
