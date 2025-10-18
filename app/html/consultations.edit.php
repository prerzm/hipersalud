<?php include("header.php"); ?>

<script src="./js/dm.js"></script>

<div class="container">
		
		<div id="page-title" class="clearfix">

			<h1><?=LABEL_CONSULTATION;?> - <?=$contact->get("name");?> - <?=DateLang::med($record->get("appDateTime"));?></h1>

			<ul class="breadcrumb">
				<li><a href="./">Inicio</a> <span class="divider">/</span></li>
                <li><a href="./?mod=<?=ps('csu');?>"><?=LABEL_CONSULTATIONS;?></a> <span class="divider">/</span></li>
				<li class="active"><?=LABEL_CONSULTATIONS;?></li>
			</ul>
			
		</div> <!-- /.page-title -->
		
		<div class="row">

			<div class="span12">

				<!--- alert messagess ---->
				<?php $global_alerts->display(); ?>

			</div> <!-- /.span12 -->

            <div class="span7">

                <div class="widget widget-form">
						
                    <div class="widget-tabs">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#consulta"><i class="icon-user"></i> <?=LABEL_CONSULTATION;?></a>
                            </li>
                            <li>
                                <a href="#historico"><i class="icon-th-list"></i> <?=LABEL_CONSULTATIONS_HISTORY;?> <?=($history) ? '<span class="badge badge-warning">'.count($history).'</span>' : '';?></a>
                            </li>
                        </ul>
                        
                    </div> <!-- /.widget-tabs -->
                            
                    <div class="widget-content">
                        
                        <div class="tab-content">

                            <!-- Agregar Consulta -->
                            <div class="tab-pane active" id="consulta">
                        
                                <form action="./?mod=<?=ps('csu');?>" method="post" id="form-csu" class="form-horizontal" novalidate="novalidate">
                                <input type="hidden" name="cmd" value="<?=ps('update');?>">
                                <input type="hidden" name="id" value="<?=ps($record->id());?>">

                                    <fieldset>
                                        <div class="control-group">
                                            <label class="control-label" for="weight"><?=LABEL_PARAMS_WEIGHT;?></label>
                                            <div class="controls">
                                                <div class="input-append">
                                                    <input type="text" class="input input-small" id="weight" name="params[weight]" autocomplete="off" value="<?=$params->get("weight");?>" onchange="bmi(this.value, <?=$contact->get('height');?>);" <?=(!$edit) ? 'disabled': '';?>><span class="add-on">kg</span>
                                                </div>
												<div id="div_imc" style="font-size:1.2em;">
													<?=LABEL_PARAMS_BMI;?>: <span id="calc_imc"><?=$bmi;?></span>&nbsp;
													<i id="icon_imc_under" class="icon-arrow-down" style="display:none;padding-top:2px;"></i>
													<i id="icon_imc_ok" class="icon-ok" style="display:none;padding-top:2px;"></i>
													<i id="icon_imc_over" class="icon-arrow-up" style="display:none;padding-top:2px;"></i>
												</div>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="fc"><?=LABEL_PARAMS_HEART_RATE;?></label>
                                            <div class="controls">
                                                <div class="input-append">
                                                    <input type="text" class="input input-small" id="fc" name="params[fc]" autocomplete="off" value="<?=$params->get("fc");?>" <?=(!$edit) ? 'disabled': '';?>><span class="add-on">BPM</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="presis"><?=LABEL_PARAMS_BLOOD_PRESSURE;?></label>
											<div class="controls">
												<div class="input-prepend input-append">
													<span class="add-on"><?=LABEL_PARAMS_SYS_SHORT;?></span><input type="text" class="input input-mini" id="presis" name="params[presis]" autocomplete="off" value="<?=$params->get("presis");?>" <?=(!$edit) ? 'disabled': '';?>><span class="add-on">mmHg</span>
												</div>
												<div class="input-prepend input-append">
													<span class="add-on"><?=LABEL_PARAMS_DIA_SHORT;?></span><input type="text" class="input input-mini" id="predia" name="params[predia]" autocomplete="off" value="<?=$params->get("predia");?>" <?=(!$edit) ? 'disabled': '';?>><span class="add-on">mmHg</span>
												</div>
											</div>
                                        </div>
										<div class="control-group">
											<label class="control-label" for="glu"><?=LABEL_PARAMS_GLUCOSE;?></label>
											<div class="controls">
												<div class="input-append">
													<input type="text" class="input input-small" id="glu" name="params[glu]" autocomplete="off" value="<?=$params->get("glu");?>" <?=(!$edit) ? 'disabled': '';?>><span class="add-on">mg</span>
												</div>
											</div>
										</div>
                                        <div class="control-group">
                                            <label class="control-label" for="diagnosis"><?=LABEL_CONSULTATIONS_DIAGNOSIS;?></label>
                                            <div class="controls">
                                                <textarea class="input input-xlarge" rows="5" id="diagnosis" name="fields[diagnosis]" <?=(!$edit) ? 'disabled': '';?>><?=$record->get("diagnosis");?></textarea>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="notes"><?=LABEL_CONSULTATIONS_NOTES;?></label>
                                            <div class="controls">
                                                <textarea class="input input-xlarge" rows="5" id="notes" name="fields[notes]" <?=(!$edit) ? 'disabled': '';?>><?=$record->get("notes");?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-actions">
                                            <button type="button" class="btn btn-large" style="margin-left:0px;" onclick="window.location='./?mod=<?=ps('csu');?>';"><i class="icon-arrow-left"></i> <?=LABEL_FORMS_BACK;?></button>
                                            <?php if($edit) { ?>
                                                <button type="submit" class="btn btn-primary btn-large" style="margin-left:5px;"><i class="icon-hdd"></i> <?=LABEL_FORMS_SAVE;?></button>
                                            <?php } ?>
                                        </div>
                                    </fieldset>

                                </form>
                        
                            </div> <!-- /.tab-pane -->
                            
                            <!-- Histórico de Consultas -->
                            <div class="tab-pane" id="historico" style="min-height:200px;padding:15px;">
                                <?php include("consultations.history.php"); ?>
                            </div> <!-- /.tab-pane -->

                        </div> <!-- /.tab-content -->
                        
                    </div> <!-- /widget-content -->
                    
                </div> <!-- /widget -->

            </div><!-- ./span -->

            <div class="span5">

                <div class="widget widget-form">
                    
                    <div class="widget-header">
                        <h3>
                            <i class="icon-user"></i>
                            <?=LABEL_DETAILS;?>
                        </h3>

                    </div> <!-- /.widget-header -->
                    
                    <div class="widget-content">

                        <form action="./?mod=<?=ps('csu');?>" method="post" id="form-add" class="form-horizontal" novalidate="novalidate">
                            <input type="hidden" name="cmd" value="<?=ps('updatepat');?>">
                            <input type="hidden" name="id" value="<?=ps($record->id());?>">
                            <input type="hidden" name="pid" value="<?=ps($contact->id());?>">
                            <fieldset>
                                <div class="control-group">
                                    <label class="control-label" for="name"><?=LABEL_NAME;?></label>
                                    <div class="controls">
                                        <input type="text" name="name" id="name" class="input" autocomplete="off" value="<?=$contact->get("name");?>" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="email"><?=LABEL_EMAIL;?></label>
                                    <div class="controls">
                                        <input type="text" name="email" id="email" class="input" autocomplete="off" value="<?=$contact->get("email");?>" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="dob"><?=LABEL_DOB;?></label>
                                    <div class="controls">
                                        <input type="text" name="dob" id="dob" placeholder="yyyy-mm-dd" class="input input-small" autocomplete="off" value="<?=$contact->get("dob");?>" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="height"><?=LABEL_HEIGHT;?></label>
                                    <div class="controls">
                                        <input type="text" name="fields[height]" id="height" class="input input-small" autocomplete="off" value="<?=$contact->get("height");?>" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="sex"><?=LABEL_SEX;?></label>
                                    <div class="controls">
                                        <label class="radio"><input type="radio" name="fields[sex]" id="sexm" value="M" <?=($contact->get("sex")=="M") ? 'checked="checked"': '';?>> <?=LABEL_MALE;?></label>
                                        <label class="radio"><input type="radio" name="fields[sex]" id="sexf" value="F" <?=($contact->get("sex")=="F") ? 'checked="checked"': '';?>> <?=LABEL_FEMALE;?></label>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-primary">&nbsp;<i class="icon-hdd"></i> <?=LABEL_FORMS_UPDATE;?></button>
                                </div>
                            </fieldset>
                        </form>

                    </div> <!-- /.widget-content -->
                    
                </div> <!-- /.widget -->

            </div><!-- ./span4 -->

		</div> <!-- /.row -->

	</div> <!-- /.container -->
	
</div> <!-- /#content -->


<?php include("footer.php"); ?>