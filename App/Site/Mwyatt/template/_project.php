<?php if (isset($project)): ?>
	
<a href="<?php echo $project->getMetaKey('url') ?>" class="project is-<?php echo $project->getSlug() ?>" target="_blank">
	<span class="project-logo">
	
	<?php include $this->getAssetPath($project->getMetaKey('logo')) ?>

	</span>
	<span class="project-description">
		<span class="project-title"><?php echo $project->getTitle() ?></span>
		<span class="project-button-primary">Go</span>
	</span>
</a>

<?php endif ?>
