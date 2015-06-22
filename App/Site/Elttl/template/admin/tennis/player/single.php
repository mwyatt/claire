<?php include $this->getTemplatePath('admin/_header') ?>

<div class="page">
	<h1 class="page-primary-title"><?php echo $$nameSingular->id ? 'Editing' : 'Creating' ?> <?php echo $nameSingular ?> <?php echo $$nameSingular->nameFirst ?></h1>
	<form class="main" method="post" enctype="multipart/form-data">
		<div class="page-actions">
			<a href="<?php echo $this->url->generate('admin/tennis/' . $nameSingular . '/all') ?>" class="page-action left button-secondary">Back</a>

<?php if ($$nameSingular->id): ?>

			<span class="page-action button-secondary left js-tennis-delete-single" data-singular="<?php echo $nameSingular ?>" data-id="<?php echo $$nameSingular->id ?>">Delete</span>

<?php endif ?>

			<button type="submit" class="form-user-button-save page-action button-primary right">Save</button>
		</div>
	    <div class="block-margins">
        	<label class="form-label block" for="form-name-first">First name</label>
        	<input id="form-name-first" class="form-input w100" type="text" name="entity[nameFirst]" maxlength="75" value="<?php echo $$nameSingular->nameFirst ?>" autofocus="autofocus" required>
	    </div>
	    <div class="block-margins">
        	<label class="form-label block" for="form-name-last">Last name</label>
        	<input id="form-name-last" class="form-input w100" type="text" name="entity[nameLast]" maxlength="75" value="<?php echo $$nameSingular->nameLast ?>" autofocus="autofocus" required>
	    </div>
	    <div class="block-margins">
        	<label class="form-label block" for="form-slug">Slug</label>
        	<input id="form-slug" class="form-input w100" type="text" name="entity[slug]" value="<?php echo $$nameSingular->slug ?>" required>
	    </div>
	    <div class="block-margins">
        	<label class="form-label block" for="form-rank">Rank</label>
        	<input id="form-rank" class="form-input w100" type="text" name="entity[rank]" value="<?php echo $$nameSingular->rank ?>" required>
	    </div>
	    <div class="block-margins">
        	<label class="form-label block" for="form-phoneLandline">Phone landline</label>
        	<input id="form-phoneLandline" class="form-input w100" type="text" name="entity[phoneLandline]" value="<?php echo $$nameSingular->phoneLandline ?>" required>
	    </div>
	    <div class="block-margins">
        	<label class="form-label block" for="form-phoneMobile">Phone mobile</label>
        	<input id="form-phoneMobile" class="form-input w100" type="text" name="entity[phoneMobile]" value="<?php echo $$nameSingular->phoneMobile ?>" required>
	    </div>
	    <div class="block-margins">
        	<label class="form-label block" for="form-ettaLicenseNumber">Phone mobile</label>
        	<input id="form-ettaLicenseNumber" class="form-input w100" type="text" name="entity[ettaLicenseNumber]" value="<?php echo $$nameSingular->ettaLicenseNumber ?>" required>
	    </div>
	    <div class="block-margins">
        	<label class="form-label block" for="form-team">team</label>
			<select id="form-team" name="entity[teamId]">

<?php foreach ($teams as $team): ?>
		
				<option value="<?php echo $team->id ?>" <?php echo $team->id == $$nameSingular->teamId ? 'selected' : '' ?>><?php echo $team->name ?></option>

<?php endforeach ?>

			</select>
	    </div>
	</form>
</div>

<?php include $this->getTemplatePath('admin/_footer') ?>
