<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title><?php echo empty($metaTitle) ? '' : $metaTitle ?></title>

<?php if (!empty($metaKeywords)) : ?>
	
<meta name="keywords" content="<?php echo $metaKeywords ?>">

<?php endif ?>
<?php if (!empty($metaDescription)) : ?>
	
<meta name="description" content="<?php echo $metaDescription ?>">

<?php endif ?>

<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
