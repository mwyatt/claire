<?php $theDate = date('jS', $content->getTimePublished()) . ' of ' . date('F o', $content->getTimePublished()) ?>

<div class="content element is-type-<?php echo $content->getType() ?> js-content" data-id="<?php echo $content->getId() ?>">

<?php if (isset($medium)): ?>
	
	<div class="content-thumb-background" style="background-image: url(<?php echo $this->getPathMediaUpload($medium->path) ?>); background-repeat: no-repeat; background-position: center center;"></div>

<?php endif ?>
<?php include($this->getTemplatePath('_medium')) ?>

	<div class="content-date" title="<?php echo $theDate ?>"><?php echo $theDate ?></div>
	<h2 class="content-title"><a href="<?php echo $content->getUrl() ?>" class="content-link"><?php echo $content->getTitle() ?></a></h2>
	<div class="content-status">

<?php echo ucfirst($content->getStatus()) ?>

	</div>

<?php include $this->getTemplatePath('_tags') ?>
<?php if ($this->isAdmin()): ?>
	
	<div class="content-action">
		<!-- <a class="content-action-link" href="<?php echo $content->getUrl() ?>" title="View <?php echo $content->getTitle() ?> online" target="blank">View</a> -->
		<a class="content-action-link" href="<?php echo $this->getUrl('current_noquery') ?>?edit=<?php echo $content->getId() ?>" title="Edit <?php echo $content->getTitle() ?>" class="edit">Edit</a>
		<!-- <a class="content-action-link" href="<?php echo $this->getUrl('current_noquery') ?>?<?php echo ($content->getStatus() == 'archive' ? 'delete' : 'archive') ?>=<?php echo $content->getId() ?>" title="<?php echo ($content->getStatus() == 'archive' ? 'Delete' : 'Archive') ?> <?php echo $content->getTitle() ?>" class="archive"><?php echo ($content->getStatus() == 'archive' ? 'Delete' : 'Archive') ?></a> -->
	</div>

<?php endif ?>

</div>
