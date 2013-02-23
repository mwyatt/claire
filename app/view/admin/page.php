<?php require_once($this->pathView() . 'admin/header.php'); ?>

<div class="content page">

	<h1>Page</h1>

	<a class="new" href="<?php echo $this->urlCurrent(); ?>new/" title="Add a new Press Release">New</a>

	<?php if ($mainContent->getData()) : ?>

	<table class="main" width="100%" cellspacing="0" cellpadding="0">

		<tr>
			<th>Select</th>
			<th>Title</th>
			<th class="text-center">Created on</th>
			<th>Action</th>
		</tr>

		<?php while ($mainContent->nextRow()) : ?>

		<tr data-id="<?php echo $mainContent->getRow('id'); ?>">

			<td>
				<input type="checkbox" name="id" value="<?php echo $mainContent->getRow('id'); ?>">
			</td>

			<td>
				<a href="<?php echo $mainContent->getRow('guid'); ?>" title="View mainContent <?php echo $mainContent->getRow('title'); ?>"><?php echo $mainContent->getRow('title'); ?></a>
			</td>

			<td class="text-center"><?php echo date('j D M Y', $mainContent->getRow('date_published')); ?></td>

			<td class="action"><a href="<?php echo $this->urlCurrent(); ?>?delete=<?php echo $mainContent->getRow('id'); ?>" title="Delete <?php echo $mainContent->getRow('title'); ?>">Delete</a></td>

		</tr>		

		<?php endwhile; ?>

	</table>
	
	<?php endif; ?>	
		
</div>

<?php require_once($this->pathView() . 'admin/footer.php'); ?>