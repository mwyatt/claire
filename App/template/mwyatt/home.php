<?php include($this->getTemplatePath('_header')) ?>

<div class="content home">

<?php if ($projects): ?>

<!-- 	<h2 class="heading-home">Recent Projects</h2>
	<p class="heading-summary">Projects that I have had the pleasure to work on recently.</p>
 -->	<div class="panel projects">

	<?php foreach ($projects as $project): ?>

		<a href="<?php echo $this->getUrl() ?>project/<?php echo $project->slug ?>/" class="project is-<?php echo $project->logo ?>">
			<span class="project-name"><?php echo $project->name ?></span>
			<span class="project-logo"><?php include($this->getPathMedia('project/' . $project->logo . '.svg')) ?></span>
			<span class="project-skills"><?php //echo $project->skills ?></span>
			<span class="project-description"><?php echo $project->description ?></span>
			<span class="project-display"><?php echo $project->display ?></span>
		</a>

	<?php endforeach ?>

	</div>

<?php endif ?>

	<h2 class="heading-home">Me</h2>
	<div class="panel about-me">
		<p>I'm a talented, eager Web Design and Development professional. On a daily basis I work with a variety of technologies. Please see some of the most current websites I have had the pleasure to work on. Also review the skills I have acquired over the past 4 years of work.</p>
	</div>

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

<?php include($this->getTemplatePath('_footer')) ?>
