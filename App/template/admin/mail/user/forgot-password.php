<?php include $this->getTemplatePath('mail/_header') ?>

<h1 style="{h1}">Password Recovery</h1>
<p style="{p}">To choose a new password, please click the following link and follow the instructions.</p>
<p style="{p}"><a style="{a}" href="<?php echo $urlRecovery ?>"><?php echo $urlRecovery ?></a></p>

<?php include $this->getTemplatePath('mail/_footer') ?>
