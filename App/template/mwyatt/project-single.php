<?php require_once($this->getTemplatePath('_header')) ?>
<?php if ($project): ?>
		
<div class="project-single">
	<h1 class="project-single-name"><?php echo $project->name ?></h1>
	<div class="project-description typography"><?php echo $project->description ?></div>
	<div class="project-display typography"><?php echo $project->display ?></div>
	<a href="<?php echo $project->url ?>" target="_blank" title="Visit <?php echo $project->name ?> Homepage"><?php echo $project->url ?></a>
</div>

<?php endif ?>
<?php require_once($this->getTemplatePath('_footer')) ?>
