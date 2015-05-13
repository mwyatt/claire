<?php $html = file_get_contents(SITE_PATH . 'template/code/buttons/_disabled.html') ?>

<div class="typography">
	<p>Buttons can be disabled using the 'disabled' element attribute. Alternatively using the '.disabled' class.</p>
</div>
<div class="example-code"><?php echo $html ?></div>
<pre class="rainbow-pre"><code data-language="html"><?php echo htmlentities($html) ?></code></pre>
