<?php include("header.php"); ?>

<script src="./js/plugins/chart/chart.js"></script>

<script>

    $(document).ready(function(){

		// date
		$("#dob").datepicker({ dateFormat: 'yy-mm-dd' });

	}); // end document.ready

</script>

<div class="container">
		
		<div id="page-title" class="clearfix">

			<h1><?=$record->get("name");?></h1>

			<ul class="breadcrumb">
				<li><a href="./"><?=LABEL_MENU_HOME;?></a> <span class="divider">/</span></li>
                <li><a href="./?mod=<?=ps($mod);?>"><?=LABEL_PATIENTS;?></a> <span class="divider">/</span></li>
				<li class="active"><?=LABEL_PATIENT;?></li>
			</ul>
			
		</div> <!-- /.page-title -->
		
		<div class="row">

			<div class="span12">

				<!--- alert messagess ---->
				<?php $global_alerts->display(); ?>

			</div> <!-- /.span12 -->

            <div class="<?=(count($data)>0 && count($app_data)>0) ? 'span4' : 'span8';?>">

                <div class="widget widget-form">
                    
                    <div class="widget-header">
                        <h3>
                            <i class="icon-user"></i>
                            <?=LABEL_DETAILS;?>
                        </h3>

                    </div> <!-- /.widget-header -->
                    
                    <div class="widget-content">

                        <?php if($edit) { ?>
                            <form action="./?mod=<?=ps($mod);?>" method="post" id="form-add" class="<?=(count($data)>0 && count($app_data)>0) ? 'form' : 'form-horizontal';?>" novalidate="novalidate">
                                <input type="hidden" name="cmd" value="<?=ps('update');?>">
                                <input type="hidden" name="id" value="<?=ps($record->id());?>">

                                <fieldset>
                                    <div class="control-group">
                                        <label class="control-label" for="name"><?=LABEL_NAME;?></label>
                                        <div class="controls">
                                            <input type="text" id="name" name="name" class="input input-large" autocomplete="off" value="<?=$record->get("name");?>" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="email"><?=LABEL_EMAIL;?></label>
                                        <div class="controls">
                                            <input type="text" id="email" name="email" class="input input-large" autocomplete="off" value="<?=$record->get("email");?>" />
                                        </div>
                                    </div>
									<div class="control-group">
										<label class="control-label" for="companyId"><?=LABEL_COMPANY;?></label>
										<div class="controls">
											<select name="companyId" class="input-large">
												<?=Html::select_options($companies, "companyId", "name", $record->get("companyId"));?>
											</select>
										</div>
									</div>
                                    <div class="control-group">
                                        <label class="control-label" for="password"><?=LABEL_PASSWORD;?></label>
                                        <div class="controls">
                                            <input type="password" id="password" name="password" class="input input-large" autocomplete="off" value="" />
                                            <p class="help-block"><?=LABEL_PASSWORD_CHANGE;?></p>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="dob"><?=LABEL_DOB;?></label>
                                        <div class="controls">
                                            <input type="text" id="dob" name="dob" placeholder="yyyy-mm-dd" class="input input-small" autocomplete="off" value="<?=$record->get("dob");?>" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="height"><?=LABEL_HEIGHT;?></label>
                                        <div class="controls">
                                            <div class="input-append">
                                                <input type="text" class="input input-mini" id="height" name="fields[height]" autocomplete="off" value="<?=$record->get("height");?>"><span class="add-on">cm</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="sex"><?=LABEL_SEX;?></label>
                                        <div class="controls">
                                            <label class="radio"><input type="radio" id="sexm" value="M" name="fields[sex]" <?=($record->get("sex")=="M") ? 'checked="checked"': '';?>> <?=LABEL_MALE;?></label>
                                            <label class="radio"><input type="radio" id="sexf" value="F" name="fields[sex]" <?=($record->get("sex")=="F") ? 'checked="checked"': '';?>> <?=LABEL_FEMALE;?></label>
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <button type="button" class="btn" onclick="window.location='./?mod=<?=ps($mod);?>';">&nbsp;<i class="icon-arrow-left"></i> <?=LABEL_FORMS_BACK;?></button>
                                        <button type="submit" class="btn btn-primary">&nbsp;<i class="icon-hdd"></i> <?=LABEL_FORMS_UPDATE;?></button>
                                    </div>
                                </fieldset>
                            </form>
                        <?php } else { ?>
                            <fieldset>
                                <div class="control-group"><h2><?=$record->get("name");?></h2></div>
                                <div class="control-group">
                                    <p style="font-size:16px;">
                                        <strong><?=LABEL_EMAIL;?>:</strong> <?=$record->get("email");?><br>
                                        <strong><?=LABEL_AGE;?>:</strong> <?=$record->get("age")." (".$record->get("dob").")";?><br>
                                        <strong><?=LABEL_HEIGHT;?>:</strong> <?=$record->get("height");?>cm<br>
                                        <strong><?=LABEL_SEX;?>:</strong> <?=($record->get("sex")=="M") ? LABEL_MALE : LABEL_FEMALE;?><br>
                                    </p>
                                    <p>*<?=LABEL_USER_SINCE;?>: <?=DateLang::short($record->get("dateCreated"));?></p>
                                </div>
                                <div class="form-actions">
                                    <button type="button" class="btn" onclick="window.location='./?mod=<?=ps($mod);?>';">&nbsp;<i class="icon-arrow-left"></i> <?=LABEL_FORMS_BACK;?></button>
                                </div>
                            </fieldset>
                        <?php } ?>

                    </div> <!-- /.widget-content -->
                    
                </div> <!-- /.widget -->

            </div><!-- ./span4 detalles -->

            <?php if(count($data)>0 && count($app_data)>0) { ?>
                <?php include("index.index.patient.php"); ?>
            <?php } ?>

        </div> <!-- /.row -->

	</div> <!-- /.container -->
	
</div> <!-- /#content -->

<script>

    <?php if(count($data)>0 && count($app_data)>0) { ?>
	    <?php include("inc.graphs.js.php"); ?>
    <?php } ?>

</script>

<?php include("footer.php"); ?>