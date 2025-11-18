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
				city: {
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

			<h1><?=LABEL_COMPANIES;?></h1>

			<ul class="breadcrumb">
				<li><a href="./"><?=LABEL_MENU_HOME;?></a> <span class="divider">/</span></li>
				<li class="active"><?=LABEL_COMPANIES;?></li>
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
                        
                            <form action="./?mod=<?=ps('com');?>" method="post" id="form-add" class="form" novalidate="novalidate">
                                <input type="hidden" name="cmd" value="<?=ps('add');?>">
                                <fieldset>
                                    <div class="control-group">
                                        <label class="control-label" for="name"><?=LABEL_NAME;?></label>
                                        <div class="controls">
                                            <input type="text" id="name" name="name" value="" class="input-large" autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="city"><?=LABEL_COMPANIES_CITY;?></label>
                                        <div class="controls">
                                            <input type="text" id="city" name="city" value="" class="input-large" autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-primary" style="margin-left:0px;"><?=LABEL_FORMS_SAVE;?></button>
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
							<?=LABEL_COMPANIES;?>
						</h3>
					</div> <!-- /.widget-header -->
					
					<div class="widget-content">
						
						<table class="table table-striped table-bordered table-highlight" id="results">
							<thead>
								<tr>
									<th><?=LABEL_NAME;?></th>
									<th><?=LABEL_COMPANIES_CITY;?></th>
									<th><?=LABEL_COMPANIES_EMPLOYEES;?></th>
								</tr>
							</thead>
							<tbody>
								<?php if($results) { ?>
									<?php for($i=0; $i<count($results); $i++) { ?>
										<tr class="<?=($i%2==0) ? 'odd gradeX' : 'even gradeC';?>">
											<td>
                                                <?php if($global_perms->can("com", "EDIT")) { ?>
                                                    <a href="?mod=<?=ps('com');?>&cmd=<?=ps('edit');?>&id=<?=ps($results[$i]['companyId']);?>"><?=$results[$i]['name'];?></a>
                                                <?php } else { ?>
                                                    <?=$results[$i]['name'];?>
                                                <?php } ?>
                                            </td>
											<td><?=$results[$i]['city'];?></td>
                                            <td><?=$results[$i]['employees'];?></td>
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