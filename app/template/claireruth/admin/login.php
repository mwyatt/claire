<?php require_once($this->getTemplatePath('admin/_header')) ?>
<?php require_once($this->getTemplatePath('_logo')) ?>

	<form method="post" action="">

<?php $feedback = $sessionFeedback ?>
<?php require_once($this->getTemplatePath('_feedback')) ?>

        <label class="login-label" for="login_email">Email Address</label>
        <input id="login_email" class="login-input" type="text" name="login_email" autofocus="autofocus" value="<?php echo $this->get('login_email', $sessionFormfield) ?>">
        <label class="login-label" for="login_password">Password</label>
        <input id="login_password" class="login-input" type="password" name="login_password">
        <input type="hidden" name="login" value="true">
        <input type="submit">
        <a href="#" class="submit button login-button">Login</a>
    </form>
</div>

<?php require_once($this->getTemplatePath('admin/_footer')) ?>
