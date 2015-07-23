<?php include $this->getTemplatePath('admin/_header') ?>

<div class="page">
	<h1 class="page-primary-title"><?php echo $$nameSingular->id ? 'Editing' : 'Creating' ?> <?php echo $nameSingular ?> <?php echo $$nameSingular->name ?></h1>
	<form class="main" method="post" enctype="multipart/form-data">
		<div class="page-actions">
			<a href="<?php echo $this->url->generate('admin/tennis/' . $nameSingular . '/all') ?>" class="page-action left button-secondary">Back</a>

<?php if ($$nameSingular->id) : ?>

			<span class="page-action button-secondary left js-tennis-delete-single" data-singular="<?php echo $nameSingular ?>" data-id="<?php echo $$nameSingular->id ?>">Delete</span>

<?php endif ?>

			<button type="submit" class="form-user-button-save page-action button-primary right">Save</button>
		</div>
	    <div class="block-margins">
        	<label class="form-label block" for="form-name">Name</label>
        	<input id="form-name" class="form-input w100" type="text" name="entity[name]" maxlength="75" value="<?php echo $$nameSingular->name ?>" autofocus="autofocus" required>
	    </div>
	    <div class="block-margins">
        	<label class="form-label block" for="form-slug">Slug</label>
        	<input id="form-slug" class="form-input w100" type="text" name="entity[slug]" maxlength="75" value="<?php echo $$nameSingular->slug ?>" required>
	    </div>
	    <div class="block-margins">
        	<label class="form-label block" for="form-home-weekday">Home night</label>
			<select id="form-home-weekday" name="entity[homeWeekday]">

<?php foreach ($weekdays as $weekdayId => $weekday) : ?>
		
				<option value="<?php echo $weekdayId ?>" <?php echo $team->homeWeekday == $weekdayId ? 'selected' : '' ?>><?php echo $weekday ?></option>

<?php endforeach ?>

			</select>
		</div>
	    <div class="block-margins">
        	<label class="form-label block" for="form-secretary">Secretary</label>
			<select id="form-secretary" name="entity[secretaryId]">
				<option value="">None</option>

<?php foreach ($players as $player) : ?>
		
				<option value="<?php echo $player->id ?>" <?php echo $player->id == $team->secretaryId ? 'selected' : '' ?>><?php echo $player->getNameFull() ?></option>

<?php endforeach ?>

			</select>
	    </div>
	    <div class="block-margins">
        	<label class="form-label block" for="form-venue">venue</label>
			<select id="form-venue" name="entity[venueId]">

<?php foreach ($venues as $venue) : ?>
		
				<option value="<?php echo $venue->id ?>" <?php echo $venue->id == $team->venueId ? 'selected' : '' ?>><?php echo $venue->name ?></option>

<?php endforeach ?>

			</select>
	    </div>
	    <div class="block-margins">
        	<label class="form-label block" for="form-division">division</label>
			<select id="form-division" name="entity[divisionId]">

<?php foreach ($divisions as $division) : ?>
		
				<option value="<?php echo $division->id ?>" <?php echo $division->id == $team->divisionId ? 'selected' : '' ?>><?php echo $division->name ?></option>

<?php endforeach ?>

			</select>
	    </div>
	</form>
</div>

<?php include $this->getTemplatePath('admin/_footer') ?>
