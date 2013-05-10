<?php require_once('header.php'); ?>

<div class="cover">
	<a href="gallery/" class="inner clearfix">
		<h1>Photo Gallery</h1>
		<p>View photos from the recent 2013 tournament.</p>
		<span class="button">Go</span>
	</a>
</div>
<div class="content home clearfix">

<?php if ($this->get('model_maincontent')): ?>
    
	<div class="press">
		<h2>Hot off the press</h2>

    <?php foreach ($this->get('model_maincontent') as $press): ?>

		<a class="clearfix" href="<?php echo $this->get($press, 'guid') ?>">
			<!-- <img src="#" alt=""> -->
			<h3><?php echo $this->get($press, 'title') ?></h3>
			<span class="date"><?php echo date('jS', $this->get($press, 'date_published')) . ' of ' . date('F Y', $this->get($press, 'date_published')) ?></span>
		</a>
        
    <?php endforeach ?>

	</div>

<?php endif ?>

	<a href="#" class="handbook">
		<span></span>
		Download the Handbook
	</a>
</div>

<?php require_once('footer.php'); ?>