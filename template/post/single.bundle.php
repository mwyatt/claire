<?php include $this->getPathTemplate('_header') ?>

<div class="page post-single">
    <h1 class="post-single-title h1"><?php echo $post->get('title') ?></h1>
    <span class="post-single-date"><?php echo date('jS', $post->get('timePublished')) . ' of ' . date('F o', $post->get('timePublished')) ?></span>
    <div class="typography post-single-html"><?php echo $post->get('html') ?></div>
</div>

<?php include $this->getPathTemplate('_footer') ?>
