<?php if (isset($user)): ?>
    
<div class="nav-user js-hover-addclass nav-main-level1">
	<span class="nav-user-gravatar"><img src="<?php echo $user->getUrlGravatar(['s' => 30, 'd' => 'mm', 'r' => 'g', 'img' => false]) ?>" alt="" class="nav-user-gravatar-image"></span>
    <a class="nav-user-name ellipsis" href="<?php echo $this->getUrl() ?>admin/profile/" class="name js-hover-addclass-trigger"><?php echo ($user->getNameFirst() ? $user->getNameFirst() . ' ' . $user->getNameLast() : $user->getEmail()) ?></a>
    <div class="drop nav-user-drop js-hover-addclass-drop nav-main-level1-drop">
        <a class="nav-user-drop-link nav-main-level2-link" href="<?php echo $this->getUrl() ?>admin/profile/">Profile</a>
        <a class="nav-user-drop-link nav-main-level2-link" href="?logout=yes">Logout</a>
    </div>
</div>

<?php endif ?>
