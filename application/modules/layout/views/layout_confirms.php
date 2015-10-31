<!doctype html>

<!--[if lt IE 7]>
<html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>
<html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>
<html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en"> <!--<![endif]-->

<head>
    <title></title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="robots" content="NOINDEX,NOFOLLOW">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/jquery-ui-1.11.4.custom/jquery-ui.min.css')?>">
    <link rel="stylesheet" href="<?= base_url('assets/bootstrap-3.3.5-dist/css/bootstrap.min.css')?>">    
    <link href="<?=base_url('assets/AdminLTE-2.2.0/dist/css/AdminLTE.min.css')?>" rel="stylesheet" type="text/css">
    <link href="<?=base_url('assets/AdminLTE-2.2.0/dist/css/skins/skin-blue.min.css')?>" rel="stylesheet" type="text/css">
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <?php if(isset($custom_css)): ?>
        <?php foreach($custom_css as $file): ?>
            <link href="<?=$file?>" rel="stylesheet">		
        <?php endforeach; ?>
    <?php endif; ?>    
    
    <!-- Latest compiled and minified JavaScript -->
    <script src="<?= base_url('assets/jquery-1.11.3.min.js')?>"></script>
    <script src="<?= base_url('assets/jquery-ui-1.11.4.custom/jquery-ui.min.js')?>"></script>    
    <script src="<?= base_url('assets/bootstrap-3.3.5-dist/js/bootstrap.min.js')?>"></script>    
    <script src="<?= base_url('assets/AdminLTE-2.2.0/dist/js/app.min.js')?>"></script>
    <?php if(isset($custom_js)): ?>
        <?php foreach($custom_js as $file): ?>
            <script src="<?=$file?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>

</head>

<body class="skin-blue sidebar-mini layout-top-nav">
    <div class="wrapper">                
        
        <div class="content-wrapper">                  
            <?= $content ?>
        </div>        
    </div>
</body>
</html>
