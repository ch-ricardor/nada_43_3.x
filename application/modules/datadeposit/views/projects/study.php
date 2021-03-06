<script type="text/javascript">
$(function() { 
/* Help Dialog */
	$('img[title="help"]').toggle(function() {
		$(this).parent().parent().parent().children('.HelpMsg').css('display', 'block');
	}, function() {
		$(this).parent().parent().parent().children('.HelpMsg').css('display', 'none');
	});
	 /* Message Box */
        $('div.success').delay(2000)
            .fadeOut('slow')
			.delay(200);
 });
</script>
						<style type="text/css">

.grid_three{width:100%;}

table.grid {

	border:0px solid gainsboro;

	border-collapse:collapse;

	background-color: none;

	width:100%;

}



table.grid th {

	border-width: 0px;

	font-size: 9pt !important;

	padding: 2px;

	background-color:#F0F0F0;

	text-align:left;

	border:1px solid gainsboro;

}

table.grid th.last, table.grid td.last{background:none;border:none;width:20px;}

table.grid td {

	border:1px solid gainsboro;

	padding:2px;

	margin:0px;

	background:white;

}

table.grid td input{border:0px;width:95%;position:relative;}

.right{float:right;}

.left{float:left;}

.addButton, .rembutton{border:none; background-color:#ccc; font-size:20px; font-weight:bold; width:20px; height:20px;margin:0px;}


label img {
	margin-left: 6px; 
}


.button-add,.button-del{background-color:#CCCCCC;font-size:11px;font-weight:bold;padding:2px;width:14px;height:14px;overflow:hidden;border:1px solid gainsboro;text-align:center;cursor:pointer;margin-left:3px;}

.button-del{background:none;border:1px solid gainsboro;}

.button-add:hover,.button-del:hover{background:black;color:white;}

    .folder {
        background-image: url(<?php echo base_url(); ?>/images/folder.png);
        background-repeat: no-repeat;
    }
	.HelpMsg, .HelpMsg pre {
		width: 40%;
	}
	
    .file {
        background-image: url(<?php echo base_url(); ?>/images/file_y.png);
        background-repeat: no-repeat;
    }
    .file_2 {
        background-image: url(<?php echo base_url(); ?>/images/file_n.png);
        background-repeat: no-repeat;
    }
    #files ul {
        list-style: none;
        padding-left: 20px;
        cursor: pointer;
        margin:7px 0 0 7px;
    }
    #files ul li.mainLi{
        margin:0px;
    }
    #files ul li{
        padding-left: 20px;
        margin: 2px;
    }
    #files li ul{
        margin-left: -30px;
        margin-bottomx:7px;
    }
    .hide{display:none;}
    #files{
        border:1px solid #CCC;
        width:26.5%;
        min-height: 600px;
        float:left;
    }
    #files-content{
        width:73%;
        min-height: 400px;
        float:right;
        border:1px solid gainsboro;
    }
	.submit {
		position: relative;
		right: 100px;
	}
    #files-content label{
        backgroundx:#CCC;
        display:block;
        margin:5px 0px;
        padding:3px;
        font-weight:bold;
    }
    legend{font-weight: normal; font-size: 11pt;color:#900; margin-left:14px;}
    fieldset{border:0px solid #CCC; margin-bottom:8px; width: 76%}
    input[type=submit], input[type=submit]:hover{margin-left:20px; margin-top:5px;}
    
    .field-expanded,.always-visible{background-color:#F8F8F8;border:1px solid gainsboro;margin-top:5px;margin-bottom:10px;margin-right:8px;}
    .always-visible{padding:10px;}
    .field-expanded .field, .always-visible .field {padding:5px;}
    .field-expanded legend, .field-collapsed legend, .always-visible legend{background:white;padding-left:5px;padding-right:5px;font-weight:bold; cursor:pointer}
    .field-collapsed{background:none; border:0px;border-top:1px solid gainsboro;margin-top:5px;margin-bottom:5px;}
    .field-collapsed legend {background-image:url(images/next.gif); background-position:left top; padding-left:20px;background-repeat:no-repeat;}
    .field-collapsed .field{display:none;}
    .field-expanded .field label, .always-visible label{font-weight:normal;}
    
	.field label { 
		font-size: 10pt; 			
		font-weight: bold !important;
	}
    .scroll {height:500px; overflow:scroll;}

    .page-links .tab{color:gray;margin-left:10px;}
    .page-links .tab:hover{color:maroon;}
    .page-links {border-bottom:1px solid gainsboro;padding-bottom:5px;margin-bottom:-1px;}  
    .page-links .active{border:1px solid gainsboro;padding:5px;border-bottom:1px solid white;color:black;}

    textarea{min-height:90px;}

    .required{color:#F00; font-weight:bold; font-size:15px;}
    .grey-module ul li ul li { font-size: 9.6pt }
</style>
<script type="text/javascript">

$(function(){
$('.button-del').click(function() {
	$(this).parent().parent().remove();
});
(function($) {
    $.fn.checkChanges = function(message, grid) {
        var _self  = this;
		var events = (grid) ? 'click' : 'keyup change keydown'; 
        $(_self).bind(events, function(e) {
            $(this).addClass('changedInput');
        });
        	$(window).bind('beforeunload ', function() {
         		if ($('.changedInput').length) {
                	return message;
            	}
        	});
    };
})(jQuery);

$('input[value="Save"]').click(function() {
	$('.changedInput').removeClass('changedInput');
});
		
$('input, textarea, select, option').checkChanges('Your data will be unsaved.', false);
$('.button-add').checkChanges('Your data will be unsaved.', true);

$("#navigation").treeview({
	collapsed: false,
	persist: "location"
	});
});
</script>
<h2><?php echo '<em>', $project[0]->title, '</em>', ' Project Study'; ?></h2>
<?php $message=isset($message)?$message:$this->session->flashdata('message');?>
<?php echo ($message!="") ? '<div class="success">'.$message.'</div>' : '';?> 
<?php // TODO: make this stay in one place with javascript ?> 
<div style="float:right;width:20%;margin-top:50px;" class="grey-module" id="stpModule">
    <div class="m-head"> 
        <h2>Projects</h2>
    </div>
    <div class="m-body">
    <ul>
    <?php foreach ($projects as $list): ?>
    	<li><a href="<?php echo site_url(), '/projects/study/', $list->id;?>" ><?php echo $list->title; ?></a></li>
    <?php endforeach; ?>
    </ul>
    </div><div class="m-footer"><span>&nbsp;</span></div>
</div>
<div style="position:relative;float:right;clear:both;width:20%;" class="grey-module" id="Menu">
 		<div class="m-head">
        	<h2>Study Description</h2>
        </div>
        <div style="border:#F2F2F2 2px solid">
		<ul style="margin-left:10px" id="navigation">
			<li style="font-size:11pt" href="#"><a href="<?php echo current_url(); ?>#Identification">Identification</a>
            	<ul>
                	<li><a href="<?php echo current_url(); ?>#ident_title">Title</a></li>
                	<li><a href="<?php echo current_url(); ?>#ident_abbr">Abbreviation</a></li>
                	<li><a href="<?php echo current_url(); ?>#ident_study_type">Study Type</a></li>                 	
                    <li><a href="<?php echo current_url(); ?>#ident_ser_info">Series Information</a></li>                					
                    <li><a href="<?php echo current_url(); ?>#ident_trans_title">Translated title</a></li>
                	<li><a href="<?php echo current_url(); ?>#ident_id">ID Number</a></li>
               </ul>
            </li>
			<li style="font-size:11pt"><a href="<?php echo current_url(); ?>#Version">Version</a>
            	<ul>
					<li><a href="<?php echo current_url(); ?>#ver_desc">Description</a></li>                 	
    				<li><a href="<?php echo current_url(); ?>#ver_prod_date">Production Date</a></li>                					
  					  <li><a href="<?php echo current_url(); ?>#ver_notes">Notes</a></li>
                </ul>
            </li>
			<li style="font-size:11pt" href="#"><a href="<?php echo current_url(); ?>#Overview">Overview</a>
            	<ul>
<li><a href="<?php echo current_url(); ?>#overview_abstract">Abstract</a></li>                 	
                    <li><a href="<?php echo current_url(); ?>#overview_kind_of_data">Kind of Data</a></li>                					
                    <li><a href="<?php echo current_url(); ?>#overview_analysis">Unit of Analysis</a></li>
                	<li><a href="<?php echo current_url(); ?>#overview_methods">Impact Evaluation Methods</a></li>
                </ul>
            </li>
			<li style="font-size:11pt" href="#"><a href="<?php echo current_url(); ?>#Scope">Scope</a>
            	<ul>
                    <li><a href="<?php echo current_url(); ?>#scope_definition">Description of Scope</a></li>
                	<li><a href="<?php echo current_url(); ?>#scope_class">Topics Classifications</a></li>
                </ul>
            </li>
			<li style="font-size:11pt"><a href="<?php echo current_url(); ?>#Coverage">Coverage</a>
            	<ul>
<li><a href="#coverage_country">Country</a></li>                					
                    <li><a href="<?php echo current_url(); ?>#coverage_geo">Geographic Coverage</a></li>
                	<li><a href="<?php echo current_url(); ?>#coverage_universe">Universe</a></li>                </ul>
            </li>
			<li style="font-size:11pt" href="#"><a href="<?php echo current_url(); ?>#Producers_Sponsers">Producers and Sponsors</a>
            	<ul>
<li><a href="<?php echo current_url(); ?>#prod_s_investigator">Primary Investigator</a></li>                 	
                    <li><a href="<?php echo current_url(); ?>#prod_s_other_prod">Other Producers</a></li>                					
                    <li><a href="<?php echo current_url(); ?>#prod_s_funding">Funding</a></li>
                	<li><a href="<?php echo current_url(); ?>#prod_s_acknowledgements">Other Acknowledgements</a></li>                </ul>
            </li>
			<li style="font-size:11pt" href="#"><a href="<?php echo current_url(); ?>#Sampling">Sampling</a>
            	<ul>
<li><a href="<?php echo current_url(); ?>#sampling_procedure">Sampling Procedure</a></li>                 	
                    <li><a href="<?php echo current_url(); ?>#sampling_dev">Deviations from Sample Design</a></li>                					
                    <li><a href="<?php echo current_url(); ?>#sampling_rates">Response Rates</a></li>
                	<li><a href="<?php echo current_url(); ?>#sampling_weight">Weighting</a></li>               
                </ul>
            </li>
			<li style="font-size:11pt" href="#"><a href="<?php echo current_url(); ?>#Data_Collection">Data Collection</a>
            	<ul>
                	<li><a href="<?php echo current_url(); ?>#coll_dates">Dates of Data Collection</a></li>
                	<li><a href="<?php echo current_url(); ?>#coll_periods">Time Periods</a></li> 
                	<li><a href="<?php echo current_url(); ?>#coll_mode">Mode of Data Collection</a></li>
                	<li><a href="<?php echo current_url(); ?>#coll_notes">Notes on Data Collection</a></li>
                	<li><a href="<?php echo current_url(); ?>#coll_questionnaire">Questionnaires</a></li> 
                	<li><a href="<?php echo current_url(); ?>#coll_collectors">Data Collectors</a></li>                	
                    <li><a href="<?php echo current_url(); ?>#coll_supervision">Supervision</a></li>                                      
                </ul>
            </li>
			<li style="font-size:11pt" href="#"><a href="<?php echo current_url(); ?>#Data_Processing">Data Processing</a>
            	<ul>
                	<li><a href="<?php echo current_url(); ?>#process_editing">Data Editing</a></li>                	
                    <li><a href="<?php echo current_url(); ?>#process_other">Other Processing</a></li>               
               </ul>
            </li>
			<li style="font-size:11pt" href="#"><a href="<?php echo current_url(); ?>#Data_Appraisal">Data Appraisal</a>
            	<ul>
                	<li><a href="<?php echo current_url(); ?>#appraisal_error">Estimates of Sampling Error</a></li>                	
                    <li><a href="<?php echo current_url(); ?>#appraisal_other">Other Forms of Data Appraisal</a></li> 
                                    </ul>
            </li>
			<li style="font-size:11pt"><a href="<?php echo current_url(); ?>#Data_Access">Data Access</a>
            	<ul>
	<li><a href="<?php echo current_url(); ?>#access_authority">Access Authority</a></li>
                	<li><a href="<?php echo current_url(); ?>#access_confidentiality">Confidentiality</a></li> 
                	<li><a href="<?php echo current_url(); ?>#access_conditions">Access Conditions</a></li>                	
                    <li><a href="<?php echo current_url(); ?>#access_cite_require">Citations Requirement</a></li>
                                    </ul>
            </li>
			<li style="font-size:11pt" href="#"><a href="<?php echo current_url(); ?>#Disclaimer">Disclaimer and Copyright</a>
            	<ul>
                	<li><a href="<?php echo current_url(); ?>#disclaimer_disclaimer">Disclaimer</a></li>                	
                    <li><a href="<?php echo current_url(); ?>#disclaimer_copyright">Copyright</a></li>                </ul>
            </li>
			<li style="font-size:11pt" href="#"><a href="<?php echo current_url(); ?>#Contacts">Contacts</a>
            	<ul>
                    <li><a href="<?php echo current_url(); ?>#contacts_contacts">Contact Persons</a></li>                </ul>
            </li>
        </ul>
        </div>
    <div class="m-footer"><span>&nbsp;</span></div>
</div>
<?php echo form_open("projects/study/{$project[0]->id}", "id='form'"); ?>
                <div class="submit field" style="text-align:right;margin:5px 20px;">
                    <input type="submit" name="study" value="Save" class="button"/>
                    <a class="btn_cancel" href="<?php echo site_url('projects');?>">Cancel</a>
                </div>                
                <?php //if($select == 'identification' || isset($all))://switch($select): case 'identification': ?>
                <fieldset class="field-expanded">
                <legend id="Identification"><?php echo t('identification'); ?></legend>
                
                    <div class="field">
                        <label id="ident_title" for="ident_title"><?php echo t('title'); ?><a class="titlHelp" href="" onclick="return false;"><img src="images/icon_question.gif"  alt="help" title="help"/></a></label>
                        <div class="HelpMsg titlHelpMsg" style="display:none;">
                        <?php echo wordwrap(t('titl'),80); ?>
                        </div>
                        <input readonly="readonly" type="text" name="ident_title" class="input-flex" value="<?php echo isset($row[0]->ident_title) ? $row[0]->ident_title : ''; ?>"/>
                    </div>
                    <div class="field">
                        <label id="ident_abbr" for="ident_abbr"><?php echo t('abbreviation'); ?><a class="altTitlHelp" href="" onclick="return false;"><img src="images/icon_question.gif"  alt="help" title="help"/></a></label>
                        <div class="HelpMsg altTitlHelpMsg" style="display:none">
                        <?php echo wordwrap(t('altTitl'),80); ?>
                        </div>
                        <input type="text" name="ident_abbr" class="input-flex" value="<?php echo isset($row[0]->ident_abbr)?$row[0]->ident_abbr:''; ?>"/>
                    </div>	
                    <div class="field">
                        <label id="ident_study_type" for="ident_study_type" ><?php echo t('study_type'); ?><a class="serNameHelp" href="" onclick="return false;"><img src="images/icon_question.gif"  alt="help" title="help"/></a></label>
                        <div class="HelpMsg serNameHelpMsg" style="display:none">
                        <?php echo wordwrap(t('serName'),80); ?>
                        </div>
                        <br />
                        <?php echo form_dropdown('ident_study_type', $studytype, isset($row[0]->ident_study_type)?$row[0]->ident_study_type:''); ?>
                        
                    </div>	
                    <div class="field">
                        <label id="ident_ser_info" for="ident_ser_info"><?php echo t('series_information'); ?><a class="serInfoHelp" href="" onclick="return false;"><img src="images/icon_question.gif"  alt="help" title="help"/></a></label>
                        <div class="HelpMsg serInfoHelpMsg" style="display:none">
                        <?php echo wordwrap(t('serInfo'),80); ?>
                        </div>
                        <textarea  name="ident_ser_info" cols="30" class="input-flex"><?php echo isset($row[0]->ident_ser_info)?$row[0]->ident_ser_info:''; ?></textarea>
                    </div>
                    <div class="field">
                        <label id="ident_trans_title" for="ident_trans_title"><?php echo t('translated_title'); ?><a class="parTitlHelp" href="" onclick="return false;"><img src="images/icon_question.gif"  alt="help" title="help"/></a></label>
                        <div class="HelpMsg parTitlHelpMsg" style="display:none">
                        <?php echo wordwrap(t('parTitl'),80); ?>
                        </div>
                        <input type="text" name="ident_trans_title" class="input-flex" value="<?php echo isset($row[0]->ident_trans_title)?$row[0]->ident_trans_title:''; ?>"/>
                    </div>
                    <div class="field">
                        <label id="ident_id" for="ident_id"><?php echo t('id_number'); ?><a class="IDNoHelp" href="" onclick="return false;"><img src="images/icon_question.gif"  alt="help" title="help"/></a></label>
                        <div class="HelpMsg IDNoHelpMsg" style="display:none">
                        <?php echo wordwrap(t('IDNo'),80); ?>
                        </div>
                        <input type="text" name="ident_id" class="input-flex" value="<?php echo isset($row[0]->ident_id)?$row[0]->ident_id:''; ?>"/>
                    </div>
                </fieldset>
                <?php //endif;//break;?>
                
                <?php //if($select == 'version' || isset($all))://case 'version': ?>
                <fieldset class="field-expanded">
                <legend id="Version"><?php echo t('versions'); ?> </legend>
                    <div class="field">
                        <label id="ver_desc" for="ver_desc"><?php echo t('description'); ?><a class="versionHelp" href="" onclick="return false;"><img src="images/icon_question.gif"  alt="help" title="help"/></a></label>
                        <div class="HelpMsg versionHelpMsg" style="display:none">
                        <?php echo wordwrap(t('version'),80); ?>
                        </div>
                        <textarea name="ver_desc" cols="30" rows="5" class="input-flex"><?php echo isset($row[0]->ver_desc)?$row[0]->ver_desc:''; ?></textarea>
                    </div>
                    <?php 
					if(isset($row[0]->ver_prod_date)){
					$v_idate = explode("-", $row[0]->ver_prod_date);
					}
					?>
                    <div class="field">
                        <label id="version_idate" for="version_idate"><?php echo t('production_date'); ?><a class="version_idateHelp" href="" onclick="return false;"><img src="images/icon_question.gif"  alt="help" title="help"/></a></label>
                        <div class="HelpMsg version_idateHelpMsg" style="display:none">
                        <?php echo wordwrap(t('version_idate'),80); ?>
                        </div>
                        <br />
                        <span style="margin:0 4px;">YYYY:</span><input size="4" maxlength="4" name="ver_prod_date_year" type="text" id="dcdate" size="50" class="input-flexx"  value="<?php echo isset($v_idate[0])?$v_idate[0]:''; ?>"/>
                        <span style="margin:0 4px;">MM:</span><input size="2" maxlength="2" name="ver_prod_date_month" type="text" id="dcdate" size="50" class="input-flexx"  value="<?php echo isset($v_idate[1])?$v_idate[1]:''; ?>"/>
                        <span style="margin:0 4px;">DD:</span><input size="2" maxlength="2" name="ver_prod_date_day" type="text" id="dcdate" size="50" class="input-flexx"  value="<?php echo isset($v_idate[2])?$v_idate[2]:''; ?>"/>
                    </div>
                    <div class="field">
                        <label id="ver_notes" for="ver_notes"><?php echo t('notes'); ?><a class="notesHelp" href="" onclick="return false;"><img src="images/icon_question.gif"  alt="help" title="help"/></a></label>
                        <div class="HelpMsg notesHelpMsg" style="display:none">
                        <?php echo wordwrap(t('version_notes'),80); ?>
                        </div>
                        <textarea name="ver_notes" cols="30" rows="5" class="input-flex"><?php echo isset($row[0]->ver_notes)?$row[0]->ver_notes:''; ?></textarea>
                    </div>
                </fieldset>
                <?php //endif;//break;?>
                
                <?php //if($select == 'overview' || isset($all))://case 'overview': ?>
                <fieldset class="field-expanded">
                <legend id="Overview"><?php echo t('overview'); ?> </legend>
                    <div class="field">
                        <label id="overview_abstract" for="overview_abstract"><?php echo t('abstract'); ?><a class="abstractHelp" href="" onclick="return false;"><img src="images/icon_question.gif"  alt="help" title="help"/></a></label>
                        <div class="HelpMsg abstractHelpMsg" style="display:none">
                        <?php echo wordwrap(t('overview_abstract'),80); ?>
                        </div>
                        <textarea name="overview_abstract" cols="30" rows="5" class="input-flex"><?php echo isset($row[0]->overview_abstract)?$row[0]->overview_abstract:''; ?></textarea>
                    </div>
                    <div class="field">
                        <label id="overview_kind_of_data" for="overview_kind_of_data"><?php echo t('kind_of_data'); ?><a class="dataKindHelp" href="" onclick="return false;"><img src="images/icon_question.gif"  alt="help" title="help"/></a></label>
                        <div class="HelpMsg dataKindHelpMsg" style="display:none">
                        <?php echo wordwrap(t('dataKind'),80); ?>
                        </div>
                        <br />
                        <?php echo form_dropdown('overview_kind_of_data', $kindofdata, isset($row[0]->overview_kind_of_data)?$row[0]->overview_kind_of_data:''); ?> 
                    </div>
                    <div class="field">
                        <label id="overview_analysis" for="overview_analysis"><?php echo t('unit_of_analysis'); ?><a class="anlyUnitHelp" href="" onclick="return false;"><img src="images/icon_question.gif"  alt="help" title="help"/></a></label>
                        <div class="HelpMsg anlyUnitHelpMsg" style="display:none">
                        <?php echo wordwrap(t('anlyUnit'),80); ?>
                        </div>
                        <textarea name="overview_analysis" cols="30" rows="5" class="input-flex"><?php echo isset($row[0]->overview_analysis)?$row[0]->overview_analysis:''; ?></textarea>
                    </div>
                    <div class="field">
                        <label id="overview_methods" for="overview_methods"><?php echo t('impact_evaluation_methods'); ?><a class="impactEvalHelp" href="" onclick="return false;"><img src="images/icon_question.gif"  alt="help" title="help"/></a></label>
                        <div class="HelpMsg impactEvalHelpMsg" style="display:none">
                        <?php echo wordwrap(t('impactEval'),80); ?>
                        </div>
						<?php echo $methods; ?>
                    </div>
                </fieldset>
                <?php //endif;//break;?>
                
                <?php //if($select == 'scope' || $select == 'all')://case 'scope': ?>
                <fieldset class="field-expanded">
                <legend id="Scope"><?php echo t('scope'); ?> </legend>
                    <div class="field">
                        <label id="scope_definition" for="scope_definition"><?php echo t('description_of_scope'); ?><a class="scope_notesHelp" href="" onclick="return false;"><img src="images/icon_question.gif"  alt="help" title="help"/></a></label>
                        <div class="HelpMsg scope_notesHelpMsg" style="display:none">
                        <?php echo wordwrap(t('scope_notes'),80); ?>
                        </div>
                        <textarea name="scope_definition" cols="30" rows="5" class="input-flex"><?php echo isset($row[0]->scope_definition)?$row[0]->scope_definition:''; ?></textarea>
                    </div>
                    <div class="field">
                        <label id="scope_class" for="scope_class"><?php echo t('topics_classifications'); ?><a class="topcClasHelp" href="" onclick="return false;"><img src="images/icon_question.gif"  alt="help" title="help"/></a></label>
                        <div class="HelpMsg topcClasHelpMsg" style="display:none">
                        <?php echo wordwrap(t('topcClas'),80); ?>
                        </div>
						<?php echo $topic_class ?>
                    </div>
                </fieldset>
                <?php //endif;//break;?>
                
                <?php //if($select == 'coverage' || $select == 'all')://case 'coverage': ?>
                <fieldset class="field-expanded">
                <legend id="Coverage"><?php echo t('coverage'); ?> </legend>
                    <div class="field">
                        <label id="coverage_country" for="coverage_country"><?php echo t('country'); ?><a class="nationHelp" href="" onclick="return false;"><img src="images/icon_question.gif"  alt="help" title="help"/></a></label>
                        <div class="HelpMsg nationHelpMsg" style="display:none">
                        <?php echo wordwrap(t('nation'),80); ?>
                        </div>
						<?php echo $country ?>
                    </div>
                    <div class="field">
                        <label id="coverage_geo" for="coverage_geo"><?php echo t('geographic_coverage'); ?><a class="geogCoverHelp" href="" onclick="return false;"><img src="images/icon_question.gif"  alt="help" title="help"/></a></label>
                        <div class="HelpMsg geogCoverHelpMsg" style="display:none">
                        <?php echo wordwrap(t('geogCover'),80); ?>
                        </div>
                        <textarea name="coverage_geo" cols="30" rows="5" class="input-flex"><?php echo isset($row[0]->coverage_geo)?$row[0]->coverage_geo:''; ?></textarea>
                    </div>
                    <div class="field">
                        <label id="coverage_universe" for="coverage_universe"><?php echo t('universe'); ?><a class="universeHelp" href="" onclick="return false;"><img src="images/icon_question.gif"  alt="help" title="help"/></a></label>
                        <div class="HelpMsg universeHelpMsg" style="display:none">
                        <?php echo wordwrap(t('country_universe'),80); ?>
                        </div>
                        <textarea name="coverage_universe" cols="30" rows="5" class="input-flex"><?php echo isset($row[0]->coverage_universe)?$row[0]->coverage_universe:''; ?></textarea>
                    </div>
                </fieldset>
                <?php //endif;//break;?>
                
                <?php //if($select == 'producers_sponsors' || $select == 'all')://case 'producers_sponsors': ?>
                <fieldset class="field-expanded">
                <legend id="Producers_Sponsers"><?php echo t('producers_and_sponsors'); ?></legend>
                    <div class="field">
                        <label id="prod_s_investigator" for="prod_s_investigator"><?php echo t('primary_investigator'); ?><a class="AuthEntyHelp" href="" onclick="return false;"><img src="images/icon_question.gif"  alt="help" title="help"/></a></label>
                        <div class="HelpMsg AuthEntyHelpMsg" style="display:none">
                        <?php echo wordwrap(t('AuthEnty'),80); ?>
                        </div>
						<?php echo $prim_investigator; ?>
                    </div>
                     <div class="field">
                        <label id="prod_s_other_prod" for="prod_s_other_prod"><?php echo t('other_producers'); ?><a class="producerHelp" href="" onclick="return false;"><img src="images/icon_question.gif"  alt="help" title="help"/></a></label>
                        <div class="HelpMsg producerHelpMsg" style="display:none">
                        <?php echo wordwrap(t('producers'),80); ?>
                        </div>
						<?php echo $other_producers; ?>
                    </div>
                    <div class="field">
                        <label id="prod_s_funding" for="prod_s_funding"><?php echo t('funding'); ?><a class="fundAgHelp" href="" onclick="return false;"><img src="images/icon_question.gif"  alt="help" title="help"/></a></label>
                        <div class="HelpMsg fundAgHelpMsg" style="display:none">
                        <?php echo wordwrap(t('fundAg'),80); ?>
                        </div>
						<?php echo $funding; ?>
                    </div>
                    <div class="field">
                        <label id="prod_s_acknowledgements" for="prod_s_acknowledgements"><?php echo t('other_acknowledgements'); ?><a class="othld_pHelp" href="" onclick="return false;"><img src="images/icon_question.gif"  alt="help" title="help"/></a></label>
                        <div class="HelpMsg othld_pHelpMsg" style="display:none">
                        <?php echo wordwrap(t('othId_p'), 80); ?>
                        </div>
						<?php echo $acknowledgements; ?>
                    </div>
                </fieldset>
                <?php //endif;//break;?>
                
                <?php //if($select == 'sampling' || $select == 'all')://case 'sampling': ?>
                <fieldset class="field-expanded">
                <legend id="Sampling"><?php echo t('sampling'); ?> </legend>
                    <div class="field">
                        <label id="sampling_procedure" for="sampling_procedure"><?php echo t('sampling_procedure'); ?><a class="sampProcHelp" href="" onclick="return false;"><img src="images/icon_question.gif"  alt="help" title="help"/></a></label>
                        <div class="HelpMsg sampProcHelpMsg" style="display:none">
                        <?php echo wordwrap(t('sampProc'), 80); ?>
                        </div>
                        <textarea name="sampling_procedure" cols="30" rows="8" class="input-flex"><?php echo isset($row[0]->sampling_procedure)?$row[0]->sampling_procedure:''; ?></textarea>
                    </div>
                     <div class="field">
                        <label id="sampling_dev" for="sampling_dev"><?php echo t('deviations_from_sample_design'); ?><a class="deviatHelp" href="" onclick="return false;"><img src="images/icon_question.gif"  alt="help" title="help"/></a></label>
                        <div class="HelpMsg deviatHelpMsg" style="display:none">
                        <?php echo wordwrap(t('deviat'), 80); ?>
                        </div>
                        <textarea name="sampling_dev" cols="30" rows="5" class="input-flex"><?php echo isset($row[0]->sampling_dev)?$row[0]->sampling_dev:''; ?></textarea>
                    </div>
                    <div class="field">
                        <label id="sampling_rates" for="sampling_rates"><?php echo t('response_rates'); ?><a class="respRateHelp" href="" onclick="return false;"><img src="images/icon_question.gif"  alt="help" title="help"/></a></label>
                        <div class="HelpMsg respRateHelpMsg" style="display:none">
                        <?php echo wordwrap(t('respRate'), 80); ?>
                        </div>
                        <textarea name="sampling_rates" cols="30" rows="5" class="input-flex"><?php echo isset($row[0]->sampling_rates)?$row[0]->sampling_rates:''; ?></textarea>
                    </div>
                    <div class="field">
                        <label id="sampling_weight" for="sampling_weight"><?php echo t('weighting'); ?><a class="weightHelp" href="" onclick="return false;"><img src="images/icon_question.gif"  alt="help" title="help"/></a></label>
                        <div class="HelpMsg weightHelpMsg" style="display:none">
                        <?php echo wordwrap(t('weight'), 80); ?>
                        </div>
                        <textarea name="sampling_weight" cols="30" rows="5" class="input-flex"><?php echo isset($row[0]->sampling_weight)?$row[0]->sampling_weight:''; ?></textarea>
                    </div>
                </fieldset>
                <?php //endif;//break;?>
                
                <?php //if($select == 'data_collection' || $select == 'all')://case 'data_collection': ?>
                <fieldset class="field-expanded">
                <legend id="Data_Collection"><?php echo t('data_collection'); ?> </legend>
                    <div class="field">
                        <label id="coll_dates" for="coll_dates"><?php echo t('dates_of_data_collection'); ?> (yyyy/mm/dd)<a class="collDateHelp" href="" onclick="return false;"><img src="images/icon_question.gif"  alt="help" title="help"/></a></label>
                        <div class="HelpMsg collDateHelpMsg" style="display:none">
                        <?php echo wordwrap(t('collDate'), 80); ?>
                        </div>
						<?php echo $dates_datacollection; ?>
                    </div>
                     <div class="field">
                        <label id="coll_periods" for="coll_periods"><?php echo t('time_periods'); ?>(yyyy/mm/dd)<a class="timePrdHelp" href="" onclick="return false;"><img src="images/icon_question.gif"  alt="help" title="help"/></a></label>
                        <div class="HelpMsg timePrdHelpMsg" style="display:none">
                        <?php echo wordwrap(t('timePrd'), 80); ?>
                        </div>
						<?php echo $time_periods; ?>
                    </div>
                    <div class="field">
                        <label id="coll_mode" for="coll_mode" ><?php echo t('mode_of_data_collection'); ?><a class="collModeHelp" href="" onclick="return false;"><img src="images/icon_question.gif"  alt="help" title="help"/></a></label>
                        <div class="HelpMsg collModeHelpMsg" style="display:none">
                        <?php echo wordwrap(t('collMode'), 80); ?>
                        </div>
                        <select name="coll_mode">
<option value="<?php echo isset($row[0]->coll_mode)?$row[0]->coll_mode:''; ?>"> <?php echo isset($row[0]->coll_mode)?$row[0]->coll_mode:''; ?> </option>
<option value="Computer Assisted Personal Interview [capi]">Computer Assisted Personal Interview [capi]</option>
<option value="Computer Assisted Telephone Interview [cati]">Computer Assisted Telephone Interview [cati]</option>
<option value="Face-to-face [f2f]">Face-to-face [f2f]</option>
<option value="Mail Questionnaire [mail]">Mail Questionnaire [mail]</option>
<option value="Focus Group [foc]">Focus Group [foc]</option>
<option value="Internet [int]">Internet [int]</option>
<option value="Other [oth]">Other [oth]</option>
</select>                                      </div>
                    <div class="field">
                        <label id="coll_notes" for="coll_notes"><?php echo t('notes_on_data_collection'); ?><a class="collSituHelp" href="" onclick="return false;"><img src="images/icon_question.gif"  alt="help" title="help"/></a></label>
                        <div class="HelpMsg collSituHelpMsg" style="display:none">
                        <?php echo wordwrap(t('collSitu'),80); ?>
                        </div>
                        <textarea name="coll_notes" cols="30" rows="5" class="input-flex"><?php echo isset($row[0]->coll_notes)?$row[0]->coll_notes:''; ?></textarea>
                    </div>
                    <div class="field">
                        <label id="coll_questionnaire" for="coll_questionnaire"><?php echo t('questionnaires'); ?><a class="resInstruHelp" href="" onclick="return false;"><img src="images/icon_question.gif"  alt="help" title="help"/></a></label>
                        <div class="HelpMsg resInstruHelpMsg" style="display:none">
                        <?php echo wordwrap(t('resInstru'),80); ?>
                        </div>
                        <textarea name="coll_questionnaire" cols="30" rows="5" class="input-flex"><?php echo isset($row[0]->coll_questionnaire)?$row[0]->coll_questionnaire:''; ?></textarea>
                    </div>
                     <div class="field">
                        <label id="coll_collectors" for="coll_collectors"><?php echo t('data_collectors'); ?><a class="dataCollectorHelp" href="" onclick="return false;"><img src="images/icon_question.gif"  alt="help" title="help"/></a></label>
                        <div class="HelpMsg dataCollectorHelpMsg" style="display:none">
                        <?php echo wordwrap(t('dataCollector'),80); ?>
                        </div>
						<?php echo $data_collectors; ?>
                    </div>
                    <div class="field">
                        <label id="coll_supervision" for="coll_supervision"><?php echo t('supervision'); ?><a class="actMinHelp" href="" onclick="return false;"><img src="images/icon_question.gif"  alt="help" title="help"/></a></label>
                        <div class="HelpMsg actMinHelpMsg" style="display:none">
                        <?php echo wordwrap(t('actMin'),80); ?>
                        </div>
                        <textarea name="coll_supervision" cols="30" rows="5" class="input-flex"><?php echo isset($row[0]->coll_supervision)?$row[0]->coll_supervision:''; ?></textarea>
                    </div>
                </fieldset>
                <?php //endif;//break;?>
                
                <?php //if($select == 'data_processing' || $select == 'all')://case 'data_processing': ?>
                <fieldset class="field-expanded">
                <legend id="Data_Processing"><?php echo t('data_processing'); ?> </legend>
                    <div class="field">
                        <label id="process_editing" for="process_editing"><?php echo t('data_editing'); ?><a class="cleanOpsHelp" href="" onclick="return false;"><img src="images/icon_question.gif"  alt="help" title="help"/></a></label>
                        <div class="HelpMsg cleanOpsHelpMsg" style="display:none">
                        <?php echo wordwrap(t('cleanOps'),80); ?>
                        </div>
                        <textarea name="process_editing" cols="30" rows="5" class="input-flex"><?php echo isset($row[0]->process_editing)?$row[0]->process_editing:''; ?></textarea>
                    </div>
                    <div class="field">
                        <label id="process_other" for="process_other"><?php echo t('other_processing'); ?><a class="method_notesHelp" href="" onclick="return false;"><img src="images/icon_question.gif"  alt="help" title="help"/></a></label>
                        <div class="HelpMsg method_notesHelpMsg" style="display:none">
                        <?php echo wordwrap(t('method_notes'),80); ?>
                        </div>
                        <textarea name="process_other" cols="30" rows="5" class="input-flex"><?php echo isset($row[0]->process_other)?$row[0]->process_other:''; ?></textarea>
                    </div>
                </fieldset>
                <?php //endif;//break;?>
                
                <?php //if($select == 'data_appraisal' || $select == 'all')://case 'data_appraisal': ?>
                <fieldset class="field-expanded">
                <legend id="Data_Appraisal"><?php echo t('data_appraisal'); ?> </legend>
                    <div class="field">
                        <label id="appraisal_error" for="appraisal_error"><?php echo t('estimates_of_sampling_error'); ?><a class="EstSmpErrHelp" href="" onclick="return false;"><img src="images/icon_question.gif"  alt="help" title="help"/></a></label>
                        <div class="HelpMsg EstSmpErrHelpMsg" style="display:none">
                        <?php echo wordwrap(t('EstSmpErr'),80); ?>
                        </div>
                        <textarea name="appraisal_error" cols="30" rows="5" class="input-flex"><?php echo isset($row[0]->appraisal_error)?$row[0]->appraisal_error:''; ?></textarea>
                    </div>
                    <div class="field">
                        <label id="appraisal_other" for="appraisal_other"><?php echo t('other_forms_of_data_appraisal'); ?><a class="dataApprHelp" href="" onclick="return false;"><img src="images/icon_question.gif"  alt="help" title="help"/></a></label>
                        <div class="HelpMsg dataApprHelpMsg" style="display:none">
                        <?php echo wordwrap(t('dataAppr'),80); ?>
                        </div>
                        <textarea name="appraisal_other" cols="30" rows="5" class="input-flex"><?php echo isset($row[0]->appraisal_other)?$row[0]->appraisal_other:''; ?></textarea>
                    </div>
                </fieldset>
               <?php //endif;//break;?>
                
                <?php //if($select == 'data_access' || $select == 'all')://case 'data_access': ?>
                <fieldset class="field-expanded">
                <legend id="Data_Access"><?php echo t('data_access'); ?> </legend>
                    <div class="field">
                        <label id="access_authority" for="access_authority"><?php echo t('access_authority'); ?><a class="useStmt_contactHelp" href="" onclick="return false;"><img src="images/icon_question.gif"  alt="help" title="help"/></a></label>
                        <div class="HelpMsg useStmt_contactHelpMsg" style="display:none">
                        <?php echo wordwrap(t('useStmt_contact'),80); ?>
                        </div>
						<?php echo $access_authority; ?>
                    </div>
                     <div class="field">
                        <label id="access_confidentiality" for="access_confidentiality"><?php echo t('confidentiality'); ?><a class="confDecHelp" href="" onclick="return false;"><img src="images/icon_question.gif"  alt="help" title="help"/></a></label>
                        <div class="HelpMsg confDecHelpMsg" style="display:none">
                        <?php echo wordwrap(t('confDec'),80); ?>
                        </div>
                        <textarea name="access_confidentiality" cols="30" rows="5" class="input-flex"><?php echo isset($row[0]->access_confidentiality)?$row[0]->access_confidentiality:''; ?></textarea>
                    </div>
                    <div class="field">
                        <label id="access_conditions" for="access_conditions"><?php echo t('access_conditions'); ?><a class="conditionsHelp" href="" onclick="return false;"><img src="images/icon_question.gif"  alt="help" title="help"/></a></label>
                        <div class="HelpMsg conditionsHelpMsg" style="display:none">
                        <?php echo wordwrap(t('conditions'),80); ?>
                        </div>
                        <textarea name="access_conditions" cols="30" rows="5" class="input-flex"><?php echo isset($row[0]->access_conditions)?$row[0]->access_conditions:''; ?></textarea>
                    </div>
                    <div class="field">
                        <label id="access_cite_require" for="access_cite_require"><?php echo t('citations_requirement'); ?><a class="citReqHelp" href="" onclick="return false;"><img src="images/icon_question.gif"  alt="help" title="help"/></a></label>
                        <div class="HelpMsg citReqHelpMsg" style="display:none">
                        <?php echo wordwrap(t('citReq'),80); ?>
                        </div>
                        <textarea name="access_cite_require" cols="30" rows="5" class="input-flex"><?php echo isset($row[0]->access_cite_require)?$row[0]->access_cite_require:''; ?></textarea>
                    </div>
                </fieldset>
                <?php //endif;//break;?>
                
                <?php //if($select == 'disclaimer_copyright' || $select == 'all')://case 'disclaimer_copyright': ?>
                <fieldset class="field-expanded">
                <legend id="Disclaimer"><?php echo t('disclaimer_and_copyright'); ?> </legend>
                    <div class="field">
                        <label id="disclaimer_disclaimer" for="disclaimer_disclaimer"><?php echo t('disclaimers'); ?><a class="disclaimerHelp" href="" onclick="return false;"><img src="images/icon_question.gif"  alt="help" title="help"/></a></label>
                        <div class="HelpMsg disclaimerHelpMsg" style="display:none">
                        <?php echo wordwrap(t('disclaimer'),80); ?>
                        </div>
                        <textarea name="disclaimer_disclaimer" cols="30" rows="5" class="input-flex"><?php echo isset($row[0]->disclaimer_disclaimer)?$row[0]->disclaimer_disclaimer:''; ?></textarea>
                    </div>
                    <div class="field">
                        <label id="disclaimer_copyright" for="disclaimer_copyright"><?php echo t('copyrights'); ?><a class="copyrightHelp" href="" onclick="return false;"><img src="images/icon_question.gif"  alt="help" title="help"/></a></label>
                        <div class="HelpMsg copyrightHelpMsg" style="display:none">
                        <?php echo wordwrap(t('copyright'),80); ?>
                        </div>
                        <input type="text" name="disclaimer_copyright" class="input-flex" value="<?php echo isset($row[0]->disclaimer_copyright)?$row[0]->disclaimer_copyright:''; ?>"/>
                    </div>
                </fieldset>
                <?php //endif;//break;?>
                
                <?php //if($select == 'contacts' || $select == 'all')://case 'contacts': ?>
                <fieldset class="field-expanded">
                <legend id="Contacts"><?php echo t('contacts'); ?> </legend>
                    <div class="field">
                        <label id="contacts_contacts" for="contacts_contacts"><?php echo t('contact_persons'); ?><a class="distStmt_contactHelp" href="" onclick="return false;"><img src="images/icon_question.gif"  alt="help" title="help"/></a></label>
                        <div class="HelpMsg distStmt_contactHelpMsg" style="display:none">
                        <?php echo wordwrap(t('distStmt_contact'),80); ?>
                        </div>
						<?php echo $contacts; ?>
                    </div>
                </fieldset>
                <?php //endif;//break;?>

                <?php //endswitch; ?>
                <?php // if($select): ?>
                <div class="submit field" style="text-align:right;margin:5px 20px;">
                    <input type="submit" name="study" value="Save" id="submit" class="button"/>
                    <a class="btn_cancel" href="<?php echo site_url('projects');?>">Cancel</a>
                </div>
                <?php //endif; ?>
                <br/>
<?php echo form_close(); ?>
                <?php /*                <fieldset class="field-expanded">

                <legend>Overview </legend>

                    <div class="field">

                        <label id="abstract" for="abstract">Abstract<a class="abstractHelp" href="" onclick="return false;"><img src="images/icon_question.gif"  alt="help" title="help"/></a></label>

                        <div class="HelpMsg abstractHelpMsg" style="display:none">

                        <pre>

The abstract should provide a clear summary of the purposes, objectives and content of the survey. It should be written
by a researcher or survey statistician aware of the survey.

</pre>

                        </div>

                        <textarea name="abstract" cols="30" rows="5" class="input-flex"><?php if (isset($study[0]->abstract)) echo $study[0]->abstract; ?></textarea>

                    </div>

                    <div class="field">

                        <label id="dataKind" for="dataKind">Kind of Data<a class="dataKindHelp" href="" onclick="return false;"><img src="images/icon_question.gif"  alt="help" title="help"/></a></label>

                        <div class="HelpMsg dataKindHelpMsg" style="display:none">

                        <pre>

This field is a broad classification of the data and it is associated with a drop down box providing controlled
vocabulary. That controlled vocabulary includes 9 items but is not limited to them.

</pre>

                        </div>

                        <select name="dataKind">
<option value="<?php if (isset($study[0]->data_type)) echo $study[0]->data_type; ?>" selected="selected"><?php if (isset($study[0]->data_type)) echo $study[0]->data_type; ?></option>
<option value="Sample survey data [ssd]">Sample survey data [ssd]</option>
<option value="Census/enumeration data [cen]">Census/enumeration data [cen]</option>
<option value="Administrative records data [adm]">Administrative records data [adm]</option>
<option value="Aggregate data [agg]">Aggregate data [agg]</option>
<option value="Clinical data [cli]">Clinical data [cli]</option>
<option value="Event/Transaction data [evn]">Event/Transaction data [evn]</option>
<option value="Observation data/ratings [obs]">Observation data/ratings [obs]</option>
<option value="Process-produced data [pro]">Process-produced data [pro]</option>
<option value="Time budget dairies [tbd]">Time budget dairies [tbd]</option>
</select> 

                    </div>

                    <div class="field">

                        <label id="anlyUnit" for="anlyUnit">Unit of Analysis<a class="anlyUnitHelp" href="" onclick="return false;"><img src="images/icon_question.gif"  alt="help" title="help"/></a></label>

                        <div class="HelpMsg anlyUnitHelpMsg" style="display:none">

                        <pre>

Basic unit(s) of analysis or observation that the study describes: individuals, families/households, groups, facilities,
institutions/organizations, administrative units, physical locations, etc.



Examples:

- A living standards survey with community-level questionnaire would have the following units of analysis: individuals,
households, and communities.

- An economic survey could have the firm and establishment as units of analysis.

</pre>

                        </div>

                        <textarea name="anlyUnit" cols="30" rows="5" class="input-flex"><?php if (isset($study[0]->unit_of_analysis)) echo $study[0]->unit_of_analysis; ?></textarea>

                    </div>
<div class="field">
                        <label id="impactEval" for="impactEval">Impact Evaluation Methods<a class="impactEvalHelp" href="" onclick="return false;"><img src="images/icon_question.gif" alt="help" title="help"></a></label>
                        <div class="HelpMsg impactEvalHelpMsg" style="display: none;">
                        impactEval                        </div>
						<style type="text/css">
.grid_three{width:100%;}
table.grid {
	border:0px solid gainsboro;
	border-collapse:collapse;
	background-color: none;
	width:100%;
}

table.grid th {
	border-width: 0px;
	padding: 2px;
	background-color:#F0F0F0;
	text-align:left;
	border:1px solid gainsboro;
}
table.grid th.last, table.grid td.last{background:none;border:none;width:20px;}
table.grid td {
	border:1px solid gainsboro;
	padding:2px;
	margin:0px;
	background:white;
}
table.grid td input{border:0px;width:95%;position:relative;}
.right{float:right;}
.left{float:left;}
.addButton, .rembutton{border:none; background-color:#ccc; font-size:20px; font-weight:bold; width:20px; height:20px;margin:0px;}


.button-add,.button-del{background-color:#CCCCCC;font-size:11px;font-weight:bold;padding:2px;width:14px;height:14px;overflow:hidden;border:1px solid gainsboro;text-align:center;cursor:pointer;margin-left:3px;}
.button-del{background:none;border:1px solid gainsboro;}
.button-add:hover,.button-del:hover{background:black;color:white;}
</style>

<script type="application/javascript">
$(function() {
	$('.button-del').click(function() {
		$(this).parent().parent().remove();
	});
});

function keyPressTest(e, obj)
{
  var validateChkb = document.getElementById('chkValidateOnKeyPress');
  if (validateChkb.checked) {
    var displayObj = document.getElementById('spanOutput');
    var key;
    if(window.event) {
      key = window.event.keyCode; 
    }
    else if(e.which) {
      key = e.which;
    } 
    var objId;
    if (obj != null) {
      objId = obj.id;
    } else {
      objId = this.id;
    }
    displayObj.innerHTML = objId + ' : ' + String.fromCharCode(key);
  }
}
function removeRowFromTableoverview()
{
  var tbl = document.getElementById('overview');
  var lastRow = tbl.rows.length;
  if (lastRow > 2) tbl.deleteRow(lastRow - 1);
}

</script>

<?php echo $method ?>
<?php echo form_submit('study', 'Submit'); */?> 