<?php include $this->getPathTemplate('_header') ?>

<div class="page content tag">
	<h1 class="content-single-title"><?php echo $totalContents ?> <?php echo $contentSingle->getType() . $this->pluralise($contents) ?> tagged '<?php echo $tagCurrent->title ?>'</h1>

<?php include($this->getPathTemplate('_pagination')) ?>
<?php include($this->getPathTemplate('_contents')) ?>
<?php include($this->getPathTemplate('_pagination')) ?>

</div>

<?php include $this->getPathTemplate('_footer') ?>
