<?php include($this->pathView('_header')) ?>

<div class="page home js-page-home">
	<div class="banner-and-press">
		<div class="banner-primary js-home-cover">
		
<?php $campaign->setSource('home cover banners') ?>
<?php $campaign->setMedium('referral') ?>
<?php foreach ($covers as $cover): ?>
	<?php $campaign->setCampaign($cover->name) ?>
	
			<a href="<?php echo $campaign->get($cover->url) ?>" class="cover">
				<h2 class="cover-primary-title"><?php echo $cover->name ?></h2>
				<p class="cover-description"><?php echo $cover->description ?></p>

	<?php if (isset($cover->image)): ?>
		
				<img class="cover-image" src="<?php echo $this->getUrlMedia($cover->image) ?>" alt="<?php echo $cover->name ?>">
				
	<?php endif ?>

				<span class="cover-button"><?php echo $cover->button ?></span>
			</a>

<?php endforeach ?>

		</div>
		<div class="home-press">
			<h1 class="home-press-heading">
				<a href="<?php echo $this->getUrl() ?>press/" class="home-button-all-posts">View all</a>
				<span class="home-press-heading-text">Press releases</span>
			</h1>
		
<?php include($this->pathView('_contents')) ?>

		</div>
	</div>

<?php if (isset($galleryPaths)): ?>

	<div class="gallery">
		<h1 class="home-press-heading">
			<span class="home-press-heading-text">Gallery</span>
		</h1>
		<div class="js-gallery">
			
	<?php foreach ($galleryPaths as $key => $path): ?>
	
			<a class="gallery-link js-magnific-gallery" href="<?php echo $this->getUrl() . $path ?>"><img class="gallery-image" src="<?php echo $path ?>" alt=""></a>

	<?php endforeach ?>

		</div>
	</div>

<?php endif ?>
<?php if (isset($divisions)): ?>

	<div class="home-divisions">
		<h1 class="home-press-heading">
			<span class="home-press-heading-text">Divisions</span>
		</h1>

	<?php include($this->pathView('_divisions')) ?>

	</div>

<?php endif ?>
<?php include($this->pathView('_advertisements')) ?>

</div>

<?php include($this->pathView('_footer')) ?>