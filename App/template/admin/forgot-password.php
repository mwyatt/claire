<?php include $this->getTemplatePath('admin/_header') ?>

<div class="page forgot-password">
	<form method="post" action="" class="form-forgot-password">
        <label class="forgot-password-label" for="forgot-password-email">Email</label>
        <span id="forgot-password-email" class="forgot-password-input"><?php echo $userEmail ?></span>
        <label class="forgot-password-label" for="forgot-password-new-password">New Password</label>
        <input id="forgot-password-new-password" class="forgot-password-input" type="password" name="password" required>
        <label class="forgot-password-label" for="forgot-password-confirm-password">Confirm New Password</label>
        <input id="forgot-password-confirm-password" class="forgot-password-input" type="password" name="password_confirm" required>
        <button type="submit" class="button-forgot-password-confirm js-form-forgot-password-submit">Confirm</button>
    </form>
</div>

<?php include $this->getTemplatePath('admin/_footer') ?>
