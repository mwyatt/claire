<?php $html = file_get_contents(SITE_PATH . 'js/keyCode.js') ?>

<div class="typography">
	<p>Allows human readable translation for the way javascript interprets keypresses.</p>
</div>
<pre class="rainbow-pre"><code data-language="js"><?php echo htmlentities($html) ?></code></pre>
