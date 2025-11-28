<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Hipersalud</title>

		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">   

		<!-- Favicon -->
		<link rel="icon" type="image/png" sizes="192x192"  href="favicon/favicon-192x192.png">
		
		<!-- Styles -->
		<link href="./css/bootstrap.css" rel="stylesheet">
		<link href="./css/bootstrap-responsive.css" rel="stylesheet">
		<link href="./css/bootstrap-overrides.css" rel="stylesheet">
		<link href="./css/ui-lightness/jquery-ui-1.8.21.custom.css" rel="stylesheet">
		<link href="./css/slate.css" rel="stylesheet">
		<link href="./css/components/signin.css" rel="stylesheet" type="text/css">   

		<!-- Javascript -->
		<script src="./js/jquery-1.7.2.min.js"></script>
		<script src="./js/jquery-ui-1.8.21.custom.min.js"></script>    
		<script src="./js/jquery.ui.touch-punch.min.js"></script>
		<script src="./js/bootstrap.js"></script>

    </head>

	<body>

		<div class="account-container login">
			
			<div class="content clearfix">
				
				<form action="user.php" method="post" id="form-pswd" class="form-horizontal" novalidate="novalidate">
					<input type="hidden" name="cmd" value="<?=ps('setpswd');?>">
                    <input type="hidden" name="code" value="<?=ps($code);?>">

					<p><img src="img/logo_hipersalud_full.png" alt="Hipersalud" /></p>
				
					<h1><?=LABEL_PASSWORD;?></h1>

                    <?php $global_alerts->display(); ?>
					
					<div class="login-fields">
						
						<p><?=LABEL_PWSD_SET;?></p>
						
						<div class="field">
							<label for="email"><?=LABEL_EMAIL;?></label>
							<input type="email" id="email" name="email" value="<?=$email;?>" placeholder="<?=LABEL_EMAIL;?>" disabled class="login username-field" />
						</div> <!-- /field -->
						
						<div class="field">
							<label for="password"><?=LABEL_PASSWORD;?></label>
							<input type="password" id="password" name="password" value="" placeholder="<?=LABEL_PASSWORD;?>" class="login password-field" />
						</div> <!-- /field -->
						
						<div class="field">
							<label for="password_confirm"><?=LABEL_PASSWORD;?></label>
							<input type="password" id="password_confirm" name="password_confirm" value="" placeholder="<?=LABEL_PASSWORD_CONFIRM;?>" class="login password-field"/>
						</div> <!-- /password -->
						
					</div> <!-- /login-fields -->
					
					<div class="login-actions">
						
						<span class="login-checkbox">
							<select name="language" class="input input-small">
								<option value=""><?=LABEL_LANGUAGE;?></option>
								<option value="es" <?=($global_language->get()=="es") ? 'selected': '';?>><?=LABEL_LANGUAGE_ES;?></option>
								<option value="en" <?=($global_language->get()=="en") ? 'selected': '';?>><?=LABEL_LANGUAGE_EN;?></option>
							</select>
						</span>
											
						<button type="submit" class="button btn btn-secondary btn-large"><?=LABEL_FORMS_SAVE;?></button>
						
					</div> <!-- .actions -->
					
				</form>
				
				<div style="text-align:right;"><img src="img/logo_hipermedica_by.png" alt="Grupo Hipermédica" /></div>
				
			</div> <!-- /content -->
			
		</div> <!-- /account-container -->

	</body>

</html>