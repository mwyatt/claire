<?php $html = file_get_contents(SITE_PATH . 'template/code/typography/_lead.html') ?>

<div class="typography">
	<p>Make a paragraph stand out by adding '.lead'.</p>
</div>
<div class="example-code"><?php echo $html ?></div>
<pre class="rainbow-pre"><code data-language="html"><?php echo htmlentities($html) ?></code></pre>
