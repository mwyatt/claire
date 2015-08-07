<?php include $this->getTemplatePath('_header') ?>

<div class="page home js-page-home">
	<div class="banner-and-press">

<?php if (!empty($covers)) : ?>

		<div class="banner-primary-container">
			<div class="banner-primary js-home-cover">
	
	<?php $campaign->setSource('home cover banners') ?>
	<?php $campaign->setMedium('referral') ?>
	<?php foreach ($covers as $ad) : ?>
		<?php $campaign->setCampaign($ad->title) ?>
	
				<a href="<?php echo $campaign->get($ad->url) ?>" class="cover">
					<h2 class="cover-primary-title"><?php echo $ad->title ?></h2>
					<p class="cover-description"><?php echo $ad->description ?></p>

		<?php if (!empty($ad->image)) : ?>
		
					<img class="cover-image" src="<?php echo $this->getAssetPath($ad->image) ?>" alt="<?php echo $ad->title ?>">
				
		<?php
endif ?>

					<span class="button-secondary cover-button"><?php echo $ad->action ?></span>
				</a>

	<?php
endforeach ?>

			</div>
		</div>

<?php endif ?>
<?php if (!empty($contents)) : ?>

		<div class="home-press">
			<h1 class="home-heading">
				<a href="<?php echo $this->url->generate() ?>press/" class="home-button-all-posts">View all</a>
				<span class="home-heading-text">Press releases</span>
			</h1>
		
	<?php include($this->getTemplatePath('_contents')) ?>

		</div>
		
<?php endif ?>

	</div>

<?php if (!empty($galleryPaths)) : ?>

	<div class="gallery">
		<h1 class="home-heading">
			<span class="home-heading-text">Gallery</span>
		</h1>
		<div class="js-gallery">
			
	<?php foreach ($galleryPaths as $key => $path) : ?>
	
			<a class="gallery-link js-magnific-gallery" href="<?php echo $this->url->generate() . $path ?>"><img class="gallery-image" src="<?php echo $path ?>" alt=""></a>

	<?php
endforeach ?>

		</div>
	</div>

<?php endif ?>
<?php if (!empty($divisions)) : ?>

	<div class="home-divisions">
		<h1 class="home-heading">
			<span class="home-heading-text">Divisions</span>
		</h1>

	<?php include($this->getTemplatePath('_divisions')) ?>

	</div>

<?php endif ?>
<?php include($this->getTemplatePath('_advertisements')) ?>

</div>

<?php include $this->getTemplatePath('_footer') ?>
