<?php if (isset($projects)): ?>

<div class="panel projects">

	<?php foreach ($projects as $project): ?>
		<?php include $this->getTemplatePath('_project') ?>
	<?php endforeach ?>

</div>

<?php endif ?>