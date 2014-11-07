<?php include($this->getTemplatePath('_header')) ?>

<div class="page <?php echo $firstContent->type ?>">

<?php include($this->getTemplatePath('_pagination')) ?>
<?php include($this->getTemplatePath('_contents')) ?>
<?php include($this->getTemplatePath('_pagination')) ?>

</div>

<?php include($this->getTemplatePath('_footer')) ?>
