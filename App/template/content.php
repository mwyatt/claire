<?php include $this->getTemplatePath('_header') ?>

<div class="page <?php echo $contentSingle->getType() ?>">

<?php include($this->getTemplatePath('_pagination')) ?>
<?php include($this->getTemplatePath('_contents')) ?>
<?php include($this->getTemplatePath('_pagination')) ?>

</div>

<?php include $this->getTemplatePath('_footer') ?>
