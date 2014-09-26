<?php if ($divisions): ?>
	
	<div class="divisions js-divisions">

	<?php foreach ($divisions as $division): ?>
		<?php require($this->pathView('_division')) ?>
	<?php endforeach ?>
		
	</div>

<?php endif ?>
