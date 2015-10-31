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
    <link href="<?=base_url('assets/font-awesome-4.4.0/css/font-awesome.min.css')?>" rel="stylesheet" type="text/css">
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
        
        <header class="main-header">
          <nav class="navbar navbar-static-top">
            <div class="container-fluid">
            <div class="navbar-header">
              <a href="<?=base_url('index.php/appointments/todayAppointments')?>" class="navbar-brand"><b>I</b>MPULSE</a>
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                <i class="fa fa-bars"></i>
              </button>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="navbar-collapse">
              <ul class="nav navbar-nav">
                    <li ><a href="<?=base_url('index.php/appointments/todayAppointments')?>"><i class="fa fa-home"></i> <span>Inicio</span></a></li>
                    <li ><a href="<?=base_url('index.php/customers/')?>"><i class="fa fa-briefcase"></i> <span>Clientes</span></a></li>
                    <li class="dropdown" >
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-th"></i> <span>Servicios</span> <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="<?=base_url('index.php/services/')?>">Ver</a></li>                            
                            <li><a href="<?=base_url('index.php/services/form')?>">Nuevo</a></li>                            
                          </ul>
                    </li>
                    <li ><a href="<?=base_url('index.php/users/')?>"><i class="fa fa-user"></i></i> <span>Empleados</span></a></li>
                    
                    <li class="dropdown" ><a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-eur"></i></i> <span>Contabilidad</span> <span class="caret"></span></a>
                         <ul class="dropdown-menu" role="menu">
                            <li><a href="<?=base_url('index.php/accounting/')?>">Movimientos de Caja</a></li>                                                       
                          </ul>
                    </li>
                    <li ><a href="<?=base_url('index.php/sessions/end')?>"><i class="fa fa-sign-out"></i> <span>Cerrar sesión</span></a></li>
                    <li ><a href="#">( Usuario: <?=$this->session->user['user_full_name']?> )</a></li>
              </ul>
                            
            </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
          </nav>
        </header>
        
        <div class="content-wrapper">                  
            <?= $content ?>
        </div>        
    </div>
</body>
</html>
