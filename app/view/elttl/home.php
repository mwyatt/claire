<?php include($this->pathView('_header')) ?>

<div class="page home js-page-home">
	<div class="banner-primary js-home-cover">
		
<?php foreach ($covers as $cover): ?>
	
		<a href="<?php echo $cover->url ?>" class="cover">
			<h2 class="cover-primary-title"><?php echo $cover->name ?></h2>
			<p class="cover-description"><?php echo $cover->description ?></p>
			<span class="cover-button"><?php echo $cover->button ?></span>
		</a>

<?php endforeach ?>

	</div>
	<div class="home-press">
		<h1 class="home-press-heading">Press releases</h1>
		<div class="home-press-control">
			<a href="<?php echo $this->getUrl() ?>press/" class="home-button-all-posts">View all</a>
		</div>
		
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
