<?php $theDate = date('jS', $content->timePublished) . ' of ' . date('F o', $content->timePublished) ?>

<div class="content element is-type-<?php echo $content->type ?> js-content" data-id="<?php echo $content->id ?>">

<?php if (isset($medium)) : ?>
	
	<div class="content-thumb-background" style="background-image: url(<?php echo $this->getPathMediaUpload($medium->path) ?>); background-repeat: no-repeat; background-position: center center;"></div>

<?php endif ?>
<?php include($this->getTemplatePath('_medium')) ?>

	<div class="content-date" title="<?php echo $theDate ?>"><?php echo $theDate ?></div>
	<h2 class="content-title"><a href="<?php echo $this->url->generate('content/single', ['type' => $content->type, 'slug' => $content->slug]) ?>" class="link-primary content-link"><?php echo $content->title ?></a></h2>
	<div class="content-status">

<?php echo ucfirst($content->status) ?>

	</div>

<?php include $this->getTemplatePath('_tags') ?>
<?php if ($this->isAdmin()) : ?>
	
	<div class="content-action">
		<!-- <a class="content-action-link" href="<?php echo $this->url->generate('content/single', ['type' => $content->type, 'slug' => $content->slug]) ?>" title="View <?php echo $content->title ?> online" target="blank">View</a> -->
		<a class="content-action-link" href="<?php echo $this->url->generate('current_noquery') ?>?edit=<?php echo $content->id ?>" title="Edit <?php echo $content->title ?>" class="edit">Edit</a>
		<!-- <a class="content-action-link" href="<?php echo $this->url->generate('current_noquery') ?>?<?php echo ($content->status == 'archive' ? 'delete' : 'archive') ?>=<?php echo $content->id ?>" title="<?php echo ($content->status == 'archive' ? 'Delete' : 'Archive') ?> <?php echo $content->title ?>" class="archive"><?php echo ($content->status == 'archive' ? 'Delete' : 'Archive') ?></a> -->
	</div>

<?php endif ?>

</div>
