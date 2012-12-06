<?php require_once($this->pathView() . 'admin/header.php'); ?>
<?php
// echo '<pre>';
// print_r($Post->getData());
// echo '</pre>';
// exit;

?>

<div id="content" class="post press">
	
	<h2>Press Releases</h2>

	<a class="new" href="<?php echo $this->urlCurrent(); ?>new/" title="Add a new Press Release">New</a>

	<?php if ($Post->getData()) : ?>

	<table class="main" width="100%" cellspacing="0" cellpadding="0">

		<tr>
			<th>Select</th>
			<th>Title</th>
			<th class="text-center">Created on</th>
			<th>Action</th>
		</tr>

		<?php while ($Post->nextRow()) : ?>

		<tr data-id="<?php echo $Post->getRow('id'); ?>">

			<td>
				<input type="checkbox" name="id" value="<?php echo $Post->getRow('id'); ?>">
			</td>

			<td>
				<a href="<?php echo $Post->getRow('guid'); ?>" title="View Post <?php echo $Post->getRow('title'); ?>"><?php echo $Post->getRow('title'); ?></a>
			</td>

			<td class="text-center"><?php echo date('j D M Y', $Post->getRow('date_published')); ?></td>

			<td class="action"><a href="<?php echo $this->urlCurrent(); ?>?delete=<?php echo $Post->getRow('id'); ?>" title="Delete <?php echo $Post->getRow('title'); ?>">Delete</a></td>

		</tr>		

		<?php endwhile; ?>

	</table>
	
	<?php endif; ?>	

</div> <!-- styling aid -->

<?php require_once($this->pathView() . 'admin/footer.php'); ?>