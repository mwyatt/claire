<?php include $this->getTemplatePath('admin/_header') ?>
	<?php $urlCreate = $this->getUrl('adminContentCreate', ['type' => $contentType]) ?>

<div class="page content-all">
	<div class="page-actions">
		<a class="button right" href="<?php echo $urlCreate ?>" title="Create a new <?php echo ucfirst($contentType) ?>">New</a>
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
		<?php $urlEdit = $this->getUrl('adminContentSingle', ['type' => $contentType, 'id' => $content->getId()]) ?>

	<tr class="content js-content">
		<td><a href="<?php echo $urlEdit ?>"><?php echo $content->getTitle() ?></a></td>
		<td><a href="<?php echo $content->getUrl() ?>" target="_blank"><?php echo $content->getUrl() ?></a></td>
		<td><?php echo $content->getStatusText() ?></td>
		<td>
			<a class="button-edit" href="<?php echo $urlEdit ?>">Edit</a>
			<a class="button-delete" href="<?php echo $this->getUrl('adminContentAll', ['type' => $content->getType(), 'delete' => $content->getId()]) ?>">Delete</a>
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
