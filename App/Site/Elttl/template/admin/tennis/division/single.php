<?php include $this->getTemplatePath('admin/_header') ?>

<div class="page">
	<h1 class="page-primary-title"><?php echo $$nameSingular->id ? 'Editing' : 'Creating' ?> <?php echo $nameSingular ?> <?php echo $$nameSingular->name ?></h1>
	<form class="main" method="post" enctype="multipart/form-data">
		<div class="page-actions">
			<a href="<?php echo $this->url->generate('admin/tennis/' . $nameSingular . '/all') ?>" class="page-action left button-secondary">Back</a>
			<a class="button-delete" href="<?php echo $this->url->generate("admin/tennis/$nameSingular/all", ['delete' => $$nameSingular->id]) ?>">Delete</a>
			<button type="submit" class="form-user-button-save page-action button-primary right">Save</button>
		</div>
	    <div class="block-margins">
        	<label class="form-label block form-user-label-title" for="form-user-name-first">Name</label>
        	<input id="form-user-name-first" class="form-input w100 required js-input-name-first" type="text" name="entity[name]" maxlength="75" value="<?php echo $$nameSingular->name ?>" autofocus="autofocus">
	    </div>
	</form>
</div>

<?php include $this->getTemplatePath('admin/_footer') ?>
