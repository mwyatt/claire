<?php require_once($this->pathView() . 'admin/header.php'); ?>

<div class="content page">
	<h1><?php echo ucfirst($this->urlSegment(2)); ?></h1>
	<div class="clearfix text-right row">
		<a class="button new" href="<?php echo $this->url('current_noquery'); ?>new/" title="Create a new <?php echo ucfirst($this->urlSegment(2)); ?>">New</a>
	</div>

<?php if ($this->get('model_maincontent')) : ?>

	<table class="main" width="100%" cellspacing="0" cellpadding="0">
		<thead>
			<tr>
				<th>Title</th>
				<th class="text-center">Created on</th>
				<th>Status</th>
				<th></th>
			</tr>
		</thead>
		<tbody>

	<?php foreach ($this->get('model_maincontent') as $content) : ?>

			<tr data-id="<?php echo $this->get($content, 'id'); ?>">
				<td>
					<a href="?edit=<?php echo $this->get($content, 'id'); ?>" title="Edit page <?php echo $this->get($content, 'title'); ?>"><?php echo $this->get($content, 'title'); ?></a>
				</td>
				<td class="text-center"><?php echo date('j D M Y', $this->get($content, 'date_published')); ?></td>
				<td class="text-center">
					<?php echo $this->get($content, 'status') ?>
				</td>
				<td class="action text-center">
					<a href="<?php echo $this->get($content, 'guid'); ?>" title="View <?php echo $this->get($content, 'title'); ?> online">View</a>
					<a href="<?php echo $this->url('current_noquery'); ?>?edit=<?php echo $this->get($content, 'id'); ?>" title="Edit <?php echo $this->get($content, 'title'); ?>" class="edit">Edit</a>
					<a href="<?php echo $this->url('current_noquery'); ?>?delete=<?php echo $this->get($content, 'id'); ?>" title="Delete <?php echo $this->get($content, 'title'); ?>" class="delete">Delete</a>
				</td>
			</tr>		

	<?php endforeach; ?>

		</tbody>
	</table>
	
<?php else: ?>
	
	<div class="nothing-yet">
		<p>No <?php echo ucfirst($this->urlSegment(2)); ?> have been created yet, why not <a href="<?php echo $this->url('current_noquery'); ?>new/">create</a> one now?</p>
	</div>
	
<?php endif ?>
		
</div>

<?php require_once($this->pathView() . 'admin/footer.php'); ?>