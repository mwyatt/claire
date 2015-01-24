<?php if (isset($adminUser)): ?>
	<?php $urlSingle = $this->getUrl('adminUserSingle', ['id' => $adminUser->getId()]) ?>
    
<div class="nav-user js-hover-addclass nav-main-level1">
	<span class="nav-user-gravatar"><img src="<?php echo $adminUser->getUrlGravatar(['s' => 30, 'd' => 'mm', 'r' => 'g', 'img' => false]) ?>" alt="" class="nav-user-gravatar-image"></span>
    <a class="nav-user-name ellipsis" href="<?php echo $urlSingle ?>" class="name js-hover-addclass-trigger"><?php echo ($adminUser->getNameFirst() ? $adminUser->getNameFirst() . ' ' . $adminUser->getNameLast() : $adminUser->getEmail()) ?></a>
    <div class="drop nav-user-drop js-hover-addclass-drop nav-main-level1-drop">
        <a class="nav-user-drop-link nav-main-level2-link" href="<?php echo $urlSingle ?>">Profile</a>
        <a class="nav-user-drop-link nav-main-level2-link" href="?logout=yes">Logout</a>
    </div>
</div>

<?php endif ?>
