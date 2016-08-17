<?php require_once('_header.php') ?>

<div class="page content month clearfix">
	<h1 class="h2 mb1">All posts from <?php echo $this->get('month_year') ?></h1>

<?php $rowContents = $this->get('model_content') ?>
<?php include($this->getPathTemplate('_contents')) ?>

</div>

<?php require_once('_footer.php') ?>
