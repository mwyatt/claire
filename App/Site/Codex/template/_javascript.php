<?php $html = file_get_contents(SITE_PATH . 'js/browserify-example.js') ?>

<div class="typography">
	<p>All js which is not specific to a particular page should be split into packages which can be required. Here will be a list of all packages which are mostly universal across projects.</p>
	<p>Below is an example of what the modules should include to work with browserify.</p>
</div>
<pre class="rainbow-pre"><code data-language="js"><?php echo htmlentities($html) ?></code></pre>
