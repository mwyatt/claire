<?php if ($fixtures && $fixtureResults && $teams) : ?>
	
<div class="fixtures">

	<?php foreach ($fixtures as $fixture) : ?>
		<?php include($this->getTemplatePath('_fixture')) ?>
	<?php
endforeach ?>
		
</div>

<?php endif ?>
