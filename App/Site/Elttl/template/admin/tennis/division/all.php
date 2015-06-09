<?php include $this->getTemplatePath('admin/_header') ?>

<div class="page">
	<div class="page-actions">
		<a class="page-action button-primary right" href="<?php echo $urlCreate ?>" title="Create a new <?php echo ucwords($pageSingular) ?>">Create</a>
	</div>
	<h1 class="page-primary-title"><?php echo ucwords($pagePlural) ?></h1>

<?php if (empty($$pagePlural)): ?>

	<div class="blankslate typography">
		<p>No divisions have been created yet.</p>
	</div>

<?php else: ?>
	
	<table class="table">
		<tr>
			<th>Name</th>
		</tr>

	<?php foreach($$pagePlural as $$pageSingular): ?>

		<tr>
			<td><?php echo $$pageSingular->name ?></td>
		</tr>

	<?php endforeach ?>

	</table>
	
<?php endif ?>
		
</div>

<?php include $this->getTemplatePath('admin/_footer') ?>
