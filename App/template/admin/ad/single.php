<?php include $this->getTemplatePath('admin/_header') ?>

<div class="page ad-single" data-id="<?php echo $ad->getId() ?>">
	<h1 class="page-primary-title"><?php echo $ad->id ? 'Editing' : 'Creating' ?> ad <?php echo $ad->title ? $ad->email : $ad->id ?></h1>
	<form class="main" method="post" enctype="multipart/form-data">
		<div class="page-actions">
			<a href="<?php echo $this->url->generate('admin/ad/all') ?>" class="page-action left button-secondary">Back</a>
			<button type="submit" class="form-ad-button-save page-action button-primary right">Save</button>
		</div>

		<!-- title -->
	    <div class="block-margins">
        	<label class="form-label block form-ad-label-title" for="form-ad-title">Title</label>
        	<input id="form-ad-title" class="form-input w100 required js-input-title" type="text" name="ad[title]" maxlength="75" value="<?php echo $ad->title ?>">
	    </div>

		<!-- description -->
	    <div class="block-margins">
        	<label class="form-label block form-ad-label-title" for="form-ad-description">Description</label>
        	<input id="form-ad-description" class="form-input w100 required js-input-description" type="text" name="ad[description]" maxlength="75" value="<?php echo $ad->description ?>">
	    </div>

		<!-- image -->
	    <div class="block-margins">
        	<label class="form-label block form-ad-label-title" for="form-ad-image">Image</label>
        	<input id="form-ad-image" class="form-input w100 required js-input-image" type="text" name="ad[image]" maxlength="75" value="<?php echo $ad->image ?>">
	    </div>

		<!-- url -->
	    <div class="block-margins">
        	<label class="form-label block form-ad-label-title" for="form-ad-url">Url</label>
        	<input id="form-ad-url" class="form-input w100 required js-input-url" type="text" name="ad[url]" maxlength="75" value="<?php echo $ad->url ?>">
	    </div>

		<!-- action -->
	    <div class="block-margins">
        	<label class="form-label block form-ad-label-title" for="form-ad-action">Action</label>
        	<input id="form-ad-action" class="form-input w100 required js-input-action" type="text" name="ad[action]" maxlength="75" value="<?php echo $ad->action ?>">
	    </div>

		<!-- group -->
	    <div class="block-margins">
        	<label class="form-label block form-ad-label-title" for="form-ad-group">Group</label>
        	<input id="form-ad-group" class="form-input w100 required js-input-group" type="text" name="ad[group]" maxlength="75" value="<?php echo $ad->group ?>">
	    </div>

	    <!-- status -->
		<div class="block-margins">
			<label for="form-label block form-ad-label-status" class="form-ad-status">Status</label>
			<select name="ad[status]" id="form-ad-status">
				
<?php foreach ($ad->getStatuses() as $key => $status): ?>
	
				<option value="<?php echo $key ?>" <?php echo $ad->status == $key ? 'selected' : '' ?>><?php echo $status ?></option>

<?php endforeach ?>

			</select>
		</div>

	</form>
</div>

<?php include $this->getTemplatePath('admin/_footer') ?>
