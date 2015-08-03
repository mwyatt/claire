<?php include $this->getTemplatePath('admin/_header') ?>
	<?php $urlCreate = $this->url->generate('admin/ad/create') ?>

<div class="page ad-all">
	<div class="page-actions">
		<a class="page-action button-primary right" href="<?php echo $urlCreate ?>" title="Create a new Ad">Create</a>
	</div>
	<h1 class="page-primary-title">Ads</h1>

<?php if ($ads): ?>

<table class="table">
	<tr>
		<th>Title</th>
		<th>Description</th>
		<th>Status</th>
		<th>Group</th>
		<th></th>
	</tr>

	<?php foreach($ads as $ad): ?>
		<?php $urlEdit = $this->url->generate('admin/ad/single', ['id' => $ad->id]) ?>

	<tr class="ad js-ad">
		<td><a href="<?php echo $urlEdit ?>"><?php echo $ad->title ?></a></td>
		<td><?php echo $ad->description ?></td>
		<td><?php echo $ad->getStatusText() ?></td>
		<td><?php echo $ad->groupKey ?></td>
		<td>
			<a class="button-edit" href="<?php echo $urlEdit ?>">Edit</a>
			<a class="button-delete js-tennis-delete-single" href="<?php echo $this->url->generate('admin/ad/all', ['delete' => $ad->id]) ?>">Delete</a>
		</td>
	</tr>

	<?php endforeach; ?>

</table>

<?php else: ?>
	
	<div class="blankslate typography">
		<p>No ads have been created yet, why not <a href="<?php echo $urlCreate ?>">create</a> one now?</p>
	</div>
	
<?php endif ?>
		
</div>

<?php include $this->getTemplatePath('admin/_footer') ?>
