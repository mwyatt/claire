<?php include $this->getPathTemplate('_header') ?>

<div class="page home">

<?php if ($posts): ?>

    <div class="post-container">

    <?php foreach ($posts as $post): ?>
        <?php $postHtml = strip_tags($post->get('html')) ?>
        <?php $postDate = date('jS', $post->get('timePublished')) . ' of ' . date('F o', $post->get('timePublished')) ?>
        <?php $postUrl = $url->generate('post.single', ['slug' => $post->get('slug')]) ?>

        <div class="content element is-type-<?php echo $post->get('type') ?> js-content" data-id="<?php echo $post->get('id') ?>">

        <?php if ($post->get('user')): ?>

            <div class="content-author"><span class="content-author-by">By</span> <a href="https://plus.google.com/100076113648548258052" class="content-author-link"><?php echo $post->get('user')->first_name ?> <?php echo $post->get('user')->last_name ?></a></div>
            
        <?php endif ?>

            <div class="content-date" title="<?php echo $postDate ?>"><?php echo $postDate ?></div>
            <h2 class="content-title"><a href="<?php echo $postUrl ?>" class="content-link"><?php echo $post->get('title') ?></a></h2>
            <div class="content-html-snippet"><?php echo substr($postHtml, 0, 90) ?> ... </div>
            <a href="<?php echo $postUrl ?>" class="link content-html-snippet-more">Read More</a>
            <div class="content-html">

        <?php echo $post->get('html') ?>

            </div>
            <div class="content-status">

        <?php echo ucfirst($post->get('status')) ?>

            </div>
        </div>


    <?php endforeach ?>

    </div>
    
<?php endif ?>

</div>

<?php include $this->getPathTemplate('_footer') ?>
