<?php include $this->getTemplatePath('admin/_header') ?>

<div class="page login">

<?php // include $this->getTemplatePath('_logo') ?>

	<form method="post" action="" class="form-login">
        <label class="label-block" for="login-email">Email</label>
        <input id="login-email" class="input-text" type="text" name="email" autofocus="autofocus" value="<?php echo $sessionForm['email'] ?>" required>
        <label class="label-block" for="login-password">Password</label>
        <input id="login-password" class="input-text" type="password" name="password" required>
        <input type="hidden" name="login" value="true">
        <button type="submit" class="button-login">Login</button>
        <a href="#js-lightbox-forgot-password" class="link-forgot-password js-magnific-inline">Forgot Password?</a>
    </form>
    <div id="js-lightbox-forgot-password" class="mfp-hide">
        <h2>Forgot Password</h2>
        <form action="" method="post" class="form-forgot-password js-form-forgot-password">
            <label class="label-block" for="login-email">Email</label>
            <input id="login-email" class="input-text" type="text" name="email" autofocus="autofocus" value="<?php echo $sessionForm['email'] ?>" required>
            <button type="submit" class="button-password-reset js-form-forgot-password-submit">Reset Password</button>
        </form>
    </div>
</div>

<?php include $this->getTemplatePath('admin/_footer') ?>
