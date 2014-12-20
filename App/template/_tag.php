<?php if (isset($tag)): ?>
	
<a href="<?php echo $this->url->build(array('tag', $tag->title)) ?>" class="tag js-tag" data-id="<?php echo $tag->id ?>">
	<span class="tag-title js-tag-title"><?php echo ucwords($tag->title) ?></span>
</a>

<?php endif ?>
