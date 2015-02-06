<?php if (isset($project)): ?>
	
<a href="<?php echo $project->getUrl() ?>" class="project is-<?php echo $project->getSlug() ?>">
	<span class="project-logo">
	
	<?php include $this->getAssetPath($project->getMetaKey('logo')) ?>

	</span>
	<span class="project-description">
		<span class="project-title"><?php echo $project->getTitle() ?></span>
		<span class="project-button-primary">More</span>
	</span>
</a>

<?php endif ?>
