<?php include($this->pathView('_header')) ?>

<div class="content home">
	<h2 class="heading-home">Me</h2>
	<div class="panel about-me">
		<p>I'm a talented, eager Web Design and Development professional searching for the next step in my career. I am applying for the ‘Web Designer' position. I saw your vacancy today and would like to apply for the position of 'Web Designer' after taking some time to look into your business. On a daily basis I work with:</p>
	</div>

<?php if ($projects): ?>

	<h2 class="heading-home">Recent Projects</h2>
	<p class="heading-summary">Projects that I have had the pleasure to work on recently.</p>
	<div class="panel projects">

	<?php foreach ($projects as $project): ?>

		<div class="project is-<?php echo $project->logo ?>">
			<div class="project-name"><?php echo $project->name ?></div>
			<div class="project-logo"><?php include($this->getPathMedia('project/' . $project->logo . '.svg')) ?></div>
			<div class="project-url"><a href="<?php echo $project->url ?>" target="_blank" title="Visit <?php echo $project->name ?> Homepage"><?php echo $project->url ?></a></div>
			<div class="project-skills"><?php //echo $project->skills ?></div>
			<div class="project-description"><?php echo $project->description ?></div>
			<div class="project-display"><?php echo $project->display ?></div>
			<a href="#" class="button project-button-more" title="Find out more about this project">See More</a>
		</div>

	<?php endforeach ?>

	</div>

<?php endif ?>

	<h2 class="heading-home">Skills</h2>

<?php if ($skills): ?>

	<div class="panel skills">

	<?php foreach ($skills as $skill): ?>

		<div class="skill">

		<?php echo $skill->name ?>

		</div>

	<?php endforeach ?>

	</div>

<?php endif ?>

</div>

<?php include($this->pathView('_footer')) ?>
