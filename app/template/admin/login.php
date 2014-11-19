<?php require_once($this->getTemplatePath('admin/_header')) ?>
<?php require_once($this->getTemplatePath('_logo')) ?>

<div class="content page login">
	<form method="post" action="">

<?php require_once($this->getTemplatePath('_feedback')) ?>

        <label class="login-label" for="login_email">Username</label>
        <input id="login_email" class="login-input" type="text" name="login_email" autofocus="autofocus" value="<?php echo $this->get('login_email', $sessionFormfield) ?>">
        <label class="login-label" for="login_password">Password</label>
        <input id="login_password" class="login-input" type="password" name="login_password">
        <input type="hidden" name="login" value="true">
        <input type="submit">
        <span class="submit button login-button js-form-button-submit">Login</span>
    </form>
</div>

<?php require_once($this->getTemplatePath('admin/_footer')) ?>
