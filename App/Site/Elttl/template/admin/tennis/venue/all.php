<?php include $this->getTemplatePath('admin/_header') ?>

<div class="page">
	<div class="page-actions">
		<a class="page-action button-primary right" href="<?php echo $urlCreate ?>" title="Create a new <?php echo ucwords($nameSingular) ?>">Create</a>
	</div>
	<h1 class="page-primary-title"><?php echo ucwords($namePlural) ?></h1>

<?php if (empty($$namePlural)): ?>

	<div class="blankslate typography">
		<p>No <?php echo $namePlural ?> have been created yet.</p>
	</div>

<?php else: ?>
	
	<table class="table">
		<tr>
			<th>Name</th>
			<th></th>
		</tr>

	<?php foreach($$namePlural as $$nameSingular): ?>

		<tr>
			<td><?php echo $$nameSingular->name ?></td>
			<td>
				<a class="button-edit" href="<?php echo $this->url->generate("admin/tennis/{$nameSingular}/single", ['id' => $$nameSingular->id]) ?>">Edit</a>
			</td>
		</tr>

	<?php endforeach ?>

	</table>
	
<?php endif ?>
		
</div>

<?php include $this->getTemplatePath('admin/_footer') ?>
