<?php require_once('app/cc/view/header.php'); ?>

	<?php if ($posts->getResult()) : ?>	
	<div>
		<?php while ($posts->nextRow()) : ?>

		<form class="edit_post" method="post">

			<input type="hidden" name="edit_post" value="true">
			
			<div>
				<input type="text" name="title" placeholder="<?php echo $posts->getRow('title'); ?>" autofocus="autofocus" value="<?php echo $posts->getRow('title'); ?>">					
			</div>
			
			<div>
				<p><?php echo $posts->getRow('guid'); ?></p>
				<a href="<?php echo $posts->getRow('guid'); ?>" title="Preview <?php echo $posts->getRow('title'); ?>">Preview</a>
			</div>
			
			<div>
				<textarea cols="50" name="html" rows="10" autofocus="autofocus">
					<?php echo $posts->getRow('html'); ?>
				</textarea>
			</div>
			
			<br><input class="" type="submit">
			
		</form>

<?php
echo '<pre>';
print_r ($posts->getRow('media'));
echo '</pre>';
exit;
?>

		<?php endwhile; ?>
	</div>
	<?php endif; ?>	

<?php require_once('app/cc/view/footer.php'); ?>