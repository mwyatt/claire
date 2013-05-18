<?php require_once('header.php'); ?>

<div class="cover">
	<a href="gallery/" class="inner clearfix gallery">
		<h1>Photo Gallery</h1>
		<p>View photos from the recent 2013 tournament.</p>
		<span class="button">Go</span>
	</a>
</div>
<div class="content home clearfix">

<?php if ($this->get('model_maincontent')): ?>
    
	<div class="press">
		<a href="press/" class="button">All press</a>
		<h2>Hot off the press</h2>

    <?php foreach ($this->get('model_maincontent') as $press): ?>

		<a class="item clearfix" href="<?php echo $this->get($press, 'guid') ?>">
			<!-- <img src="#" alt=""> -->
			<h3><?php echo $this->get($press, 'title') ?></h3>
			<span class="date"><?php echo date('jS', $this->get($press, 'date_published')) . ' of ' . date('F Y', $this->get($press, 'date_published')) ?></span>
		</a>
        
    <?php endforeach ?>

	</div>

<?php endif ?>

	<div class="ads">
		<a href="media/handbook.pdf" class="handbook ad">
			<span></span>
			<h4>Download the Handbook</h4>
		</a>
		<a href="" class="ad">
			<span></span>
			<h4>Tables and results</h4>
		</a>
		<a href="gallery/" class="ad">
			<span></span>
			<h4>The gallery</h4>
		</a>
		<a href="player/prformance/" class="ad">
			<span class="tag new">New</span>
			<span></span>
			<h4>Player performance</h4>
		</a>
	</div>
</div>

<?php require_once('footer.php'); ?>