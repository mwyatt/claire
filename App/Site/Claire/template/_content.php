<?php $html = strip_tags($content->getHtml()) ?>
<?php $theDate = date('jS', $content->getTimePublished()) . ' of ' . date('F o', $content->getTimePublished()) ?>
<?php $theUrl = $this->url->build(array($content->getType(), $content->getSlug())) ?>

<div class="content element is-type-<?php echo $content->getType() ?> js-content" data-id="<?php echo $content->getId() ?>">

<?php if ($content->getUser()): ?>

	<div class="content-author"><span class="content-author-by">By</span> <a href="https://plus.google.com/100076113648548258052" class="content-author-link"><?php echo $content->getUser()->first_name ?> <?php echo $content->getUser()->last_name ?></a></div>
	
<?php endif ?>

	<div class="content-date" title="<?php echo $theDate ?>"><?php echo $theDate ?></div>
	<h2 class="content-title"><a href="<?php echo $theUrl ?>" class="content-link"><?php echo $content->getTitle() ?></a></h2>
	<div class="content-html-snippet"><?php echo substr($html, 0, 90) ?> ... </div>
	<a href="<?php echo $theUrl ?>" class="link content-html-snippet-more">Read More</a>
	<div class="content-html">

<?php echo $content->getHtml() ?>

	</div>
	<div class="content-status">

<?php echo ucfirst($content->getStatus()) ?>

	</div>
</div>
