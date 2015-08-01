<?php include $this->getTemplatePath('admin/_header') ?>

<div class="page ad-single" data-id="<?php echo $ad->getId() ?>">
	<h1 class="page-primary-title"><?php echo $ad->id ? 'Editing' : 'Creating' ?> ad <?php echo $ad->title ? $ad->email : $ad->id ?></h1>
	<form class="main" method="post" enctype="multipart/form-data">
		<div class="page-actions">
			<a href="<?php echo $this->url->generate('admin/ad/all') ?>" class="page-action left button-secondary">Back</a>
			<button type="submit" class="form-ad-button-save page-action button-primary right">Save</button>
		</div>

		<!-- title -->
	    <div class="block-margins">
        	<label class="form-label block form-ad-label-title" for="form-ad-title">Title</label>
        	<input id="form-ad-title" class="form-input w100 required js-input-title" type="text" name="ad[title]" maxlength="75" value="<?php echo $ad->title ?>">
	    </div>

		<!-- description -->
	    <div class="block-margins">
        	<label class="form-label block form-ad-label-title" for="form-ad-description">Description</label>
        	<input id="form-ad-description" class="form-input w100 required js-input-description" type="text" name="ad[description]" maxlength="75" value="<?php echo $ad->description ?>">
	    </div>

		<!-- image -->
	    <div class="block-margins">
        	<label class="form-label block form-ad-label-title" for="form-ad-image">Description</label>
        	<input id="form-ad-image" class="form-input w100 required js-input-image" type="text" name="ad[image]" maxlength="75" value="<?php echo $ad->image ?>">
	    </div>
	    <div class="block-margins">
	    	<span class="button-secondary js-toggle-all-permissions">Toggle All Permissions</span>

<?php foreach ($permissionRoutes as $key => $route): ?>

			<div class="block-margins">
				<input id="form-ad-permission-<?php echo $key ?>" name="ad[permission][]" type="checkbox" value="<?php echo $route ?>" class="mr1" <?php echo empty($permissions[$route]) ? '' : 'checked' ?>>
				<label for="form-ad-permission-<?php echo $key ?>"><?php echo $route ?></label>
			</div>

<?php endforeach ?>

	    </div>
	</form>
</div>

<?php include $this->getTemplatePath('admin/_footer') ?>
