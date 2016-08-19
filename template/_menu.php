<?php if (!empty($menu)): ?>
	
<nav class="menu">

	<?php foreach ($menu as $menuItem): ?>

	<a href="<?php echo $url->generate() . $menuItem->url ?>" class="menu-item"><?php echo $menuItem->name ?></a>

	<?php endforeach ?>

    <a href="http://www.pinterest.com/clmruth26/" class="header-social menu-item" target="_blank">
        <span class="header-social-icon"><?php include $this->getPathBase('asset/pinterest.svg') ?></span>
        <span class="header-social-title">Pinterest</span>
    </a>
</nav>

<?php endif ?>
