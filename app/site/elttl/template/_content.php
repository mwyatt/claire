<?php $theDate = date('jS', $content->time_published) . ' of ' . date('F o', $content->time_published) ?>
<?php $theUrl = $this->url->build(array($content->type, $content->slug)) ?>

<div class="content element is-type-<?php echo $content->type ?> <?php echo ($content->media ? ' has-thumb' : '') ?> js-content" data-id="<?php echo $content->id ?>">

<?php $medium = reset($content->media) ?>
<?php if ($medium): ?>
	
	<div class="content-thumb-background" style="background-image: url(<?php echo $this->getPathMediaUpload($medium->path) ?>); background-repeat: no-repeat; background-position: center center;"></div>

<?php endif ?>
<?php include($this->pathView('_medium')) ?>
<?php if ($content->user): ?>

	<div class="content-author"><span class="content-author-by">By</span> <a href="https://plus.google.com/100076113648548258052" class="content-author-link"><?php echo $content->user->first_name ?> <?php echo $content->user->last_name ?></a></div>
	
<?php endif ?>

	<div class="content-date" title="<?php echo $theDate ?>"><?php echo $theDate ?></div>
	<h2 class="content-title"><a href="<?php echo $theUrl ?>" class="content-link"><?php echo $content->title ?></a></h2>
	<div class="content-status">

<?php echo ucfirst($content->status) ?>

	</div>

<?php $tags = $content->tag ?>
<?php include($this->pathView('_tags')) ?>
<?php if ($this->isAdmin()): ?>
	
	<div class="content-action">
		<!-- <a class="content-action-link" href="<?php echo $theUrl ?>" title="View <?php echo $content->title ?> online" target="blank">View</a> -->
		<a class="content-action-link" href="<?php echo $this->getUrl('current_noquery') ?>?edit=<?php echo $content->id ?>" title="Edit <?php echo $content->title ?>" class="edit">Edit</a>
		<!-- <a class="content-action-link" href="<?php echo $this->getUrl('current_noquery') ?>?<?php echo ($content->status == 'archive' ? 'delete' : 'archive') ?>=<?php echo $content->id ?>" title="<?php echo ($content->status == 'archive' ? 'Delete' : 'Archive') ?> <?php echo $content->title ?>" class="archive"><?php echo ($content->status == 'archive' ? 'Delete' : 'Archive') ?></a> -->
	</div>

<?php endif ?>

</div>