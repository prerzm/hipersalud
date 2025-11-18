<?php include("header.php"); ?>

<script>

	$(document).ready(function(){

		$('#results').dataTable( {
			sDom: "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>",
			sPaginationType: "bootstrap",
			oLanguage: {
				"sLengthMenu": "_MENU_ records per page"
			},
			iDisplayLength: 50,
			aaSorting: [[0,"asc"]]
		});
	
		$('#form-add').validate({
			rules: {
				name: {
					required: true
				},
				email: {
					required: true,
					email: true
				},
				dob: {
					required: true
				},
				height: {
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

		// date
		$("#dob").datepicker({ dateFormat: 'yy-mm-dd' });

	}); // end document.ready

</script>

<div class="container">
		
		<div id="page-title" class="clearfix">

			<h1><?=LABEL_PATIENTS;?></h1>

			<ul class="breadcrumb">
				<li><a href="./"><?=LABEL_MENU_HOME;?></a> <span class="divider">/</span></li>
				<li class="active"><?=LABEL_PATIENTS;?></li>
			</ul>
			
		</div> <!-- /.page-title -->
		
		<div class="row">

			<div class="span12">

				<!--- alert messagess ---->
				<?php $global_alerts->display(); ?>

			</div> <!-- /.span12 -->

            <?php if($global_perms->can($mod, "ADD")) { ?>
                <div class="span3">

                    <div class="widget widget-form">
                        
                        <div class="widget-header">
                            <h3>
                                <i class="icon-plus-sign"></i>
                                <?=LABEL_FORMS_ADD;?>
                            </h3>

                        </div> <!-- /.widget-header -->
                        
                        <div class="widget-content">
                        
                            <form action="./?mod=<?=ps($mod);?>" method="post" id="form-add" class="form" novalidate="novalidate">
                                <input type="hidden" name="cmd" value="<?=ps('add');?>">
                                <fieldset>
                                    <div class="control-group">
                                        <label class="control-label" for="name"><?=LABEL_NAME;?></label>
                                        <div class="controls">
                                            <input type="text" id="name" name="name" value="" class="input-large" autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="email"><?=LABEL_EMAIL;?></label>
                                        <div class="controls">
                                            <input type="text" id="email" name="email" value="" class="input-large" autocomplete="off" />
                                        </div>
                                    </div>
									<div class="control-group">
										<label class="control-label" for="companyId"><?=LABEL_COMPANY;?></label>
										<div class="controls">
											<select name="companyId" class="input-large">
												<?=Html::select_options($companies, "companyId", "name");?>
											</select>
										</div>
									</div>
                                    <div class="control-group">
                                        <label class="control-label" for="dob"><?=LABEL_DOB;?></label>
                                        <div class="controls">
                                            <input type="text" id="dob" name="dob" placeholder="yyyy-mm-dd" value="" class="input-large" autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="height"><?=LABEL_HEIGHT;?></label>
                                        <div class="controls">
											<div class="input-append">
												<input type="text" id="height" name="fields[height]" class="input input-small" autocomplete="off" value="" /><span class="add-on">cm</span>
											</div>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="sex"><?=LABEL_SEX;?></label>
                                        <div class="controls">
                                            <label class="radio"><input type="radio" name="fields[sex]" id="sexm" value="M" checked="checked"> <?=LABEL_MALE;?></label>
                                            <label class="radio"><input type="radio" name="fields[sex]" id="sexf" value="F"> <?=LABEL_FEMALE;?></label>
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-primary btn-large"><?=LABEL_FORMS_SAVE;?></button>
                                    </div>
                                </fieldset>
                            </form>
                            
                        </div> <!-- /.widget-content -->
                        
                    </div> <!-- /.widget -->

                </div><!-- ./span3 agregar -->
            <?php } ?>

			<div <?=($global_perms->can($mod, "ADD")) ? 'class="span9"' : 'class="span12"';?>>

				<div class="widget widget-table">
					
					<div class="widget-header">
						<h3>
							<i class="icon-th-list"></i>
							<?=LABEL_PATIENTS;?>
						</h3>
					</div> <!-- /.widget-header -->
					
					<div class="widget-content">
						
						<table class="table table-striped table-bordered table-highlight" id="results">
							<thead>
								<tr>
									<th><?=LABEL_NAME;?></th>
									<th><?=LABEL_EMAIL;?></th>
									<th><?=LABEL_COMPANY;?></th>
									<th><?=LABEL_AGE;?></th>
								</tr>
							</thead>
							<tbody>
								<?php if($results) { ?>
									<?php for($i=0; $i<count($results); $i++) { ?>
										<tr class="<?=($i%2==0) ? 'odd gradeX' : 'even gradeC';?>">
											<td><a href="?mod=<?=ps($mod);?>&cmd=<?=ps('edit');?>&id=<?=ps($results[$i]['userId']);?>"><?=$results[$i]['name'];?></a></td>
											<td><?=$results[$i]['email'];?></td>
											<td><?=$results[$i]['company'];?></td>
											<td><?=$results[$i]['age'];?></td>
										</tr>
									<?php } ?>
								<?php } ?>
							</tbody>
						</table>

					</div> <!-- /.widget-content -->
					
				</div> <!-- /.widget -->

			</div><!-- ./span -->

		</div> <!-- /.row -->

	</div> <!-- /.container -->
	
</div> <!-- /#content -->


<?php include("footer.php"); ?>