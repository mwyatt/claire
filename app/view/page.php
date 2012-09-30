<?php require_once('header.php'); ?>

	<div class="sixteen columns">
	
<?php if ($content->getResult()) : foreach ($content->getResult() as $content) : extract($content); ?>

		<article class="<?php echo $title_slug; ?>">
		
			<header>

				<h1><?php echo $title; ?></h1>
				
			</header>
			
			<section class="page_content clearfix">

				<?php echo $html; ?>
				
			</header>

			<footer>

				<p class="date"><?php echo $date_published; ?></p>
				<p class="tags"><?php echo $tags; ?></p>
				
			</footer>
			
		</article>
			
<?php endforeach; endif; ?>

	</div> <!-- / .sixteen.columns -->
	
<?php require_once('footer.php'); ?>