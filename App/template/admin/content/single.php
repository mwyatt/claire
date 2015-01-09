<?php include $this->getTemplatePath('admin/_header') ?>

<div class="page content-single" data-id="<?php echo $content->getId() ?>">
	<div class="page-actions">
		<a href="<?php echo $this->getUrl('adminContentAll', ['type' => $content->getType()]) ?>" class="page-action-button">Back</a>

<?php if ($content->getStatusText() == 'Published'): ?>
	
		<a href="<?php echo $this->getUrl('contentSingle', ['type' => $content->getType(), 'slug' => $content->getSlug()]) ?>" class="button right" target="_blank">View</a>

<?php endif ?>

	</div>
	<h1 class="page-heading">Editing <?php echo ucfirst($content->getType()) ?> <?php echo $content->getTitle() ? $content->getTitle() : $content->getId() ?></h1>
	<form class="main" method="post" enctype="multipart/form-data">
	    <div class="block-margins">
        	<label class="form-content-label-title" for="form-content-title">Title</label>
        	<input id="form-content-title" class="required js-input-title" type="text" name="content[title]" maxlength="75" value="<?php echo $content->getTitle() ?>" autofocus="autofocus">
	    </div>
	    <div class="block-margins">
        	<label class="form-content-label-title" for="form-content-slug">Slug</label>
        	<input id="form-content-slug" class="required js-input-slug" type="text" name="content[slug]" maxlength="75" value="<?php echo $content->getSlug() ?>" autofocus="autofocus">
	    </div>
	    <div class="block-margins">
        	<label class="form-content-label-title" for="form-content-html">Html</label>
        	<textarea name="content[html]" id="form-content-html" class="js-tinymce" cols="30" rows="10"><?php echo $content->getHtml() ?></textarea>
	    </div>

<?php //include($this->getTemplatePath('admin/content/_wysihtml5')) ?>

		<div class="block-margins hidden">
			<h2 class="form-content-label-title">Media</h2>

<?php //$media = $content->getMedia() ?>
<?php //include($this->getTemplatePath('admin/media/_browser')) ?>

		</div>
		<div class="block-margins">
			<label for="form-content-status" class="form-content-label-title">Status</label>
			<select name="content[status]" id="form-content-status">
				
<?php foreach ($content->getStatuses() as $key => $status): ?>
	
				<option value="<?php echo $key ?>" <?php echo $content->getStatus() == $key ? 'selected' : '' ?>><?php echo $status ?></option>

<?php endforeach ?>

			</select>
		</div>
		<div class="block-clear">
            <button type="submit" class="form-content-button-save">Save</button>
		</div>
	</form>
</div>

<?php include $this->getTemplatePath('admin/_footer') ?>
