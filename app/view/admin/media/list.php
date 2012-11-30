<?php require_once($this->pathView() . 'admin/header.php'); ?>
<?php
// echo '<pre>';
// print_r($mainMedia);
// echo '</pre>';

//     (
//             [0] => Array
//                 (
//                     [id] => 1
//                     [file_name] => example-media-1.jpg
//                     [title] => Example Media 1
//                     [title_slug] => example-media-1
//                     [date_published] => 1353866981
//                     [type] => jpg
//                     [tree_id] => 0
//                 )
 
?>

<div id="content" class="media">
	
	<h2>Existing Media:</h2>

	<?php if ($mainMedia->getData()) : ?>

	<table width="100%" cellspacing="0" cellpadding="20" border="1">
		<tr>
			<th>Image</th>
			<th>Title</th>
			<th>Slug</th>
			<th>Date Uploaded</th>
			<th>Type</th>
			<th>User</th>
			<th>Actions</th>
		</tr>	

		<?php while ($mainMedia->nextRow()) : ?>

		<tr>
			<td><a href="<?php echo $this->image($mainMedia->getRow('file_name')); ?>"><img src="<?php echo $this->image($mainMedia->getRow('file_name')); ?>" width="150"></a></td>
			<td><a href="#" title="Edit Media Listing"><?php echo $mainMedia->getRow('title'); ?></a></td>
			<td><a href="<?php echo $this->image($mainMedia->getRow('file_name')); ?>">Direct Link</a></td>
			<td><?php echo date('j D M Y', $mainMedia->getRow('date_published')); ?></td>
			<td><?php echo $mainMedia->getRow('type'); ?></td>
			<td><?php echo $mainMedia->getRow('user_id'); ?></td>
			<td><a href="#">Delete</a></td>
		</tr>	

		<?php endwhile; ?>

	</table>

	<?php endif; ?>	

	<h2>Upload Form</h2>

	<form id="upload" action="" method="post" enctype="multipart/form-data">
			<input type="file" name="media[]" multiple>
			<input type="submit" name="form_media_upload" value="Upload" />
	</form>

</div> <!-- styling aid -->

<?php require_once($this->pathView() . 'admin/footer.php'); ?>