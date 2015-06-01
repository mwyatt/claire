<?php include $this->getTemplatePath('admin/_header') ?>

<div class="page">
	<form method="post" action="" class="form-login">
        <label class="form-label block forgot-password-label" for="forgot-password-email">Email Address</label>
        <span id="forgot-password-email" class="forgot-password-email block-margins block"><?php echo $userEmail ?></span>
        <label class="form-label block forgot-password-label" for="forgot-password-new-password">New Password</label>
        <input id="forgot-password-new-password" class="form-input login-form-input w100 forgot-password-input" type="password" name="password" required>
        <label class="form-label block forgot-password-label" for="forgot-password-confirm-password">Confirm New Password</label>
        <input id="forgot-password-confirm-password" class="form-input login-form-input w100 forgot-password-input" type="password" name="password_confirm" required>
        <button type="submit" class="button-primary mt1 right button-forgot-password-confirm js-form-forgot-password-submit">Confirm</button>
    </form>
</div>

<?php include $this->getTemplatePath('admin/_footer') ?>
