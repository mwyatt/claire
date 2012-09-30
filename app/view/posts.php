<?php require_once('header.php'); ?>

<h2>All Posts</h2>

<?php if ($posts->getResult()) : ?>
<ol>
	<?php foreach ($posts->getResult() as $post) : extract($post); ?>
	<li>
		<a href="<?php echo $guid; ?>"><?php echo $title; ?></a>
		<i><?php echo $date_published; ?></i>
	</li>
	
	
	<!--<?php foreach ($tags as $tag) : extract($tag); ?>
		<a href="<?php echo $url; ?>"><?php echo $name; ?></a> / 
	<?php endforeach; ?>-->
	
	<?php endforeach; ?>
</ol>
<?php endif; ?>

<?php require_once('footer.php'); ?>