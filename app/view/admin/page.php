<?php require_once($this->pathView() . 'admin/header.php'); ?>

<div class="content page">
	<h1>Page</h1>
	<a class="new" href="<?php echo $this->urlCurrent(); ?>new/" title="Add a new Press Release">New</a>

<?php if ($this->get('model_maincontent')) : ?>

	<table class="main" width="100%" cellspacing="0" cellpadding="0">
		<tr>
			<th>Title</th>
			<th class="text-center">Created on</th>
			<th>Action</th>
		</tr>

	<?php foreach ($this->get('model_maincontent') as $page) : ?>

		<tr data-id="<?php echo $this->get($page, 'id'); ?>">
			<td>
				<a href="<?php echo $this->get($page, 'guid'); ?>" title="View mainContent <?php echo $this->get($page, 'title'); ?>"><?php echo $this->get($page, 'title'); ?></a>
			</td>
			<td class="text-center"><?php echo date('j D M Y', $this->get($page, 'date_published')); ?></td>
			<td class="action">
				<button>view on frontend</button>
				<button>edit</button>
				<button>delete</button>
				<!-- <a href="<?php echo $this->urlCurrent(); ?>?delete=<?php echo $this->get($page, 'id'); ?>" title="Delete <?php echo $this->get($page, 'title'); ?>">Delete</a> -->
			</td>
		</tr>		

	<?php endforeach; ?>

	</table>
	
<?php endif; ?>	
		
</div>

<?php require_once($this->pathView() . 'admin/footer.php'); ?>