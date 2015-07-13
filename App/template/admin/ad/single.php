<?php include $this->getTemplatePath('admin/_header') ?>

<div class="page ad-single" data-id="<?php echo $ad->getId() ?>">
	<h1 class="page-primary-title"><?php echo $ad->getId() ? 'Editing' : 'Creating' ?> ad <?php echo $ad->getNameFull() ? $ad->getEmail() : $ad->getId() ?></h1>
	<form class="main" method="post" enctype="multipart/form-data">
		<div class="page-actions">
			<a href="<?php echo $this->url->generate('admin/ad/all') ?>" class="page-action left button-secondary">Back</a>
			<button type="submit" class="form-ad-button-save page-action button-primary right">Save</button>
		</div>
	    <div class="block-margins">
        	<label class="form-label block form-ad-label-title" for="form-ad-name-first">First Name</label>
        	<input id="form-ad-name-first" class="form-input w100 required js-input-name-first" type="text" name="ad[nameFirst]" maxlength="75" value="<?php echo $ad->getNameFirst() ?>" autofocus="autofocus">
        	<label class="form-label block form-ad-label-title" for="form-ad-name-last">last Name</label>
        	<input id="form-ad-name-last" class="form-input w100 required js-input-name-last" type="text" name="ad[nameLast]" maxlength="75" value="<?php echo $ad->getNameLast() ?>">
	    </div>
	    <div class="block-margins">
        	<label class="form-label block form-ad-label-title" for="form-ad-email">Email</label>
        	<input id="form-ad-email" class="form-input w100 required js-input-email" type="text" name="ad[email]" maxlength="75" value="<?php echo $ad->getEmail() ?>">
	    </div>
	    <div class="block-margins">
        	<label class="form-label block form-ad-label-title" for="form-ad-password">New Password</label>
        	<input id="form-ad-password" class="form-input w100 required js-input-password" type="text" name="ad[password]" maxlength="75" value="">
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
