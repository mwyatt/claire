<?php include $this->getTemplatePath('_header') ?>

<div class="page home js-page-home">

<?php if (isset($projects)): ?>

	<div class="panel projects">

	<?php foreach ($projects as $project): ?>

		<a href="<?php echo $this->getUrl() ?>project/<?php echo $project->getSlug() ?>/" class="project is-<?php echo $project->getSlug() ?>">
			<span class="project-name"><?php echo $project->getName() ?></span>
			<span class="project-logo"><?php echo $project->getLogo() ?></span>
			<span class="project-description-short"><?php echo $project->getDescriptionShort() ?></span>
		</a>

	<?php endforeach ?>

	</div>

<?php endif ?>

</div>

<?php include $this->getTemplatePath('_footer') ?>
