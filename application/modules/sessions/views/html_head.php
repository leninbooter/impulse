<!DOCTYPE html  style="height: 100%">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        
        <?= isset($commonCssFiles) ? $commonCssFiles : '' ?>
		<?= isset($extraCssFiles) ? $extraCssFiles:''?>
        
        <title><?=isset($pageTitle) ? $pageTitle:''?></title>
	</head>
    <body style="padding:0px; height: 100%">