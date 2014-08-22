<?php include($this->pathView('_header')) ?>

<div class="page home js-page-home">
	<div class="banner-primary">
		<div>1</div>
		<div>2</div>
		<div>3</div>
	</div>
	<div class="home-press">
		<h1 class="home-press-heading">Press releases</h1>
		<a href="<?php echo $this->getUrl() ?>press/" class="home-button-all-posts">View all</a>
		
<?php include($this->pathView('_contents')) ?>

	</div>
	<div class="home-banner-secondary">
		<div>1</div>
		<div>2</div>
		<div>3</div>
		<div>4</div>
	</div>
</div>

<?php include($this->pathView('_footer')) ?>
