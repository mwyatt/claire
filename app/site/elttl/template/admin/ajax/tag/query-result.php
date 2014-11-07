<?php if ($this->get('model_tag')): ?>
	<?php foreach ($this->get('model_tag') as $rowTag): ?>
		<?php include($this->getTemplatePath('_content-tag')) ?>
	<?php endforeach ?>
<?php endif ?>
