<?php require_once('header.php'); ?>
<?php 
$covers[] = array(
	'title' => 'Photo Gallery'
	, 'guid' => $this->url('base') . 'gallery/'
	, 'description' => 'View photos from the recent 2013 tournament.'
	, 'button' => 'Go'
);
$covers[] = array(
	'title' => 'Summer League'
	, 'guid' => $this->url('base') . 'page/summer-league/'
	, 'description' => 'Register your interest for the upcoming summer league.'
	, 'button' => 'More Information'
);
$covers[] = array(
	'title' => 'Player Performance'
	, 'guid' => $this->url('base') . 'player/performance/'
	, 'description' => 'Visit the player performance to see who has gained the most ranking points throughout the season.'
	, 'button' => 'Go'
);
shuffle($covers);
?>
<?php if ($covers): ?>
	
<div class="cover">

	<?php foreach ($covers as $cover): ?>
		
	<a href="<?php echo $this->get($cover, 'guid') ?>" class="inner clearfix hide <?php echo $this->urlFriendly($this->get($cover, 'title')) ?>">
		<h1><?php echo $this->get($cover, 'title') ?></h1>
		<p><?php echo $this->get($cover, 'description') ?></p>
		<span class="button"><?php echo $this->get($cover, 'button') ?></span>
	</a>

	<?php endforeach ?>

</div>

<?php endif ?>

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