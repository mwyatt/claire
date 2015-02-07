<?php require_once($this->getTemplatePath('_header')) ?>

<div class="page">

<?php if ($contents): ?>
	<?php foreach ($contents as $content): ?>
			
	<div class="is-<?php echo $content->getSlug() ?>">
		<div class="project-single clearfix" data-id="<?php echo $content->getId() ?>">
			<div class="project-single-banner">
				<span class="project-single-banner-logo">
				
			<?php include $this->getAssetPath($content->getMetaKey('logo')) ?>

				</span>
			</div>

			<h1 class="h1 project-single-title"><?php echo $content->getTitle() ?></h1>
			<div class="project-html typography"><?php echo $content->getHtml() ?></div>
		</div>
	</div>

	<?php endforeach ?>
<?php endif ?>

</div>

<?php require_once($this->getTemplatePath('_footer')) ?>
