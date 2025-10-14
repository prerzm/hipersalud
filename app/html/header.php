<!DOCTYPE html>
<html lang="es-MX">
	<head>
		<meta charset="utf-8">
		<title>Proyecto DM</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">

		<!-- Favicon -->
		<link rel="icon" type="image/png" sizes="192x192"  href="favicon/favicon-192x192.png">
		<?php /*
		<link rel="apple-touch-icon" sizes="57x57" href="favicon/apple-icon-57x57.png">
		<link rel="apple-touch-icon" sizes="60x60" href="favicon/apple-icon-60x60.png">
		<link rel="apple-touch-icon" sizes="72x72" href="favicon/apple-icon-72x72.png">
		<link rel="apple-touch-icon" sizes="76x76" href="favicon/apple-icon-76x76.png">
		<link rel="apple-touch-icon" sizes="114x114" href="favicon/apple-icon-114x114.png">
		<link rel="apple-touch-icon" sizes="120x120" href="favicon/apple-icon-120x120.png">
		<link rel="apple-touch-icon" sizes="144x144" href="favicon/apple-icon-144x144.png">
		<link rel="apple-touch-icon" sizes="152x152" href="favicon/apple-icon-152x152.png">
		<link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-icon-180x180.png">
		<link rel="icon" type="image/png" sizes="192x192"  href="favicon/android-icon-192x192.png">
		<link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="96x96" href="favicon/favicon-96x96.png">
		<link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
		<link rel="manifest" href="favicon/manifest.json">
		<meta name="msapplication-TileColor" content="#ffffff">
		<meta name="msapplication-TileImage" content="favicon/ms-icon-144x144.png">
		<meta name="theme-color" content="#ffffff">
		*/ ?>

		<!-- Styles -->
		<link href="./css/bootstrap.css" rel="stylesheet">
		<link href="./css/bootstrap-responsive.css" rel="stylesheet">
		<link href="./css/bootstrap-overrides.css" rel="stylesheet">

		<link href="./css/ui-lightness/jquery-ui-1.8.21.custom.css" rel="stylesheet">
		<link href="./js/plugins/datatables/DT_bootstrap.css" rel="stylesheet">
		<link href="./js/plugins/responsive-tables/responsive-tables.css" rel="stylesheet">
		<link href="./js/plugins/timepicker/jquery.ui.timepicker.css" rel="stylesheet">

		<link href="./css/slate.css" rel="stylesheet">
		<link href="./css/slate-responsive.css" rel="stylesheet">

		<link href="./js/plugins/lightbox/themes/evolution-dark/jquery.lightbox.css" rel="stylesheet">

		<link href="./css/bullsharks.css" rel="stylesheet">

		<!-- Javascript -->
		<script src="./js/jquery-1.7.2.min.js"></script>
		<script src="./js/jquery-ui-1.8.21.custom.min.js"></script>
		<script src="./js/jquery.ui.touch-punch.min.js"></script>
		<script src="./js/bootstrap.js"></script>
		<script src="./js/Slate.js"></script>

		<script src="./js/plugins/responsive-tables/responsive-tables.js"></script>
		<script src="./js/plugins/datatables/jquery.dataTables.js"></script>
		<script src="./js/plugins/datatables/DT_bootstrap.js"></script>
		<script src="./js/plugins/validate/jquery.validate.js"></script>
		<script src="./js/plugins/timepicker/jquery.ui.timepicker.min.js"></script>

		<script src="./js/plugins/lightbox/jquery.lightbox.js"></script>

		<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		<script src="https://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

	</head>

<body>

<div id="header">
	
	<div class="container">
		
		<h1 style="color:#eaeaea;text-shadow: 2px 1px #263849;">Proyecto DM</h1>
		
		<div id="info">
			
			<a href="javascript:;" id="info-trigger">
				<i class="icon-cog"></i>
			</a>
			
			<div id="info-menu">
				
				<?php if(Login::logged()) { ?>
					<div class="info-details">
						<h4><?=Session::get_safe("name");?></h4>
					</div> <!-- /.info-details -->
				<?php } ?>
				
			</div> <!-- /#info-menu -->
			
		</div> <!-- /#info -->
		
	</div> <!-- /.container -->

</div> <!-- /#header -->


<div id="nav">
		
	<div class="container">
		
		<a href="javascript:;" class="btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
			<i class="icon-reorder"></i>
		</a>
		
		<div class="nav-collapse">
			
			<ul class="nav">
		
				<li class="nav-icon active">
					<a href="./">
						<i class="icon-home"></i>
						<span>Inicio</span>
					</a>
				</li>

				<?php if($global_menu) { ?>
					<?php foreach($global_menu as $m) { ?>
						<li class="dropdown">
							<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
								<i class="<?=$m['menuIcon'];?>"></i>
								<?=$m['menuParentName'];?>
								<b class="caret"></b>
							</a>
							<?php if($m['modules']) { ?>
								<ul class="dropdown-menu">
									<?php foreach($m['modules'] as $f) { ?>
										<li><a href="./?mod=<?=ps($f['moduloKey']);?>"><?=$f['modulo'];?></a></li>
									<?php } ?>
								</ul>
							<?php } ?>
						</li>
					<?php } ?>
				<?php } ?>

				<?php if(Login::logged()) { ?>
				<li>
					<a href="./?mod=<?=ps('log');?>&cmd=<?=ps('logout');?>">
						<i class="icon-off"></i>
						<?=LABEL_MENU_LOGOUT;?>
					</a>
				</li>
				<?php } ?>
				
			</ul>
			
		</div> <!-- /.nav-collapse -->
		
	</div> <!-- /.container -->
	
</div> <!-- /#nav -->
