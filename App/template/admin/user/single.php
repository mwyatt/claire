<?php include $this->getTemplatePath('admin/_header') ?>

<div class="page user-single" data-id="<?php echo $user->getId() ?>">
	<div class="page-actions">
		<a href="<?php echo $this->getUrl('adminUserAll') ?>" class="page-action-button">Back</a>
	</div>
	<h1 class="page-heading"><?php echo $user->getId() ? 'Editing' : 'Creating' ?> user <?php echo $user->getNameFull() ? $user->getEmail() : $user->getId() ?></h1>
	<form class="main" method="post" enctype="multipart/form-data">
	    <div class="block-margins">
        	<label class="form-user-label-title" for="form-user-name-first">First Name</label>
        	<input id="form-user-name-first" class="required js-input-name-first" type="text" name="user[nameFirst]" maxlength="75" value="<?php echo $user->getNameFirst() ?>" autofocus="autofocus">
        	<label class="form-user-label-title" for="form-user-name-last">last Name</label>
        	<input id="form-user-name-last" class="required js-input-name-last" type="text" name="user[nameLast]" maxlength="75" value="<?php echo $user->getNameLast() ?>">
	    </div>
	    <div class="block-margins">
        	<label class="form-user-label-title" for="form-user-email">Email</label>
        	<input id="form-user-email" class="required js-input-email" type="text" name="user[email]" maxlength="75" value="<?php echo $user->getEmail() ?>">
	    </div>
	    <div class="block-margins">
        	<label class="form-user-label-title" for="form-user-password">New Password</label>
        	<input id="form-user-password" class="required js-input-password" type="text" name="user[password]" maxlength="75" value="">
	    </div>
	    <div class="block-margins">
        	<label class="form-user-label-title" for="form-user-level">Level</label>
        	<input id="form-user-level" class="required js-input-level" type="text" name="user[level]" maxlength="75" value="<?php echo $user->getLevel() ?>">
	    </div>
		<div class="block-clear">
            <button type="submit" class="form-user-button-save">Save</button>
		</div>
	</form>
</div>

<?php include $this->getTemplatePath('admin/_footer') ?>
