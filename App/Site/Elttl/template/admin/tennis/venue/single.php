<?php include $this->getTemplatePath('admin/_header') ?>

<div class="page">
	<h1 class="page-primary-title"><?php echo $$nameSingular->id ? 'Editing' : 'Creating' ?> <?php echo $nameSingular ?> <?php echo $$nameSingular->name ?></h1>
	<form class="main" method="post" enctype="multipart/form-data">
		<div class="page-actions">
			<a href="<?php echo $this->url->generate('admin/tennis/' . $nameSingular . '/all') ?>" class="page-action left button-secondary">Back</a>

<?php if ($$nameSingular->id): ?>

			<span class="page-action button-secondary left js-tennis-delete-single" data-singular="<?php echo $nameSingular ?>" data-id="<?php echo $$nameSingular->id ?>">Delete</span>

<?php endif ?>

			<button type="submit" class="form-user-button-save page-action button-primary right">Save</button>
		</div>
	    <div class="block-margins">
        	<label class="form-label block" for="form-name">Name</label>
        	<input id="form-name" class="form-input w100" type="text" name="entity[name]" value="<?php echo $$nameSingular->name ?>" required>
	    </div>
	    <div class="block-margins">
        	<label class="form-label block" for="form-slug">Slug</label>
        	<input id="form-slug" class="form-input w100" type="text" name="entity[slug]" value="<?php echo $$nameSingular->slug ?>" required>
	    </div>
	    <div class="block-margins">
        	<label class="form-label block" for="form-location">Location</label>
        	<input id="form-location" class="form-input w100" type="text" name="entity[location]" value="<?php echo $$nameSingular->location ?>" required>
	    </div>
	</form>
</div>

<?php include $this->getTemplatePath('admin/_footer') ?>
