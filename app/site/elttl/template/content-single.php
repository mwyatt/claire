<?php require_once($this->getTemplatePath('_header')) ?>

<div class="page">

<?php if ($contents): ?>
	<?php foreach ($contents as $content): ?>
		
<div class="content-single is-type-<?php echo $content->type ?> clearfix" data-id="<?php echo $content->id ?>">
	<div class="content-date"><?php echo date('jS', $content->time_published) . ' of ' . date('F o', $content->time_published) ?></div>
	<h1 class="h1 content-single-title"><?php echo $content->title ?></h1>

	<?php if ($media = $content->media): ?>

	<div class="media js-content-single-gallery">

		<?php foreach ($media as $medium): ?>
			<?php require($this->getTemplatePath('_medium')) ?>
		<?php endforeach ?>
		
	</div>

	<?php endif ?>

	<div class="content-html typography"><?php echo $content->html ?></div>

	<?php if ($tags = $content->tag): ?>
		
	<h2 class="content-single-title-two">Tagged Under</h2>

		<?php include($this->getTemplatePath('_tags')) ?>
	<?php endif ?>

	<div class="content-date"><?php echo date('jS', $content->time_published) . ' of ' . date('F o', $content->time_published) ?></div>
</div>

	<?php endforeach ?>
<?php endif ?>

</div>

<?php require_once($this->getTemplatePath('_footer')) ?>

