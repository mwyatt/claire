<?php include $this->getTemplatePath('_header') ?>

<div class="page home js-page-home">

<?php if (isset($projects)): ?>

	<div class="panel projects">

	<?php foreach ($projects as $project): ?>

		<a href="<?php echo $project->getMetaKey('url') ?>" class="project is-<?php echo $project->getSlug() ?>" target="_blank">
			<span class="project-logo">
				<img class="project-logo-image" src="<?php echo $this->getUrlAsset('project/' . $project->getSlug() . '.svg') ?>" onerror="this.src=''; this.onerror=null;">
			</span>
			<span class="project-description">
				<span class="project-title"><?php echo $project->getTitle() ?></span>
				<span class="project-button-primary">Goto Project</span>
			</span>
		</a>

	<?php endforeach ?>

	</div>

<?php endif ?>

</div>

<?php include $this->getTemplatePath('_footer') ?>
