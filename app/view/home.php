<?php require_once('header.php'); ?>

<a href="#" class="cover clearfix">
	<h1>Photo Gallery</h1>
	<p>View photos from the recent 2013 tournament.</p>
	<span class="button">Go</span>
</a>

<div class="content home">

<?php if ($this->get('model_maincontent')): ?>
    
	<div class="press">
		<h2>Hot off the press</h2>

    <?php foreach ($this->get('model_maincontent') as $press): ?>

		<a href="#">
			<img src="#" alt="">
			<h3>example headline</h3>
		</a>
                        <div class="press-<?php echo strtolower($this->get($press, 'name')) ?>">
                            <h4><a href="<?php echo $this->get($press, 'url') ?>"><?php echo $this->get($press, 'name') ?></a></h4>
                            <a href="<?php echo $this->get($press, 'url') ?>">Overview</a>
                            <a href="<?php echo $this->get($press, 'url') ?>merit/">Merit Table</a>
                            <a href="<?php echo $this->get($press, 'url') ?>league/">League Table</a>
                            <a href="<?php echo $this->get($press, 'url') ?>fixture/">Fixtures</a>
                        </div>        
        
    <?php endforeach ?>

	</div>

<?php endif ?>

	<a href="#" class="handbook">
		<span></span>
		Download the Handbook
	</a>
</div>

<?php require_once('footer.php'); ?>