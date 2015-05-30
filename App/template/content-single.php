<?php require_once($this->getTemplatePath('_header')) ?>

<div class="page content-single">

<?php if ($contents): ?>
	<?php foreach ($contents as $content): ?>
		
<div class="content-single is-type-<?php echo $content->getType() ?> clearfix" data-id="<?php echo $content->getId() ?>">
	<div class="content-date"><?php echo date('jS', $content->getTimePublished()) . ' of ' . date('F o', $content->getTimePublished()) ?></div>
	<h1 class="h1 content-single-title"><?php echo $content->getTitle() ?></h1>
	<div class="content-html typography"><?php echo $content->getHtml() ?></div>
	<div class="content-date"><?php echo date('jS', $content->getTimePublished()) . ' of ' . date('F o', $content->getTimePublished()) ?></div>
</div>

	<?php endforeach ?>
<?php endif ?>

</div>

<?php require_once($this->getTemplatePath('_footer')) ?>
