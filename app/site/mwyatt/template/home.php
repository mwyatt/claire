<?php include $this->getTemplatePath('_header') ?>

<div class="page home js-page-home">

<?php if (isset($projects)): ?>
	
<?php endif ?>
<?php if (isset($contents)): ?>

		<div class="home-press">
			<h1 class="home-press-heading">
				<a href="<?php echo $this->getUrl() ?>press/" class="home-button-all-posts">View all</a>
				<span class="home-press-heading-text">Press releases</span>
			</h1>
		
	<?php include $this->getTemplatePath('_contents') ?>

		</div>
		
<?php endif ?>

</div>

<?php include $this->getTemplatePath('_footer') ?>
