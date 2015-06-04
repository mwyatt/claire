<?php include($this->getTemplatePath('_header')) ?>

<div class="page page-content-single js-page-not-found">
	<div class="content-single">
		<h1 class="page-primary-title">Not Found</h1>
		<p class="p">The page requested could not be found. Please go <a class="a" href="<?php echo $this->url->generate('home') ?>">home</a>.</p>
	</div>
</div>

<?php include($this->getTemplatePath('_footer')) ?>
