<?php include $this->getTemplatePath('_header') ?>

<div class="page home js-page-home">
	<div class="panel">
		<!-- <h2 class="panel-heading">Work</h2> -->

<?php include $this->getTemplatePath('_projects') ?>

	</div>
	<div id="about-me" class="panel panel-padded">
		<h2 class="panel-heading">A Little About Me</h2>
		<div class="typography">
			<p class="panel-description">I am a dedicated Web Designer / Developer with 5 years experience. Always looking to improve my craft. In my spare time I enjoy playing competitive <a href="http://eastlancstt.org.uk/" target="_blank">ping pong</a> and gaming (hearthstone, starcraft, mario kart 8, super smash bros wii u).</p>
		</div>
	</div>
	<div id="skills" class="panel panel-padded">
		<h2 class="panel-heading">What I can do</h2>
		<div class="typography">
			<p class="panel-description">Here are some of the strings to my bow:</p>
		</div>

		<div class="skills">
			
		
<?php foreach ($skills as $skill): ?>
		
		<div class="skill">
			<div class="skill-name"><?php echo ucfirst($skill->name) ?></div>
		</div>

<?php endforeach ?>

		</div>
	</div>
</div>

<?php include $this->getTemplatePath('_footer') ?>
