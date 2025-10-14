<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Proyecto DM</title>

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
		<script src="./js/jquery-ui-1.8.18.custom.min.js"></script>    
		<script src="./js/jquery.ui.touch-punch.min.js"></script>
		<script src="./js/bootstrap.js"></script>
		<script src="./js/demos/signin.js"></script>
	</head>

	<body>

		<div class="account-container login">
			
			<div class="content clearfix">
				
				<form action="?mod=<?=ps('log');?>" method="post" id="form-login" class="form-horizontal" novalidate="novalidate">
					<input type="hidden" name="cmd" value="<?=ps('login');?>">
				
					<h1><?=LABEL_LOGIN;?></h1>

                    <?php $global_alerts->display(); ?>
					
					<div class="login-fields">
						
						<p><?=LABEL_LOGIN_DESC;?></p>
						
						<div class="field">
							<label for="email"><?=LABEL_EMAIL;?></label>
							<input type="text" id="email" name="email" value="" placeholder="<?=LABEL_EMAIL;?>" class="login username-field" />
						</div> <!-- /field -->
						
						<div class="field">
							<label for="password"><?=LABEL_PASSWORD;?></label>
							<input type="password" id="password" name="password" value="" placeholder="<?=LABEL_PASSWORD;?>" class="login password-field"/>
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
											
						<button class="button btn btn-secondary btn-large"><?=LABEL_BUTTON_LOGIN;?></button>
						
					</div> <!-- .actions -->
					
                    <?php /*
					<div class="login-social">
						<p>Sign in using social network:</p>
						
						<div class="twitter">
							<a href="#" class="btn_1">Login with Twitter</a>				
						</div>
						
						<div class="fb">
							<a href="#" class="btn_2">Login with Facebook</a>				
						</div>
					</div>
                    */ ?>
					
				</form>
				
			</div> <!-- /content -->
			
		</div> <!-- /account-container -->

    <?php /*
	<!-- Text Under Box -->
	<div class="login-extra">
		Don't have an account? <a href="./signup.html">Sign Up</a><br/>
		Remind <a href="#">Password</a>
	</div> <!-- /login-extra -->
    */ ?>

	</body>

</html>