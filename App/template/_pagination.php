<?php if ($pagination): ?>
	<?php if (($pagination->data->previous || $pagination->data->pages || $pagination->data->next) && $pagination->getSummary()): ?>

<div class="pagination clearfix">
	<a href="<?php echo $pagination->data->previous ? $pagination->data->previous->url : '#' ?>" class="pagination-item pagination-previous <?php echo $pagination->data->previous ? '' : 'is-disabled' ?>">
		<span class="pagination-text pagination-previous-text">Previous</span>
	</a>
	
		<?php foreach ($pagination->data->pages as $index => $page): ?>

	<a href="<?php echo $page->url ?>" class="pagination-item pagination-page <?php echo $page->current ? 'is-current' : '' ?>"><?php echo $index ?></a>

		<?php endforeach ?>
		
	<a href="<?php echo $pagination->data->next ? $pagination->data->next->url : '#' ?>" class="pagination-item pagination-next <?php echo $pagination->data->next ? '' : 'is-disabled' ?>">
		<span class="pagination-text pagination-next-text">Next</span>
	</a>
	<h3 class="pagination-summary"><?php echo ucfirst($pagination->getSummary()) ?></h3>
</div>

	<?php endif ?>
<?php endif ?>
