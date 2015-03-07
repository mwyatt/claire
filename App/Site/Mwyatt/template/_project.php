<?php if (isset($project)): ?>
	
<a href="<?php echo $this->url->generate('content/single', ['type' => $project->getType(), 'slug' => $project->getSlug()]) ?>" class="project is-<?php echo $project->getSlug() ?>">
	<span class="project-logo">
	
	<?php if ($project->getMetaKey('logo')): ?>
		<?php include $this->getAssetPath($project->getMetaKey('logo')) ?>
	<?php endif ?>

	</span>
	<span class="project-description">
		<span class="project-title"><?php echo $project->getTitle() ?></span>
		<span class="project-button-primary">More</span>
	</span>
</a>

<?php endif ?>
