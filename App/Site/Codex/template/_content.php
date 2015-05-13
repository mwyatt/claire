<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Codex</title>
	<link href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800" rel="stylesheet" type="text/css">
	<link href="<?php echo $this->getUrlAsset('common.css') ?>" media="screen, projection, print" rel="stylesheet" type="text/css" />
	<link href="<?php echo $this->getUrlAsset('vendor/rainbow/theme/github.css') ?>" media="screen, projection, print" rel="stylesheet" type="text/css" />
</head>
<body>
	<div class="container">
		<h1 class="site-heading">Codex</h1>
		<div class="menu-container">
			<nav class="menu-primary">
				<ul>
	
<?php foreach ($structure as $headingPrimary => $secondary): ?>
	
					<li class="menu-primary-item"><a href="#<?php echo $headingPrimary ?>" class="menu-primary-item-link"><?php echo $headingPrimary ?></a></li>

<?php endforeach ?>

				</ul>
			</nav>
		</div>
		<div class="content-container">
			<h1 class="heading-primary">Introduction</h1>
			<p class="p">The codex is a home for the css and js boilerplate. This has been built so that it can be 'plugged in' to an existing / new project easily.</p>
			<p class="p">The '_dependencies.scss' file can be imported with zero css output. Filled with mixins and placeholders.</p>
			<pre class="rainbow-pre"><code data-language="css">@import "dependencies";</code></pre>

			
	
<?php foreach ($structure as $headingPrimary => $secondary): ?>

			<div id="<?php echo $headingPrimary ?>" class="container-primary">
				<h1 class="heading-primary"><?php echo $headingPrimary ?></h1>

	<?php include $this->getTemplatePath('_' . $headingPrimary) ?>
	<?php foreach ($secondary as $headingSecondary): ?>

				<div class="container-secondary">
					<h2 class="heading-secondary"><?php echo $headingSecondary ?></h2>

		<?php $pathCode = SITE_PATH . 'template/code/' . $headingPrimary . '/_' . $headingSecondary . '.html' ?>
		<?php if (file_exists($pathCode)): ?>
			<?php $html = file_get_contents($pathCode) ?>
		<?php else: ?>
			<?php unset($html) ?>
		<?php endif ?>
		<?php include $this->getTemplatePath($headingPrimary . '/_' . $headingSecondary) ?>

				</div>

	<?php endforeach ?>

			</div>

<?php endforeach ?>

		</div>
	</div>
    <script src="<?php echo $this->getUrlAsset('vendor/rainbow.min.js') ?>"></script>
	<script src="<?php echo $this->getUrlAsset('vendor/rainbow/language/generic.js') ?>"></script>
	<script src="<?php echo $this->getUrlAsset('vendor/rainbow/language/html.js') ?>"></script>
	<script src="<?php echo $this->getUrlAsset('vendor/rainbow/language/css.js') ?>"></script>
    <script>var urlBase = '<?php echo $this->url->generate() ?>';</script>
	<script>var url;</script>
    <script src="<?php echo $this->getUrlAsset('common.js') ?>"></script>
</body>
</html>
