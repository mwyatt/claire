<?php include $this->getPathTemplate('_header') ?>

<div class="page home js-page-home">
	<div class="panel">

<?php include $this->getPathTemplate('_contents') ?>

	</div>
	<div class="about-contact-container">
		<div id="about-me" class="about-contact-item">
			<h3 class="footer-profile-greeting">Hey</h3>
			<div class="typography footer-profile-description-container">
				<p class="footer-profile-description">My name is Martin. I work at <a class="link" href="http://www.avdist.co.uk/" target="_blank">AV Distribution</a> as a Web Developer. I spend my days designing and implementing web interfaces. I am very dedicated to my craft with <?php echo $timeExperience ?> years experience.</p>
				<p>I enjoy <a class="link" href="http://eastlancstt.org.uk/" target="_blank">table tennis</a> and gaming on a competitive level. Currently enjoying <a class="link" href="http://www.smashbros.com/en-uk/" target="_blank">Super Smash Bros for Wii U</a>, <a class="link" href="https://www.fallout4.com/" target="_blank">Fallout 4</a> and <a class="link" href="https://playoverwatch.com/en-us/" target="_blank">Overwatch</a>.</p>
			</div>
		</div>
		<div class="about-contact-item">
			<div class="footer-profile-avatar">
				<img class="footer-profile-avatar-image" src="<?php echo $url->generate() ?>asset/me-restaurant.jpg" alt="Martin Wyatt">
			</div>
			<h3 class="footer-profile-greeting">Get in touch</h3>
			<div class="typography">
				<p class="p">You can <a class="link" href="mailto:martin.wyatt@gmail.com">Email</a> me.</p>
			</div>
		</div>
	</div>
	
	<div id="skills" class="panel panel-padded">
		<h3 class="footer-profile-greeting">Skills</h3>
		<div class="typography">
			<p class="panel-description">Here are some of the strings to my bow:</p>
		</div>
		<div class="skills clearfix">
		
<?php foreach ($skills as $key => $skill): ?>
		
			<div class="skill-container js-skill-container">
				<div class="skill clearfix js-skill" data-key="<?php echo $key ?>">
					<div class="skill-name"><?php echo $skill->name ?></div>

	<?php if (isset($skill->children)): ?>

					<div class="skill-child-container">

		<?php foreach ($skill->children as $skillChild): ?>

						<div class="skill-child-name"><?php echo $skillChild ?></div>
			
		<?php endforeach ?>

					</div>
					
	<?php endif ?>

				</div>
			</div>

<?php endforeach ?>

		</div>
	</div>
</div>

<?php include $this->getPathTemplate('_footer') ?>
