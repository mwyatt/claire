<?php if ($medias): ?>
	
	<div class="medias">

	<?php foreach ($medias as $key => $media): ?>
		<?php require($this->getTemplatePath('admin/_media')) ?>
	<?php endforeach ?>
		
	</div>

<?php endif ?>
