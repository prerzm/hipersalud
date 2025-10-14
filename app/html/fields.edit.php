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

			<h1>Campos</h1>

			<ul class="breadcrumb">
				<li><a href="./">Inicio</a> <span class="divider">/</span></li>
                <li><a href="./?mod=<?=ps($mod);?>">Campos</a> <span class="divider">/</span></li>
                <li class="active"><?=$record->get("label");?></li>
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
							<input type="hidden" name="id" value="<?=$id;?>">
							<fieldset>
                                <div class="control-group">
									<label class="control-label" for="label">Label</label>
									<div class="controls">
										<input type="text" id="label" name="label" class="input-large" value="<?=$record->get("label");?>" />
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="name">Key</label>
									<div class="controls">
										<input type="text" id="name" name="name" class="input-large" value="<?=$record->get("name");?>" />
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="type">Tipo</label>
									<div class="controls">
										<select name="type" class="input-large">
											<option value="text" <?=($record->get("type")=="text") ? 'selected': '';?>>text</option>
                                            <option value="textarea" <?=($record->get("type")=="textarea") ? 'selected': '';?>>textarea</option>
										</select>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="size">Tamaño</label>
									<div class="controls">
										<select name="size" class="input-large">
                                            <option value="mini" <?=($record->get("size")=="mini") ? 'selected': '';?>>mini</option>
                                            <option value="small" <?=($record->get("size")=="small") ? 'selected': '';?>>small</option>
                                            <option value="large" <?=($record->get("size")=="large") ? 'selected': '';?>>large</option>
                                            <option value="xlarge" <?=($record->get("size")=="xlarge") ? 'selected': '';?>>xlarge</option>
										</select>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="required">Requerido</label>
									<div class="controls">
										<label class="radio inline"><input type="radio" id="required_yes" name="required" class="radio" value="1"> Si </label> &nbsp;
                                        <label class="radio inline"><input type="radio" id="required_no" name="required" class="radio" value="0" checked> No </label>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="minLen">Mínimo y Máximo</label>
									<div class="controls">
										<input type="text" id="minLen" name="minLen" class="input input-small" value="<?=$record->get("minLen");?>" />&nbsp;
                                        <input type="text" id="maxLen" name="maxLen" class="input input-small" value="<?=$record->get("maxLen");?>" />
									</div>
								</div>
								<div class="form-actions" style="padding-left:0px;padding-right:0px;text-align:center;">
									<button type="submit" class="btn btn-primary btn-large" style="margin-left:0px;">Guardar</button>
									<a href="./?mod=<?=ps($mod);?>&cmd=<?=ps('delete');?>&id=<?=ps($id);?>" class="btn btn-danger btn-large" onclick="return confirm('Está seguro que desea eliminar este registro?');">Eliminar</a>
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