<?php if (isset($division)) : ?>

<div class="block-clear menu-tables">
	<a href="<?php echo $this->buildArchiveUrl(array('result', $division->getName(), 'league')) ?>" class="menu-tables-option button-primary">League</a>
	<a href="<?php echo $this->buildArchiveUrl(array('result', $division->getName(), 'merit', 'doubles')) ?>" class="menu-tables-option button-primary">Doubles Merit</a>
	<a href="<?php echo $this->buildArchiveUrl(array('result', $division->getName(), 'merit')) ?>" class="menu-tables-option button-primary">Merit</a>
</div>

<?php endif ?>
