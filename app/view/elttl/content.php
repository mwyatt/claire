<?php include($this->pathView('_header')) ?>

<div class="page <?php echo $firstContent->type ?>">

<?php include($this->pathView('_pagination')) ?>
<?php include($this->pathView('_contents')) ?>
<?php include($this->pathView('_pagination')) ?>

</div>

<?php include($this->pathView('_footer')) ?>
