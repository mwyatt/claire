<?php if (!empty($division) && !empty($year)) : ?>

<a href="<?php echo $this->url->generate('result/year/division/single', ['yearName' => $year->name, 'divisionName' => strtolower($division->name)]) ?>" class="division">
	<img class="division-image" src="<?php echo $this->getAssetPath('trophy.svg') ?>" onerror="this.src=''; this.onerror=null;">
	<span class="division-name"><?php echo $division->name ?></span>
</a>

<?php endif ?>
