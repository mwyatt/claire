<?php if (isset($project)): ?>
	
<a href="<?php echo $project->getMetaKey('url') ?>" class="project is-<?php echo $project->getSlug() ?>" target="_blank">
	<span class="project-logo">
	
	<?php if ($project->getMetaKey('logo')): ?>
		<?php include $this->getAssetPath($project->getMetaKey('logo')) ?>
	<?php endif ?>

	</span>
	<span class="project-description">
		<span class="project-title"><?php echo $project->getTitle() ?></span>
		<span class="project-button-primary">Visit</span>
	</span>
</a>

<?php endif ?>
