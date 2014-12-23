<?php include $this->getTemplatePath('admin/_header') ?>

<div class="page login">

<?php include $this->getTemplatePath('_logo') ?>

	<form method="post" action="" class="form-login">

<?php include $this->getTemplatePath('_feedback') ?>

        <label class="login-label" for="login-email">Email</label>
        <input id="login-email" class="login-input" type="text" name="email" autofocus="autofocus" value="<?php echo $sessionForm['admin\login']['email'] ?>" required>
        <label class="login-label" for="login-password">Password</label>
        <input id="login-password" class="login-input" type="password" name="password" required>
        <input type="hidden" name="login" value="true">
        <span class="submit button login-button js-form-button-submit">Login</span>
        <input type="submit">
        <a href="#js-lightbox-forgot-password" class="link-forgot-password js-magnific-inline">Forgot Password?</a>
    </form>
    <div id="js-lightbox-forgot-password" class="mfp-hide">
        <h2>Forgot Password</h2>
        <form action="" method="post">
            <label class="login-label" for="login-email">Email</label>
            <input id="login-email" class="login-input" type="text" name="email" autofocus="autofocus" value="" required>
            <span class="submit button login-button js-form-button-submit">Reset</span>
        </form>
    </div>
</div>

<?php include $this->getTemplatePath('admin/_footer') ?>
