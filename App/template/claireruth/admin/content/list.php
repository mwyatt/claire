<?php require_once($this->getTemplatePath() . 'admin/_header.php') ?>

<div class="main-content<?php echo $this->url->getPathPart(2) ?>">
	<div class="clearfix">

<?php if ($statuses): ?>
	<?php foreach ($statuses as $status): ?>
		
		<a class="button right" href="<?php echo $this->url->generate('current_noquery') ?>?status=<?php echo $status ?>">Status: <?php echo ucfirst($status) ?></a>

	<?php endforeach ?>
<?php endif ?>

		<a class="button right" href="<?php echo $this->url->generate('current_noquery') ?>new/" title="Create a new <?php echo ucfirst($this->url->getPathPart(2)) ?>">New</a>
	</div>
	<h1 class="page-heading"><?php echo ucfirst($this->url->getPathPart(2)) ?></h1>

<?php include($this->getTemplatePath('_contents')) ?>
<?php if (! $contents): ?>
	
	<div class="nothing-yet">
		<p>No <?php echo ucfirst($this->url->getPathPart(2)) ?> have been created yet, why not <a href="<?php echo $this->url->generate('current_noquery') ?>new/">create</a> one now?</p>
	</div>
	
<?php endif ?>
		
</div>

<?php require_once($this->getTemplatePath() . 'admin/_footer.php') ?>
