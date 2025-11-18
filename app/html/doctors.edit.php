<?php include("header.php"); ?>

<script>

    $(document).ready(function(){

		$('#form-add').validate({
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

		// date
		$("#dob").datepicker({ dateFormat: 'yy-mm-dd' });

	}); // end document.ready

</script>

<div class="container">
		
		<div id="page-title" class="clearfix">

			<h1><?=$record->get("name");?></h1>

			<ul class="breadcrumb">
				<li><a href="./"><?=LABEL_MENU_HOME;?></a> <span class="divider">/</span></li>
                <li><a href="./?mod=<?=ps('doc');?>"><?=LABEL_DOCTORS;?></a> <span class="divider">/</span></li>
				<li class="active"><?=LABEL_DOCTORS;?></li>
			</ul>
			
		</div> <!-- /.page-title -->
		
		<div class="row">

			<div class="span12">

				<!--- alert messagess ---->
				<?php $global_alerts->display(); ?>

			</div> <!-- /.span12 -->

            <?php if($edit) { ?>

                <form action="./?mod=<?=ps('doc');?>" method="post" id="form-add" novalidate="novalidate">
                <input type="hidden" name="cmd" value="<?=ps('update');?>">
                <input type="hidden" name="id" value="<?=ps($record->id());?>">

            <?php } ?>

            <div class="span4">

                <div class="widget widget-form">
                    
                    <div class="widget-header">
                        <h3>
                            <i class="icon-user"></i>
                            <?=LABEL_DETAILS;?>
                        </h3>

                    </div> <!-- /.widget-header -->
                    
                    <div class="widget-content">

                        <?php if($edit) { ?>
                            <fieldset>
                                <div class="control-group">
                                    <label class="control-label" for="name"><?=LABEL_NAME;?></label>
                                    <div class="controls">
                                        <input type="text" id="name" name="name" class="input input-xlarge" autocomplete="off" value="<?=$record->get("name");?>" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="email"><?=LABEL_EMAIL;?></label>
                                    <div class="controls">
                                        <input type="text" id="email" name="email" class="input input-xlarge" autocomplete="off" value="<?=$record->get("email");?>" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="esp"><?=LABEL_DOCTORS_SPECIALTY;?></label>
                                    <div class="controls">
                                        <input type="text" id="esp" name="fields[esp]" class="input input-xlarge" autocomplete="off" value="<?=$record->get("esp");?>" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="password"><?=LABEL_PASSWORD;?></label>
                                    <div class="controls">
                                        <input type="password" id="password" name="password" class="input input-large" autocomplete="off" value="" />
                                        <p class="help-block"><?=LABEL_PASSWORD_CHANGE;?></p>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <button type="button" class="btn" style="margin-left:0px;" onclick="window.location='./?mod=<?=ps('doc');?>';">&nbsp;<i class="icon-arrow-left"></i> <?=LABEL_FORMS_BACK;?></button>
                                    <button type="submit" class="btn btn-primary" style="margin-left:5px;">&nbsp;<i class="icon-hdd"></i> <?=LABEL_FORMS_UPDATE;?></button>
                                </div>
                            </fieldset>
                        <?php } else { ?>
                            <fieldset>
                                <div class="control-group"><h2><?=$record->get("name");?></h2></div>
                                <div class="control-group">
                                    <p style="font-size:16px;">
                                        <strong><?=LABEL_EMAIL;?>:</strong> <?=$record->get("email");?><br>
                                    </p>
                                    <p>*<?=LABEL_USER_SINCE;?>: <?=$record->get("dateCreated");?></p>
                                </div>
                                <div class="form-actions">
                                    <button type="button" class="btn btn-large" style="margin-left:0px;" onclick="window.location='./?mod=<?=ps('doc');?>';">&nbsp;<i class="icon-arrow-left"></i> <?=LABEL_FORMS_BACK;?></button>
                                    <?php if($edit) { ?>
                                        <button type="submit" class="btn btn-primary btn-large" style="margin-left:5px;">&nbsp;<i class="icon-hdd"></i> <?=LABEL_FORMS_UPDATE;?></button>
                                    <?php } ?>
                                </div>
                            </fieldset>
                        <?php } ?>

                    </div> <!-- /.widget-content -->
                    
                </div> <!-- /.widget -->

            </div><!-- ./span4 detalles -->

            <div class="span8">

                <div class="widget widget-table">
                    
                    <div class="widget-header">
                        <h3>
                            <i class="icon-list-alt"></i>
                            <?=LABEL_CONSULTATIONS_RECORD;?>
                        </h3>

                    </div> <!-- /.widget-header -->
                    
                    <div class="widget-content">

                        <table class="table table-striped table-bordered responsive">
                            <thead>
                                <tr>
                                    <th><?=LABEL_DATE;?></th>
                                    <th><?=LABEL_PATIENT;?></th>
                                    <th><?=LABEL_CONSULTATIONS_NOTES;?></th>
                                    <th><?=LABEL_APPOINTMENTS_STATUS;?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($consultations) { ?>
                                    <?php foreach($consultations as $c) { ?>
                                        <tr class="odd gradeX">
                                            <td>
                                                <?php if($global_perms->can("csu", "READ")) { ?>
                                                    <a href="?mod=<?=ps('csu');?>&cmd=<?=ps('edit');?>&id=<?=ps($c['appointmentId']);?>"><?=$c['appDateTime'];?></a>
                                                <?php } else { ?>
                                                    <?=$c['appDateTime'];?></td>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php if($global_perms->can("pat", "READ")) { ?>
                                                    <a href="?mod=<?=ps("pat");?>&cmd=<?=ps('edit');?>&id=<?=ps($c['userId']);?>"><?=$c['name'];?></a>
                                                <?php } else { ?>
                                                    <?=$c['name'];?>
                                                <?php } ?>
                                            </td>
                                            <td><span class="label label-<?=$c['class'];?>"><?=$c['appStatus'];?></span></td>
                                            <td><?=$c['notes'];?></td>
                                        </tr>
                                    <?php } ?>
                                <?php } else { ?>
                                    <tr class="odd gradeA">
                                        <td colspan="3"><?=LABEL_CONSULTATIONS_NO_HISTORY;?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
						</table>

                    </div> <!-- /.widget-content -->
                    
                </div> <!-- /.widget -->

            </div><!-- ./span exped -->

            <?php if($edit) { ?>

                </form>

            <?php } ?>

		</div> <!-- /.row -->

	</div> <!-- /.container -->
	
</div> <!-- /#content -->


<?php include("footer.php"); ?>