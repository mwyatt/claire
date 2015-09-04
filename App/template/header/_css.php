<?php if (isset($asset['css'])) : ?>
	<?php foreach ($asset['css'] as $path) : ?>
		
<link href="<?php echo $this->getUrlAsset($path . '.css') ?>" media="screen, projection, print" rel="stylesheet" type="text/css" />
		
	<?php
endforeach ?>
<?php endif ?>
