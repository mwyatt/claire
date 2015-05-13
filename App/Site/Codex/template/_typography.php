<?php $html = file_get_contents(SITE_PATH . 'template/code/_typography.html') ?>

<div class="typography">
	<p>Encapsulates all loose typography and styles accordingly.</p>
</div>
<div class="example-code"><?php echo $html ?></div>
<pre class="rainbow-pre"><code data-language="html"><?php echo htmlentities($html) ?></code></pre>
