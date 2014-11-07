<?php if ($media): ?>

<div class="media js-media">

	<?php foreach ($media as $medium): ?>
		<?php require($this->getTemplatePath('_medium')) ?>
	<?php endforeach ?>
	
</div>

<?php endif ?>
