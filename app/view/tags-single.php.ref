<?php require_once('header.php'); ?>
<?php
echo '<pre>';
print_r ($projects);
print_r ($posts);
echo '</pre>';
exit;
?>
<?php if ($content = $content->getResult()) : extract($content); ?>

	<h2><?php echo $title; ?></h2>

	<a href="<?php echo $guid; ?>"><?php echo $title; ?></a>
	<i><?php echo $date_published; ?></i>
	
<?php endif; ?>

<?php require_once('footer.php'); ?>