<?php include("header.php"); ?>

<script>

	$(document).ready(function(){

		$('#form-edit').validate({
			rules: {
				name: {
					required: true
				},
				email: {
					required: true,
					email: true
				}
			},
			focusCleanup: false,
			
			highlight: function(label) {
				$(label).closest('.control-group').removeClass ('success').addClass('error');
			},
			success: function(label) {
				label
					.text('OK!').addClass('valid')
					.closest('.control-group').addClass('success');
			},
			errorPlacement: function(error, element) {
				error.appendTo( element.parents ('.controls') );
			}
		});

		$('.form').eq (0).find ('input').eq (0).focus ();

	}); // end document.ready

</script>

<div class="container">
		
		<div id="page-title" class="clearfix">

			<h1>Usuarios</h1>

			<ul class="breadcrumb">
				<li><a href="./">Inicio</a> <span class="divider">/</span></li>
                <li><a href="./?mod=<?=ps($mod);?>">Usuarios</a> <span class="divider">/</span></li>
                <li class="active"><?=$user->get("name");?></li>
			</ul>
			
		</div> <!-- /.page-title -->
		
		<div class="row">

			<div class="span12">

				<!--- alert messagess ---->
				<?php $global_alerts->display(); ?>

			</div> <!-- /.span12 -->

			<div class="span12">

				<div class="widget widget-form">
					
					<div class="widget-header">
						<h3>
							<i class="icon-pencil"></i>
							Editar
						</h3>

					</div> <!-- /.widget-header -->
					
					<div class="widget-content">
					
						<form action="./?mod=<?=ps($mod);?>" method="post" id="form-edit" class="form-horizontal" novalidate="novalidate">
							<input type="hidden" name="cmd" value="<?=ps('update');?>">
							<input type="hidden" name="id" value="<?=ps($id);?>">
							<fieldset>
								<div class="control-group">
									<label class="control-label" for="name">Nombre</label>
									<div class="controls">
										<input type="text" name="name" id="name" class="input input-xlarge" value="<?=$user->get("name");?>" />
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="email">Email</label>
									<div class="controls">
										<input type="text" name="email" id="email" class="input input-xlarge" value="<?=$user->get("email");?>" />
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="rolId">Rol</label>
									<div class="controls">
										<select name="rolId" class="input-large">
											<?=Html::select_options($roles, "rolId", "rol", $user->get("rolId"));?>
										</select>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="password">Contraseña</label>
									<div class="controls">
										<input type="password" name="password" id="password" class="input input-xlarge" />
										<p class="help-block">Solo si desea cambiarla.</p>
									</div>
								</div>
								<div class="form-actions" style="padding-left:0px;padding-right:0px;text-align:center;">
									<button type="submit" class="btn btn-primary btn-large" style="margin-left:0px;">Guardar</button>
									<a href="./?mod=<?=ps($mod);?>&cmd=<?=ps('delete');?>&id=<?=ps($id);?>" class="btn btn-danger btn-large" onclick="return confirm('Está seguro que desea eliminar este usuario?');">Eliminar</a>
								</div>
							</fieldset>
						</form>
						
					</div> <!-- /.widget-content -->
					
				</div> <!-- /.widget -->

			</div><!-- ./span -->

		</div> <!-- /.row -->

	</div> <!-- /.container -->
	
</div> <!-- /#content -->


<?php include("footer.php"); ?>