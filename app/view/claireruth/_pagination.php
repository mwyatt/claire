<?php if ($pagination): ?>
	<?php if (($pagination->previous || $pagination->pages || $pagination->next) && $paginationSummary): ?>

<div class="pagination clearfix">
	<a href="<?php echo $pagination->previous ? $pagination->previous->url : '#' ?>" class="pagination-item pagination-previous <?php echo $pagination->previous ? '' : 'is-disabled' ?>">
		<span class="pagination-icon pagination-previous-icon"><?php include($this->getPathMedia('arrow-circled.svg')) ?></span>
		<span class="pagination-text pagination-previous-text">Previous</span>
	</a>
	
		<?php foreach ($pagination->pages as $index => $page): ?>

	<a href="<?php echo $page->url ?>" class="pagination-item pagination-page <?php echo $page->current ? 'is-current' : '' ?>"><?php echo $index ?></a>

		<?php endforeach ?>
		
	<a href="<?php echo $pagination->next ? $pagination->next->url : '#' ?>" class="pagination-item pagination-next <?php echo $pagination->next ? '' : 'is-disabled' ?>">
		<span class="pagination-icon pagination-next-icon"><?php include($this->getPathMedia('arrow-circled.svg')) ?></span>
		<span class="pagination-text pagination-next-text">Next</span>
	</a>
	<h3 class="pagination-summary"><?php echo ucfirst($paginationSummary) ?></h3>
</div>

	<?php endif ?>
<?php endif ?>
