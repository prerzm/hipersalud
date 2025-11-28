<?php include("header.php"); ?>

<script>

    $(document).ready(function(){

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

			<h1><?=$record->get("name");?></h1>

			<ul class="breadcrumb">
				<li><a href="./"><?=LABEL_MENU_HOME;?></a> <span class="divider">/</span></li>
                <li><a href="./?mod=<?=ps('com');?>"><?=LABEL_COMPANIES;?></a> <span class="divider">/</span></li>
				<li class="active"><?=LABEL_COMPANIES;?></li>
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
                            <i class="icon-user"></i>
                            <?=LABEL_DETAILS;?>
                        </h3>

                    </div> <!-- /.widget-header -->
                    
                    <div class="widget-content">

                        <form action="./?mod=<?=ps('com');?>" method="post" id="form-add" class="form" novalidate="novalidate">
                            <input type="hidden" name="cmd" value="<?=ps('update');?>">
                            <input type="hidden" name="id" value="<?=ps($record->id());?>">

                            <fieldset>
                                <div class="control-group">
                                    <label class="control-label" for="name"><?=LABEL_NAME;?></label>
                                    <div class="controls">
                                        <input type="text" id="name" name="name" class="input input-xlarge" autocomplete="off" value="<?=$record->get("name");?>" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="city"><?=LABEL_COMPANIES_CITY;?></label>
                                    <div class="controls">
                                        <input type="text" id="city" name="city" class="input input-xlarge" autocomplete="off" value="<?=$record->get("city");?>" />
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <button type="button" class="btn" style="margin-left:0px;" onclick="window.location='./?mod=<?=ps('com');?>';">&nbsp;<i class="icon-arrow-left"></i> <?=LABEL_FORMS_BACK;?></button>
                                    <button type="submit" class="btn btn-primary" style="margin-left:5px;">&nbsp;<i class="icon-hdd"></i> <?=LABEL_FORMS_UPDATE;?></button>
                                </div>
                            </fieldset>

                        </form>

                    </div> <!-- /.widget-content -->
                    
                </div> <!-- /.widget -->

            </div><!-- ./span4 detalles -->

            <div class="span8">

                <div class="widget widget-table">
                    
                    <div class="widget-header">
                        <h3>
                            <i class="icon-list-alt"></i>
                            <?=LABEL_COMPANIES_EMPLOYEES;?>
                        </h3>

                    </div> <!-- /.widget-header -->
                    
                    <div class="widget-content">

                        <table class="table table-striped table-bordered responsive">
                            <thead>
                                <tr>
                                    <th><?=LABEL_PATIENT;?></th>
                                    <th><?=LABEL_USER_SINCE;?></th>
                                    <th><?=LABEL_HEALTH_LAST_RECORD;?></th>
                                    <th><?=LABEL_APPOINTMENTS_LAST;?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($results) { ?>
                                    <?php foreach($results as $r) { ?>
                                        <tr class="odd gradeX">
                                            <td>
                                                <?php if($global_perms->can("pat", "READ")) { ?>
                                                    <a href="?mod=<?=ps("pat");?>&cmd=<?=ps('edit');?>&id=<?=ps($r['userId']);?>"><?=$r['name'];?></a>
                                                <?php } else { ?>
                                                    <?=$r['name'];?>
                                                <?php } ?>
                                            </td>
                                            <td><?=$r['dateCreated'];?></td>
                                            <td><?=$r['lastParams'];?></td>
                                            <td><?=$r['lastDate'];?></td>
                                        </tr>
                                    <?php } ?>
                                <?php } else { ?>
                                    <tr class="odd gradeA">
                                        <td colspan="4"><?=LABEL_COMPANIES_NO_EMPLOYEES;?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
						</table>

                    </div> <!-- /.widget-content -->
                    
                </div> <!-- /.widget -->

            </div><!-- ./span exped -->

		</div> <!-- /.row -->

	</div> <!-- /.container -->
	
</div> <!-- /#content -->


<?php include("footer.php"); ?>