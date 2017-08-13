<?php include $this->getPathTemplate('_header') ?>

<div class="page <?php echo $contentSingle->getType() ?>-all">

<?php include($this->getPathTemplate('_pagination')) ?>
<?php include($this->getPathTemplate('_contents')) ?>
<?php include($this->getPathTemplate('_pagination')) ?>

</div>

<?php include $this->getPathTemplate('_footer') ?>
