<?php $html = file_get_contents(SITE_PATH . 'template/code/_form.html') ?>

<div class="typography">
	<p>Use the '.form' class to style up a form using a common theme. Alternatively there are many reusable styles to be used independently.</p>
</div>
<div class="example-code"><?php echo $html ?></div>
<pre class="rainbow-pre"><code data-language="html"><?php echo htmlentities($html) ?></code></pre>
