<?php if ($menu) : ?>
	
<div class="menu-secondary-container">
	<nav class="menu-secondary">

	<?php foreach ($menu as $menuItem) : ?>

		<a href="<?php echo $this->url->generate() . $menuItem->url ?>" class="menu-secondary-item"><?php echo $menuItem->name ?></a>

	<?php
endforeach ?>
	
	</nav>
</div>

<?php endif ?>
