<?php require_once($this->pathView() . 'admin/header.php'); ?>

<div class="content page">
	<h1><?php echo ucfirst($this->urlSegment(2)); ?></h1>
	<a class="new" href="<?php echo $this->urlCurrent(); ?>new/" title="Create a new <?php echo ucfirst($this->urlSegment(2)); ?>">New</a>

<?php if ($this->get('model_maincontent')) : ?>

	<table class="main" width="100%" cellspacing="0" cellpadding="0">
		<tr>
			<th>Title</th>
			<th class="text-center">Created on</th>
			<th>Action</th>
		</tr>

	<?php foreach ($this->get('model_maincontent') as $content) : ?>

		<tr data-id="<?php echo $this->get($content, 'id'); ?>">
			<td>
				<a href="?edit=<?php echo $this->get($content, 'id'); ?>" title="Edit page <?php echo $this->get($content, 'title'); ?>"><?php echo $this->get($content, 'title'); ?></a>
			</td>
			<td class="text-center"><?php echo date('j D M Y', $this->get($content, 'date_published')); ?></td>
			<td class="action">
				<a href="<?php echo $this->get($content, 'guid'); ?>" title="View mainContent <?php echo $this->get($content, 'title'); ?>">View <?php echo $this->get($content, 'title'); ?></a>
				<a href="<?php echo $this->urlCurrent(); ?>?edit=<?php echo $this->get($content, 'id'); ?>" title="Edit <?php echo $this->get($content, 'title'); ?>" class="edit">Edit</a>
				<a href="<?php echo $this->urlCurrent(); ?>?delete=<?php echo $this->get($content, 'id'); ?>" title="Delete <?php echo $this->get($content, 'title'); ?>" class="delete">Delete</a>
			</td>
		</tr>		

	<?php endforeach; ?>

	</table>
	
<?php endif; ?>	
		
</div>

<?php require_once($this->pathView() . 'admin/footer.php'); ?>