<?php include $this->getTemplatePath('admin/_header') ?>

<div class="page login">

<?php // include $this->getTemplatePath('_logo') ?>

	<form method="post" action="">
        <label class="form-label block" for="login-email">Email</label>
        <input id="login-email" class="login-form-input form-input w100" type="text" name="email" autofocus="autofocus" value="<?php echo $sessionForm['email'] ?>" required>
        <label class="form-label block" for="login-password">Password</label>
        <input id="login-password" class="login-form-input form-input w100" type="password" name="password" required>
        <input type="hidden" name="login" value="true">
        <button type="submit" class="button-primary right">Login</button>
        <a href="#js-lightbox-forgot-password" class="link-secondary js-magnific-inline">Forgot Password?</a>
    </form>
    <div id="js-lightbox-forgot-password" class="mfp-hide">
        <h2 class="h2 lightbox-forgot-password-heading">Forgot Password</h2>
        <form action="" method="post" class="form-forgot-password js-form-forgot-password">
            <label class="form-label block" for="login-email">Email</label>
            <input id="login-email" class="login-form-input form-input w100" type="text" name="email" autofocus="autofocus" value="<?php echo $sessionForm['email'] ?>" required>
            <button type="submit" class="button-primary right js-form-forgot-password-submit">Reset Password</button>
        </form>
    </div>
</div>

<?php include $this->getTemplatePath('admin/_footer') ?>
