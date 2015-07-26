<?php if (!empty($divisions)) : ?>
	
	<div class="divisions js-divisions">

	<?php foreach ($divisions as $division) : ?>
		<?php include $this->getTemplatePath('_division') ?>
	<?php
endforeach ?>
		
	</div>

<?php endif ?>
