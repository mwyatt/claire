<?php include $this->getTemplatePath('admin/_header') ?>

<div class="page content-single js-content-single" data-id="<?php echo $content->getId() ?>">
	<form class="main" method="post" enctype="multipart/form-data">
		<div class="page-actions">
			<a href="<?php echo $this->url->generate('admin/content/all', ['type' => $contentType]) ?>" class="page-action button-secondary left">Back</a>
            <button type="submit" class="page-action button-primary right">Save</button>

<?php if ($content->getStatusText() == 'Published') : ?>
		
			<a href="<?php echo $this->url->generate('content/single', ['type' => $content->getType(), 'slug' => $content->getSlug()]) ?>" class="page-action button-secondary right" target="_blank">View</a>

<?php endif ?>
<?php if ($content->getId()) : ?>
		
			<a class="page-action button-secondary right" href="<?php echo $this->url->generate('admin/content/delete', ['id' => $content->getId()]) ?>">Delete</a>

<?php endif ?>

		</div>
		<h1 class="page-primary-title"><?php echo $content->getId() ? 'Edit' : 'Create' ?> <?php echo ucfirst($contentType) ?></h1>
	    <div class="block-margins">
        	<label class="form-label block" for="form-content-title">Title</label>
        	<input id="form-content-title" class="form-input w100 required js-input-title" type="text" name="content[title]" maxlength="75" value="<?php echo $content->getTitle() ?>" autofocus="autofocus">
	    </div>
	    <div class="block-margins">
        	<label class="form-label block" for="form-content-slug">Slug</label>
        	<input id="form-content-slug" class="form-input w100 required js-input-slug" type="text" name="content[slug]" maxlength="75" value="<?php echo $content->getSlug() ?>">
	    </div>
	    <div class="block-margins">
        	<label class="form-label block" for="form-content-html">Html</label>
        	<textarea name="content[html]" id="form-content-html" class="js-tinymce" cols="30" rows="10"><?php echo $content->getHtml() ?></textarea>
	    </div>
	    <div class="block-margins js-content-meta-container"></div>
		<div class="block-margins hidden">
			<h2 class="form-label block">Media</h2>

<?php //$media = $content->getMedia() ?>
<?php //include($this->getTemplatePath('admin/media/_browser')) ?>

		</div>
		<div class="block-margins">
			<label for="form-content-status" class="form-label block">Status</label>
			<select name="content[status]" id="form-content-status">
				
<?php foreach ($content->getStatuses() as $key => $status) : ?>
	
				<option value="<?php echo $key ?>" <?php echo $content->getStatus() == $key ? 'selected' : '' ?>><?php echo $status ?></option>

<?php endforeach ?>

			</select>
		</div>
	</form>
</div>

<?php include $this->getTemplatePath('admin/_footer') ?>
