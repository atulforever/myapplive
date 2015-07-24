<?php include("php/session.php"); ?>
<?php include("php/db.php"); ?>
<?php include("php/rights.php"); ?>
<?php $UserType = $_SESSION["UserType"]; ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
</head>
<body>
<div id="add_contact_type_grid_div">
<table id="tadd_contact_type_ds_list"></table>
</div>
<div id="add_contact_type_pager"></div>

<script type="text/javascript"> 
jQuery().ready(function (){

jQuery("input:button, input:submit, input:reset").button();

jQuery("#tadd_contact_type_ds_list").jqGrid({
   	url:'php/add_contact_type.php',
	datatype: "json",
   	colNames:['Id','Contact Type','Comments'],
   	height: "auto",
	colModel:[
   		{name:'id',index:'id',hidden:true, width:15, jsonmap:'id'},
   		{name:'contact_type',editable:true, index:'contact_type', width:90, align:"center", jsonmap:'contact_type'},
   		{name:'COMMENTS', editable:true, index:'comments', width:80, align:"center", jsonmap:'comments'}
   	
   	],
   	rowNum:20,
	rownumbers: true,
	height: "100%",
   	autowidth: true,
   	rowList:[10,20,30,50,100],
   	pager: '#add_contact_type_pager',
   	sortname: 'id',
    viewrecords: true,
    sortorder: "desc",
	jsonReader: { repeatitems : false, id: "0" },
	multiselect: true, 
    caption:"LIST CATEGORY",
	editurl:"php/general.php?cmd=delete&table=add_contact_type"
});
var deladd_contact_type = false;
<?php if(in_array('ADD_CONTACT_TYPE', $deleteLink)){ ?>
	deladd_contact_type = true;
<?php } ?>
jQuery("#tadd_contact_type_ds_list").jqGrid('navGrid','#add_contact_type_pager',{edit:false,add:false,del:deladd_contact_type,search:false},{},{},{},{multipleSearch:false});


var tadd_contact_type_ds_form_contact_type = $("#tadd_contact_type_ds_form_contact_type"),
tadd_contact_type_ds_form_comments = $("#tadd_contact_type_ds_form_comments");

allFieldsADD_CONTACT_TYPE = $([]).add(tadd_contact_type_ds_form_contact_type).add(tadd_contact_type_ds_form_comments);
tips = $("#tadd_contact_type_ds_error");
//add button
<?php if(in_array('ADD_CONTACT_TYPE', $addLink)){ ?>
jQuery("#tadd_contact_type_ds_list").jqGrid('navButtonAdd','#add_contact_type_pager',{caption:"Add",
	onClickButton:function(){
		editID = "";		
		allFieldsADD_CONTACT_TYPE.val('').removeClass('ui-state-error');
		jQuery("#tadd_contact_type_ds_error").html("* Fields are mendatory");
		jQuery("#add_contact_type_form_div").css("display","inline");
		jQuery("#add_contact_type_grid_div").css("display","none");		
		tadd_contact_type_ds_form_contact_type.focus();			
	} 
});
<?php } ?>
<?php if(in_array('ADD_CONTACT_TYPE', $editLink)){ ?>
jQuery("#tadd_contact_type_ds_list").jqGrid('navButtonAdd','#add_contact_type_pager',{caption:"Edit",
	onClickButton:function(){
		var gsr = jQuery("#tadd_contact_type_ds_list").jqGrid('getGridParam','selarrrow');
		if(gsr.length > 0){
			if(gsr.length > 1){
				$("#add_contact_typeDialog").html("Please Select Only One Row");
				$("#add_contact_typeDialog").dialog("open");
			}
			else{
				editID = gsr[0];
				edit("add_contact_type");
				jQuery("#add_contact_type_form_div").css("display","inline");
				jQuery("#add_contact_type_grid_div").css("display","none");
			}
		} else {
			$("#add_contact_typeDialog").html("Please Select Row");
			$("#add_contact_typeDialog").dialog("open");
		}							
	} 
});
<?php } ?>
<?php if(in_array('ADD_CONTACT_TYPE', $exportLink)){ ?>
jQuery("#tadd_contact_type_ds_list").jqGrid('navButtonAdd','#add_contact_type_pager',{caption:"Export",
	onClickButton:function(){
		exportExcel('tadd_contact_type_ds_list','add_contact_type');
	} 
});
<?php } ?>
jQuery("#addBtnadd_contact_type").click(function(){	
	//validation
	var bValid = true;
	allFieldsADD_CONTACT_TYPE.removeClass('ui-state-error');
	bValid = bValid && checkNull(tadd_contact_type_ds_form_contact_type,"CONTACT TYPE");	//check Name for null value
		
	if (bValid) {
		if(editID == ""){
			addRecord("php/add_contact_type.php?cmd=insert","add_contact_type_grid_div", "add_contact_type_form_div", "tadd_contact_type_ds_list","add_contact_typeDialog","tadd_contact_type_ds_error", allFieldsADD_CONTACT_TYPE);
		}else{
			editRecord("php/add_contact_type.php?cmd=update","add_contact_type_grid_div", "add_contact_type_form_div", "tadd_contact_type_ds_list","add_contact_typeDialog","tadd_contact_type_ds_error", allFieldsADD_CONTACT_TYPE);
		}
	}
});
jQuery("#cancelAddadd_contact_type").click(function(){
		editID = "";
		jQuery("#tadd_contact_type_ds_list").trigger("reloadGrid");
		jQuery("#add_contact_type_grid_div").css("display","inline");
		jQuery("#add_contact_type_form_div").css("display","none");			
		allFieldsADD_CONTACT_TYPE.val('').removeClass('ui-state-error');
		jQuery("#tadd_contact_type_ds_error").html("* Fields are mendatory");	
});
$("#add_contact_typeDialog").dialog({
	autoOpen: false,
	height: 'auto',
	width: 'auto',
	draggable: false,
	resizable: false,
	modal: true,
	open: function(event,ui){
		setTimeout(function(){$("#add_contact_typeDialog").dialog("close");},2000);
	},
	close : function(){
	}
});

});

</script>
<div id="add_contact_typeDialog" style="display:none">
</div>
<div id="add_contact_type_form_div" style="display:none">
<form method="post" name="frmAdd" id="tadd_contact_type_ds_frm" action="" title='' style="width:100%;margin:0px;">	
		<p id="tadd_contact_type_ds_error" class="addTips">* Fields are mendatory</p>
        <input type="hidden" id="tadd_contact_type_ds_form_id" name="id"/>
		<table width="50%" align="center" class="formtable">
			<tbody>
				<tr>
					<td width="12%">Contact Type <font color='red'>*</font></td>
					<td width="38%"><input type="text" name="contact_type" id="tadd_contact_type_ds_form_contact_type" class="text ui-widget-content ui-corner-all"/></td>
				</tr>
				<tr>
					<td valign="top"> Comment</td>				
					<td><textarea name="comments" id="tadd_contact_type_ds_form_comments" class="textarea ui-widget-content ui-corner-all"  /></textarea></td>
				</tr>
				<tr>
					<td colspan="2" align="center"><input type="button" id="addBtnadd_contact_type" value="Save" />					
					&nbsp;&nbsp;<input type="button" id="cancelAddadd_contact_type" value="Cancel" /></td>
				</tr>
			</tbody>
		</table>
	
</form>
</div>
<script type="text/javascript">$("#divAjaxIndex").dialog("close");</script>
</body>
</html>
