<?php require_once('_header.php') ?>

<div class="page content search">
	<h1>You searched for "<?php echo $query ?>". Which returned <?php echo $resultCount ?> result<?php echo (count($contents) > 1 || ! $contents ? 's' : '') ?>.</h1>

<?php include($this->pathView('_pagination')) ?>
<?php if ($contents) : ?>

	<div class="search-results">

	<?php include($this->pathView('_contents')) ?>

	</div>

<?php endif ?>	
<?php include($this->pathView('_pagination')) ?>

</div>

<?php require_once('_footer.php') ?>
