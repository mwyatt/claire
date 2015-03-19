<?php include $this->getTemplatePath('_header') ?>

<div class="page home js-page-home">
	<div class="panel">

<?php include $this->getTemplatePath('_projects') ?>

	</div>
	<div id="about-me" class="panel">
		<h2 class="panel-heading">A Little About Me</h2>
		<div class="typography">
			<p class="panel-description">I am a dedicated Web Designer / Developer with 5 years experience. Always looking to improve my craft. In my spare time I enjoy playing competitive <a href="http://eastlancstt.org.uk/" target="_blank">ping pong</a> and gaming (hearthstone, starcraft, mario kart 8, super smash bros and diablo).</p>
		</div>
	</div>
	<div id="skills" class="panel">
		
<?php foreach ($skills as $skill): ?>
	<?php echo $skill->name ?>
<?php endforeach ?>

	</div>
</div>

<?php include $this->getTemplatePath('_footer') ?>
