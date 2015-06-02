<?php include $this->getTemplatePath('admin/_header') ?>

<div class="page user-single" data-id="<?php echo $user->getId() ?>">
	<h1 class="page-primary-title"><?php echo $user->getId() ? 'Editing' : 'Creating' ?> user <?php echo $user->getNameFull() ? $user->getEmail() : $user->getId() ?></h1>
	<form class="main" method="post" enctype="multipart/form-data">
		<div class="page-actions">
			<a href="<?php echo $this->url->generate('admin/user/all') ?>" class="page-action left button-secondary">Back</a>
			<button type="submit" class="form-user-button-save page-action button-primary right">Save</button>
		</div>
	    <div class="block-margins">
        	<label class="form-label block form-user-label-title" for="form-user-name-first">First Name</label>
        	<input id="form-user-name-first" class="form-input w100 required js-input-name-first" type="text" name="user[nameFirst]" maxlength="75" value="<?php echo $user->getNameFirst() ?>" autofocus="autofocus">
        	<label class="form-label block form-user-label-title" for="form-user-name-last">last Name</label>
        	<input id="form-user-name-last" class="form-input w100 required js-input-name-last" type="text" name="user[nameLast]" maxlength="75" value="<?php echo $user->getNameLast() ?>">
	    </div>
	    <div class="block-margins">
        	<label class="form-label block form-user-label-title" for="form-user-email">Email</label>
        	<input id="form-user-email" class="form-input w100 required js-input-email" type="text" name="user[email]" maxlength="75" value="<?php echo $user->getEmail() ?>">
	    </div>
	    <div class="block-margins">
        	<label class="form-label block form-user-label-title" for="form-user-password">New Password</label>
        	<input id="form-user-password" class="form-input w100 required js-input-password" type="text" name="user[password]" maxlength="75" value="">
	    </div>
	    <div class="block-margins">
        	<label class="form-label block form-user-label-title" for="form-user-level">Level</label>
        	<input id="form-user-level" class="form-input w100 required js-input-level" type="text" name="user[level]" maxlength="75" value="<?php echo $user->getLevel() ?>">
	    </div>
	</form>
</div>

<?php include $this->getTemplatePath('admin/_footer') ?>
