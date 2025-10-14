<?php include("header.php"); ?>

<script>

	$(document).ready(function(){

		$('#form-edit').validate({
			rules: {
				permisoKey: {
					required: true
				},
				permiso: {
					required: true
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

			<h1>Módulos Permisos</h1>

			<ul class="breadcrumb">
				<li><a href="./">Inicio</a> <span class="divider">/</span></li>
                <li><a href="./?mod=<?=ps($mod);?>">Módulos</a> <span class="divider">/</span></li>
                <li><a href="./?mod=<?=ps($mod);?>&cmd=<?=ps('edit');?>&id=<?=ps($id);?>"><?=$module->get("modulo");?></a> <span class="divider">/</span></li>
				<li class="active">Módulos Permisos</li>
			</ul>
			
		</div> <!-- /.page-title -->
		
		<div class="row">

			<div class="span12">

				<!--- alert messagess ---->
				<?php $global_alerts->display(); ?>

			</div> <!-- /.span12 -->

			<div class="span4">

				<div class="widget widget-form">
					
					<div class="widget-header">
						<h3>
							<i class="icon-plus-sign"></i>
							Agregar Permiso
						</h3>

					</div> <!-- /.widget-header -->
					
					<div class="widget-content">
					
						<form action="./?mod=<?=ps($mod);?>" method="post" id="form-edit" novalidate="novalidate">
							<input type="hidden" name="cmd" value="<?=ps('updateperm');?>">
                            <input type="hidden" name="id" value="<?=ps($id);?>">
                            <input type="hidden" name="pid" value="<?=ps($pid);?>">
							<fieldset>
								<div class="control-group">
									<label class="control-label" for="permisoKey">Key</label>
									<div class="controls">
										<input type="text" id="permisoKey" name="permisoKey" value="<?=$record->get("permisoKey");?>" class="input-large" />
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="permiso">Permiso</label>
									<div class="controls">
										<input type="text" id="permiso" name="permiso" value="<?=$record->get("permiso");?>" class="input-large" />
									</div>
								</div>
								<div class="form-actions">
									<button type="submit" class="btn btn-primary btn-large" style="margin-left:0px;">Guardar</button>
                                    <button type="button" class="btn btn-large" onclick="window.location='./?mod=<?=ps($mod);?>&cmd=<?=ps('edit');?>&id=<?=ps($id);?>';">Cancelar</button>
								</div>
							</fieldset>
						</form>
						
					</div> <!-- /.widget-content -->
					
				</div> <!-- /.widget -->

			</div><!-- ./span4 agregar -->

		</div> <!-- /.row -->

	</div> <!-- /.container -->
	
</div> <!-- /#content -->


<?php include("footer.php"); ?>