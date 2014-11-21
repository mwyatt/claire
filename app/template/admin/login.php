<?php include $this->getTemplatePath('admin/_header') ?>
<?php include $this->getTemplatePath('_logo') ?>

<div class="content page login">
	<form method="post" action="" class="form-login">

<?php include $this->getTemplatePath('_feedback') ?>

        <label class="login-label" for="login-email">Username</label>
        <input id="login-email" class="login-input" type="text" name="email" autofocus="autofocus" value="" required>
        <label class="login-label" for="login-password">Password</label>
        <input id="login-password" class="login-input" type="password" name="password" required>
        <input type="hidden" name="login" value="true">
        <input type="submit">
        <span class="submit button login-button js-form-button-submit">Login</span>
    </form>
</div>

<?php include $this->getTemplatePath('admin/_footer') ?>
