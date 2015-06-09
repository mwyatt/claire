<?php include $this->getTemplatePath('admin/_header') ?>

<div class="page">
	<h1 class="page-primary-title"><?php echo $$pageSingular->id ? 'Editing' : 'Creating' ?> <?php echo $pageSingular ?> <?php echo $$pageSingular->name ?></h1>
	<form class="main" method="post" enctype="multipart/form-data">
		<div class="page-actions">
			<a href="<?php echo $this->url->generate('admin/tennis/' . $pageSingular . '/all') ?>" class="page-action left button-secondary">Back</a>
			<button type="submit" class="form-user-button-save page-action button-primary right">Save</button>
		</div>
	    <div class="block-margins">
        	<label class="form-label block form-user-label-title" for="form-user-name-first">Name</label>
        	<input id="form-user-name-first" class="form-input w100 required js-input-name-first" type="text" name="<?php echo $pageSingular ?>[name]" maxlength="75" value="<?php echo $$pageSingular->name ?>" autofocus="autofocus">
	    </div>
	</form>
</div>

<?php include $this->getTemplatePath('admin/_footer') ?>
