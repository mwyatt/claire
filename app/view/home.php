<?php require_once('header.php'); ?>

	<div class="sixteen columns">
	
		<div class="flexslider">
		
			<?php if ($ads->getResult()) : ?>
			<ul class="slides">
				<?php while ($ads->nextRow()) : ?>
				<li style="background: url('http://placehold.it/200x200') 0 50% no-repeat">
					<a href="<?php echo $ads->getRow('target'); ?>" target="<?php echo $url_target; ?>">
						<h2><?php echo $ads->getRow('title'); ?></h2>
					</a>
				</li>
				<?php endwhile; ?>
			</ul>
			<?php endif; ?>
			
		</div>	
		
	</div>		

	<div id="projects" class="six columns">
	
		<h3>Projects</h3>
		<?php if ($projects->getResult()) : ?>
		<ul>
			<?php while ($projects->nextRow()) : ?>
			<li>
				<a href="<?php echo $projects->getRow('guid'); ?>" title="Open Project <?php echo $projects->getRow('title'); ?>" alt="Open Project <?php echo $title; ?>"><img src="http://placehold.it/300x160"></a>
			</li>
			<?php endwhile; ?>
		</ul>
		<?php endif; ?>
		
	</div>	
	
	<div id="posts" class="ten columns">
	
		<h3>Stream</h3>
		<?php if ($posts->getResult()) : ?>
		<ul>
			<?php while ($posts->nextRow()) : ?>
			<li>
				<a href="<?php echo $posts->getRow('guid'); ?>"><?php echo $posts->getRow('title'); ?></a>
			</li>
			<?php endwhile; ?>
		</ul>
		<?php endif; ?>		
		
	</div>	
	
	<div class="clearfix"></div>

<?php require_once('footer.php'); ?>