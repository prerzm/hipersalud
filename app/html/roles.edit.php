<?php include("header.php"); ?>

<script>

	$(document).ready(function(){

		$('#form-edit').validate({
			rules: {
				name: {
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

			<h1>Roles</h1>

			<ul class="breadcrumb">
				<li><a href="./">Inicio</a> <span class="divider">/</span></li>
                <li><a href="./?mod=<?=ps($mod);?>">Roles</a> <span class="divider">/</span></li>
                <li class="active"><?=$record->get("rol");?></li>
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
									<label class="control-label" for="rol">Nombre</label>
									<div class="controls">
										<input type="text" name="rol" id="rol" class="input input-xlarge" value="<?=$record->get("rol");?>" />
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="rol">Permisos</label>
									<div class="controls">
										<table class="table table-striped table-bordered">
											<?php foreach($modules as $m) { ?>
												<tr>
													<th><?=$m['modulo'];?></th>
													<?php if($m['perms']) { ?>
														<?php for($i=0; $i<count($m['perms']); $i++) { ?>
															<?php $p = $m['perms'][$i]; ?>
															<td><label class="checkbox inline"><input type="checkbox" name="perms[<?=$p['permisoId'];?>]" value="1" <?=((bool)$p['hasPerm']) ? 'checked="checked"' : '';?>> <?=$p['permiso'];?></label></td>
														<?php } ?>
														<?php if($i<$max_perms) { 
															for( ; $i<$max_perms; $i++) {
																print "<td>&nbsp;</td>";
															}
														} ?>
													<?php } ?>
												</tr>
											<?php } ?>
										</table>
									</div>
								</div>
								<div class="form-actions" style="padding-left:0px;padding-right:0px;text-align:center;">
									<button type="submit" class="btn btn-primary btn-large" style="margin-left:0px;">Guardar</button>
									<a href="./?mod=<?=ps($mod);?>&cmd=<?=ps('delete');?>&id=<?=ps($id);?>" class="btn btn-danger btn-large" onclick="return confirm('Está seguro que desea eliminar este rol?');">Eliminar</a>
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