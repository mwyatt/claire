<?php include $this->getTemplatePath('admin/_header') ?>
	<?php $urlCreate = $this->url->generate('admin/content/create', ['type' => $contentType]) ?>

<div class="page content-all">
	<div class="page-actions">
		<a class="button-primary page-action right" href="<?php echo $urlCreate ?>" title="Create a new <?php echo ucfirst($contentType) ?>">Create</a>
	</div>
	<h1 class="page-primary-title"><?php echo ucfirst($contentType) ?>s</h1>

<?php if ($contents): ?>

<table class="content-all-table">
	<tr>
		<th>Title</th>
		<th>Url</th>
		<th>Status</th>
		<th>Action</th>
	</tr>

	<?php foreach($contents as $content): ?>
		<?php $urlSingle = $this->url->generate('content/single', ['type' => $contentType, 'slug' => $content->getSlug()]) ?>
		<?php $urlEdit = $this->url->generate('admin/content/single', ['type' => $contentType, 'id' => $content->getId()]) ?>

	<tr class="content js-content">
		<td><a href="<?php echo $urlEdit ?>"><?php echo $content->getTitle() ?></a></td>
		<td><a href="<?php echo $urlSingle ?>" target="_blank"><?php echo $urlSingle ?></a></td>
		<td><?php echo $content->getStatusText() ?></td>
		<td>
			<a class="button-edit" href="<?php echo $urlEdit ?>">Edit</a>
		</td>
	</tr>

	<?php endforeach; ?>

</table>

<?php else: ?>
	
	<div class="nothing-yet">
		<p>No <?php echo ucfirst($contentType) ?> have been created yet, why not <a href="<?php echo $urlCreate ?>">create</a> one now?</p>
	</div>
	
<?php endif ?>
		
</div>

<?php include $this->getTemplatePath('admin/_footer') ?>
