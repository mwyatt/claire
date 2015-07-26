<?php require_once($this->getTemplatePath('_header')) ?>

<div class="page not-found js-page-not-found">
	<h1 class="page-primary-title">404 Not Found</h1>
	<div class="typography">
		<p>The page requested could not be found. Please go <a href="<?php echo $this->url->generate('home') ?>">home</a>.</p>
	</div>
</div>

<?php require_once($this->getTemplatePath('_footer')) ?>
