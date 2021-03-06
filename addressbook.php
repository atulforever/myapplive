<?php include("php/session.php"); ?>
<?php include("php/db.php"); ?>
<?php include("php/rights.php"); ?>
<?php $UserType = $_SESSION["UserType"]; ?>
<?php
	$isAdmin  = $_SESSION["isAdmin"];
	$uid  		= $_SESSION["userid"];
	
	$sSql = "SELECT id, category_name FROM list_category WHERE del_date IS NULL AND status=1 order by category_name";
	$data = mysql_query($sSql) or die("Error Fetching document Data");
	$category_name = "";
	$category_name = "<option value=''>Please Select</option>";
	while($row = mysql_fetch_array($data)){
		$category_name .= "<option value='".$row['id']."'>".$row['category_name']."</option>";
		
	}
	
	$sSql = "SELECT id, first_name, last_name FROM addressbook WHERE del_date IS NULL and status=1 AND status_mst_id=2 order by first_name";
		$data = mysql_query($sSql) or die("Error Fetching Addressbook Data");
		$client_huf_comp = "<option value=''>Please Select</option>";
		while($row = mysql_fetch_array($data)){
			$client_huf_comp  .= "<option value='".$row['id']."'>".$row['first_name']." ".$row['last_name']."</option>";
		} 
	
	$squery = "select id , contact_type from add_contact_type where del_date is NULL and status=1 order by contact_type";
	$c_data = mysql_query($squery) or die("Error while fecting data");
	$contact_type = "<option value=''>Please Select</option>";
	while($mydata = mysql_fetch_array($c_data)){
		$contact_type .="<option value='".$mydata['id']."'>".$mydata['contact_type']."</option>";
	}
	$sSql = "SELECT id, country_name FROM country_mst WHERE del_date IS NULL and status=1 order by country_name";
	$data = mysql_query($sSql) or die("Error Fetching Country Data");
	$country = "<option value=''>Please Select</option>";
	while($row = mysql_fetch_array($data)){
		$country .= "<option value='".$row['id']."'";
		$country .= ">".$row['country_name']."</option>";
	}
	$sSql = "SELECT id, name FROM status_mst WHERE del_date IS NULL and status=1 order by name";
	$data = mysql_query($sSql) or die("Error Fetching Status Data");
	$status = "<option value=''>Please Select</option>";
	while($row = mysql_fetch_array($data)){
		$status .= "<option value='".$row['id']."'>".strtoupper($row['name'])."</option>";
	}
	$sSql = "SELECT id, group_name FROM group_mst WHERE del_date IS NULL and status=1 order by group_name";
	$data = mysql_query($sSql) or die("Error Fetching State Data");
	$group = "<option value=''>Please Select</option>";
	while($row = mysql_fetch_array($data)){
		$group .= "<option value='".$row['id']."'>".strtoupper($row['group_name'])."</option>";
	}
	$sSql = "SELECT id, category_name FROM category_mst WHERE del_date IS NULL and status=1 order by category_name";
	$data = mysql_query($sSql) or die("Error Fetching Category Data");
	while($row = mysql_fetch_array($data)){
		/*if(!in_array($row['id'], array("3","4","6","7","8","12"))){*/
			$category .= "<option value='".$row['id']."'>".strtoupper($row['category_name'])."</option>";
		/*}*/
	}
	$sSql = "SELECT id, religion_name FROM religion_mst WHERE del_date IS NULL and status=1 order by religion_name";
	$data = mysql_query($sSql) or die("Error Fetching Religion Data");
	while($row = mysql_fetch_array($data)){
		$religion .= "<option value='".$row['id']."'>".$row['religion_name']."</option>";
	}
	$sSql = "SELECT id, service_name FROM service_mst WHERE del_date IS NULL and status=1 order by service_name";
	$data = mysql_query($sSql) or die("Error Fetching Service Data");
	$service = "<option value=''>Please Select</option>";
	while($row = mysql_fetch_array($data)){
		$service .= "<option value='".$row['id']."'>".$row['service_name']."</option>";
	}
	$sSql = "SELECT id, bank_name, branch FROM bank_mst WHERE del_date IS NULL and status=1 order by bank_name";
	$data = mysql_query($sSql) or die("Error Fetching Country Data");
	$bank = "<option value=''>Please Select</option>";
	while($row = mysql_fetch_array($data)){
		$bank .= "<option value='".$row['id']."'";
		$bank .= ">".$row['bank_name']." (".$row['branch'].")</option>";
	}
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
</head>
<body>
<div id="addressbook_grid_div">
<table id="taddressbook_ds_list"></table>
</div>
<div id="addressbook_pager"></div>

<script type="text/javascript"> 

var gCountryHome, gCountryOffice, gCityHome, gStateHome, gCityOffice, gStateOffice, iTimeOut, isToggle = true;
var viewId, viewEdit = false;
jQuery().ready(function (){
	
$('#f_category').change(function() {
		var option = $(this).find('option:selected').val();
		if(option != ""){
			$.post("php/addressbook.php?cmd=number_data&option="+option,$(".jobaddLoc_add").serialize(),function(data){
				$('#f_no').val(data) ;
			});
        }else{
			$('#f_no').val(null) ;
		}
    });
$("#search_text").Upper();
$("#taddressbook_ds_form_sms_number").OnlyNumberWithComma();
$("#taddressbook_ds_form_contact_no").OnlyNumberWithComma();
$("#taddressbook_ds_form_contact_no2").OnlyNumberWithComma();
$("#taddressbook_ds_form_contact_no3").OnlyNumberWithComma();
$("#taddressbook_ds_form_contact_no4").OnlyNumberWithComma();
$("#taddressbook_ds_form_fax_number").OnlyNumberWithComma();
$("#taddressbook_ds_form_home_pin").NumericOnly();
$("#taddressbook_ds_form_office_pin").NumericOnly();
jQuery("input:button, input:submit, input:reset").button();
$(".date").datepicker({dateFormat:'dd.mm.yy',changeMonth: true,changeYear: true,timeFormat: 'hh:mm TT', ampm: true});
jQuery("#taddressbook_ds_list").jqGrid({
   	url:'php/addressbook.php',
	datatype: "json",
   	colNames:['Id','SrNo.', 'Status Mst', 'Status Det', '', '', 'HUF/Company/Trust', 'Full Name', 'Name of Unit', 'Status', 'PAN Number', 'TAN Number', 'Accoutant', 'Category', 'Group', 'Father/Spose Name', 'Type', 'Birth Date', 'Anniversary', 'Home Address', 'City', 'Pin', 'State', 'Country','Office Address', 'City', 'Pin', 'State', 'Country', 'Sms Number', 'Email Address','Contact Person','Contact No ','Allow to send Sms','Contact Type'
		, 'Contact Person2' ,'Contact No2','Allow to send Sms','Contact Type2','Contact Person3', 'Contact No3','Allow to send Sms','Contact Type3','Contact Person4' ,'Contact No4','Allow to send Sms','Contact Type4','Fax Number','CIN Number', 'Website', 'Advocate', 'Religion', 'Service Tax Number', 'Ward','Event Trigger Sms', 'Birthday Sms', 'Annivesary Sms', 'Scheduled Sms','Prepared Date','Prepared By','Comments'],
   	height: "auto",
	colModel:[
   		{name:'id',index:'id',hidden:true, width:15, jsonmap:'id'},
   		{name:'srno',index:'srno',hidden:true, width:15, jsonmap:'srno'},
		{name:'ad_status_mst_id',index:'status_mst_id',hidden:true, width:15, jsonmap:'status_mst_id'},
		{name:'ad_status_det_id',index:'status_det_id',hidden:true, width:15, jsonmap:'status_det_id'},
   		{name:'ad_view',editable:true, index:'view', width:40, align:"left", jsonmap:'view', formatter:viewRec, search:false},
		{name:'ad_docs',editable:true, index:'docs', width:40, align:"left", jsonmap:'docs', formatter:viewDocs, search:false},
		{name:'HUF/COMPANY/FIRM/TRUST',editable:true, index:'com_huf', width:150, align:"left", jsonmap:'com_huf', formatter:formatLink, search:true},
		{name:'FULL NAME',editable:true, index:'first_name', width:150, align:"left", jsonmap:'first_name'},
		{name:'NAME OF UNIT',editable:true, index:'name_of_unit', width:150, align:"left", jsonmap:'name_of_unit'},
		{name:'STATUS_NAME',editable:true, index:'status_name', width:90, align:"left", jsonmap:'status_name'},
		{name:'PAN NO.',editable:true, index:'pan_number', width:120, align:"left", jsonmap:'pan_number'},
		{name:'TAN NO.',editable:true, index:'tan_number', width:120, align:"left", jsonmap:'tan_number'},
		{name:'ACCOUNTANT',editable:true, index:'accoutant_id', width:150, align:"left", jsonmap:'accoutant_id'},
		{name:'CATEGORY',editable:true, index:'category_name', width:90, align:"left", jsonmap:'category_name'},
		{name:'GROUP',editable:true, index:'group_name', width:90, align:"left", jsonmap:'group_name'},
		{name:'FATHER NAME',editable:true, index:'ad.father_spose_name', width:90, align:"left", jsonmap:'father_spose_name'},
		{name:'TYPE',editable:true, index:'ad.type', width:50, align:"left", jsonmap:'type'},
		{name:'DATE OF BIRTH', index:'dob', editable:false, align:"left", jsonmap:"dob",formatter: 'date', formatoptions:{srcformat:"Y-m-d H:i:s",newformat:"d.m.Y"}, width:120},
		{name:'ANNIVERSARY', index:'ad.anniversary', editable:false, align:"left", jsonmap:"anniversary",formatter: 'date', formatoptions:{srcformat:"Y-m-d H:i:s",newformat:"d.m.Y"}, width:120},
		{name:'HOME ADDRESS',editable:true, index:'ad.home_address_1', width:150, align:"left", jsonmap:'home_address_1'},	
		{name:'HOME CITY',editable:true, index:'ad.home_city', width:90, align:"left", jsonmap:'home_city', search:false},
		{name:'HOME PIN',editable:true, index:'ad.home_pin', width:90, align:"left", jsonmap:'home_pin', search:false},
		{name:'HOME STATE',editable:true, index:'ad.home_state', width:90, align:"left", jsonmap:'home_state', search:false},
		{name:'HOME COUNTRY',editable:true, index:'ad.home_country', width:90, align:"left", jsonmap:'home_country', search:false},
		{name:'OFFICE ADDRESS',editable:true, index:'ad.office_address_1', width:150, align:"left", jsonmap:'office_address_1'},	
		{name:'OFFICE CITY',editable:true, index:'ad.office_city', width:90, align:"left", jsonmap:'office_city', search:false},
		{name:'OFFICE PIN',editable:true, index:'ad.office_pin', width:90, align:"left", jsonmap:'office_pin', search:false},
		{name:'OFFICE STATE',editable:true, index:'ad.office_state', width:90, align:"left", jsonmap:'office_state', search:false},
		{name:'OFFICE COUNTRY',editable:true, index:'ad.office_country', width:90, align:"left", jsonmap:'office_country', search:false},
		{name:'SMS NO.',editable:true, index:'ad.sms_number', width:150, align:"left", jsonmap:'sms_number'},
		{name:'EMAIL',editable:true, index:'ad.email_address', width:150, align:"left", jsonmap:'email_address'},
		
		{name:'CONTACT PERSON',editable:true, index:'ad.con_person', width:120, align:"left", jsonmap:'con_person'},
		{name:'CONTACT NO.',editable:true, index:'ad.contact_no', width:120, align:"left", jsonmap:'contact_no'},
		{name:'contact_one_sms',editable:true, index:'ad.contact_one_sms', width:120, align:"left", jsonmap:'contact_one_sms'},
		{name:'CONTACT TYPE',editable:true, index:'ad.con_type', width:120, align:"left", jsonmap:'con_type'},
		{name:'CONTACT PERSON2',editable:true, index:'ad.con_person2', width:120, align:"left", jsonmap:'con_person2'},
		{name:'CONTACT NO2.',editable:true, index:'ad.contact_no2', width:120, align:"left", jsonmap:'contact_no2'},
		{name:'contact_two_sms',editable:true, index:'ad.contact_two_sms', width:120, align:"left", jsonmap:'contact_two_sms'},
		{name:'CONTACT TYPE2',editable:true, index:'ad.con_type2', width:120, align:"left", jsonmap:'con_type2'},
		{name:'CONTACT PERSON3',editable:true, index:'ad.con_person3', width:120, align:"left", jsonmap:'con_person3'},
		{name:'CONTACT NO3.',editable:true, index:'ad.contact_no3', width:120, align:"left", jsonmap:'contact_no3'},
		{name:'contact_three_sms',editable:true, index:'ad.contact_three_sms', width:120, align:"left", jsonmap:'contact_three_sms'},
		{name:'CONTACT TYPE3',editable:true, index:'ad.con_type3', width:120, align:"left", jsonmap:'con_type3'},
		{name:'CONTACT PERSON4',editable:true, index:'ad.con_person4', width:120, align:"left", jsonmap:'con_person4'},
		{name:'CONTACT NO4.',editable:true, index:'ad.contact_no4', width:120, align:"left", jsonmap:'contact_no4'},
		{name:'contact_four_sms',editable:true, index:'ad.contact_four_sms', width:120, align:"left", jsonmap:'contact_four_sms'},
		{name:'CONTACT TYPE4',editable:true, index:'ad.con_type4', width:120, align:"left", jsonmap:'con_type4'},
		
	
		{name:'FAX NO.',editable:true, index:'ad.fax_number', width:120, align:"left", jsonmap:'fax_number'},
		{name:'CIN NO.',editable:true, index:'ad.cin_number', width:120, align:"left", jsonmap:'cin_number'},
		{name:'WEBSITE',editable:true, index:'ad.website', width:150, align:"left", jsonmap:'website'},
		{name:'ADVOCATE',editable:true, index:'ad.advocate_id', width:90, align:"left", jsonmap:'advocate_id', search:false},
		{name:'RELIGION',editable:true, index:'ad.religion_name', width:90, align:"left", jsonmap:'religion_name', search:false},
		{name:'SERVICE TAX NO',editable:true, index:'ad.service_tax_number', width:120, align:"left", jsonmap:'service_tax_number'},
		{name:'WARD',editable:true, index:'ad.ward', width:120, align:"left", jsonmap:'ward'},
		
		//{name:'PHYSICAL FILE NO',editable:true, index:'physical_file_number', width:120, align:"left", jsonmap:'physical_file_number', search:false},
		//{name:'FILE LOCATION',editable:true, index:'file_location', width:120, align:"left", jsonmap:'file_location', search:false},
		//{name:'FILE DIGITAL PATH',editable:true, index:'file_digital_path', width:120, align:"left", jsonmap:'file_digital_path', search:false},
		{name:'TRIGGER SMA',editable:true, index:'trigger_sms', width:90, align:"left", jsonmap:'trigger_sms', search:false},
		{name:'BIRTHDAY SMS',editable:true, index:'birthday_sms', width:90, align:"left", jsonmap:'birthday_sms', search:false},
		{name:'ANNIVERSARY SMS',editable:true, index:'annivesary_sms', width:90, align:"left", jsonmap:'annivesary_sms', search:false},
		{name:'SCHEDULED SMS',editable:true, index:'scheduled_sms', width:90, align:"left", jsonmap:'scheduled_sms', search:false},
   		{name:'add_date', index:'ad.add_date', editable:false, align:"left", jsonmap:"add_date",formatter: 'date', formatoptions:{srcformat:"Y-m-d H:i:s",newformat:"d.m.Y"}, width:120},
   		{name:'add_uid', editable:true, index:'us.loginname', width:120, align:"left", jsonmap:'add_uid'},
   		{name:'COMMENTS', editable:true, index:'comments', width:120, align:"left", jsonmap:'comments'}
   	
   	],
	jsonReader: { repeatitems : true, id: "0" },
   	rowNum:20,
	rownumbers: true,
	height: "100%",
   	autowidth: true,
	shrinkToFit: false,
   	rowList:[10,20,30,50,100,500,1000,2000],
   	pager: '#addressbook_pager',
   	sortname: 'id',
    viewrecords: true,
    sortorder: "desc",
	multiselect: true, 
    caption:"ADDRESSBOOK",
	toolbar: [true,"top"],
	//subGrid : true,
	//subGridUrl: 'php/addressbook.php?cmd=listServices', subGridModel: [{ name : ['Services'], width : [700], params:['id']}],
	subGrid : true,
	 subGridRowExpanded: function(subgrid_id, row_id) {
		 var subgrid_table_id ;
		 var subgrid_table_id2 ;
		 
		subgrid_table_id = subgrid_id+"_t";           
		subgrid_table_id2 = subgrid_id+"_t2";
              
	
		jQuery("#"+subgrid_id).html("<table id='"+subgrid_table_id+"' class='scroll'></table>");
		jQuery("#"+subgrid_table_id).jqGrid({
			url:"php/addressbook.php?cmd=listFiles&id="+row_id,
			datatype: "json",
			colNames: ['File Category Name', 'No'],
			colModel: [
				{name:'category_name',editable:false, index:'category_name', width:150, align:"center", jsonmap:'category_name', search:false},
				{name:'no',editable:false, index:'no', width:150, align:"center", jsonmap:'no', search:false}
			],
			jsonReader: { repeatitems : true, id: "0" },
			rowNum:100,
			height: "100%",
			autowidth: true,
			shrinkToFit: false,
			viewrecords: true,
			sortorder: "desc",
			caption:"DOCUMENTS",
			toolbar: [true,"top"],
		 });
		 
		 jQuery("#"+subgrid_id).append("<table id='"+subgrid_table_id2+"' class='scroll'></table>");
		jQuery("#"+subgrid_table_id2).jqGrid({
			url:"php/addressbook.php?cmd=hufmember&id="+row_id,
			datatype: "json",
			colNames: ['','Member Details'],
			colModel: [
				{name:'sort',index:'sort',hidden:true,width:250, align:"left",jsonmap:'sort'},
				{name:'huf_member',editable:false, index:'huf_member', width:250, align:"center", jsonmap:'huf_member', search:false},
			],
			jsonReader: { repeatitems : true, id: "0" },
			rowNum:20,
			height: "100%",
			autowidth: true,
			shrinkToFit: false,
			viewrecords: true,
			sortorder: "desc",
			caption:"HUF MEMBER DETAILS",
			toolbar: [true,"top"],
			grouping:true, 
			groupingView : { 
				groupField : ['sort'], groupDataSorted : true, groupText : ['<b>{0} - {1} Item(s)</b>'], groupColumnShow : [true]  
			}
		});
	},
	/*grouping:true, 
	groupingView : { 
		groupField : ['STATUS_NAME'], groupDataSorted : true, groupText : ['<b>{0} - {1} Item(s)</b>'], groupColumnShow : [true]  
	},*/
	editurl:"php/general.php?cmd=delete&table=addressbook" 
	
}); 
/*var	addbook_Dels = false;
<?php if(in_array('ADDRESSBOOK', $deleteLink)){ ?>
addbook_Dels = true;
<?php } ?>*/
jQuery("#taddressbook_ds_list").jqGrid('navGrid','#addressbook_pager',{edit:false,add:false,del:false,search:false},{},{},{},{multipleSearch:true});
jQuery("#taddressbook_ds_list").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : true});
//jQuery("#taddressbook_ds_list").jqGrid('groupingRemove',true);

//Group By : <select id='chngroup' style='width:120px'><option value='category_name'>Category</option><option value='status_name'>Status</option></select>
$("#t_taddressbook_ds_list").append("<div style='font-size:10px;margin-left:5px;margin-top:5px;'>Search By: <select id='search_by'><option value=''>Please Select</option><option value='com_huf'>HUF/Company/Trust</option><option value='first_name'>Full Name</option><option value='group_name'>Group</option><option value='contact_no'>Contact No</option><option value='sms_number'>Sms Number</option><option value='email_address'>Email Address</option><option value='con_person'>Contact Person</option><option value='category_name'>Category</option><option value='ward'>ward</option><option value='micr_code'>MICR Code</option><option value='pan_number'>PAN Number</option><option value='tan_number'>TAN Number</option></select>&nbsp;&nbsp;<input type='text' style='width:300px;' id='search_text'>&nbsp;&nbsp;<select id='act_inact'><option value='Active'>Active</option><option value='Inactive'>Inactive</option></select>&nbsp;&nbsp;<input type='button' id='actInBtn' value='View'><?php if(in_array('ADDRESSBOOK', $deleteLink)){ ?>&nbsp;&nbsp;<input type='button' id='activeBtn' value='Active' style='display:none'>&nbsp;&nbsp;<input type='button' id='inactiveBtn' value='Inactive'><?php } ?></div>");
jQuery("input:button, input:submit, input:reset").button();
jQuery("#t_taddressbook_ds_list").css("height","30px");

jQuery("#search_by").change(function(){
	if(jQuery("#search_by").val() == '')
		jQuery("#search_text").val('');
}); 
jQuery("#actInBtn").click(function(){ 
	var vl = $("#act_inact").val(); 
	$("#activeBtn").hide();
	$("#inactiveBtn").hide();
	if(vl == "Active"){
		$("#inactiveBtn").show();
	}else{
		$("#activeBtn").show();
	}
	var search_by = $("#search_by").val();
	var search_text = $("#search_text").val(); 
	jQuery("#taddressbook_ds_list").jqGrid('setGridParam',{url:"php/addressbook.php"});
	jQuery("#taddressbook_ds_list").jqGrid('setGridParam',{postData:{acive_inactive:vl, searchBy:search_by, searchText:search_text, page:1}}).trigger("reloadGrid");
});

jQuery("#activeBtn").click(function(){ 
	var gsr = jQuery("#taddressbook_ds_list").jqGrid('getGridParam','selarrrow');
		if(gsr.length > 0){			
			$.post( 
				"php/addressbook.php?cmd=active_inactive&optr=active&ids="+gsr, 
				function(data){
					isToggle = false;
					$("#addressbookDialog").html(data);
					$("#addressbookDialog").dialog("open");
					jQuery("#taddressbook_ds_list").trigger("reloadGrid");
				} 
			);			
		} else {
			$("#addressbookDialog").html("Please Select Row");
			$("#addressbookDialog").dialog("open");
		}
});
jQuery("#inactiveBtn").click(function(){ 
	var gsr = jQuery("#taddressbook_ds_list").jqGrid('getGridParam','selarrrow');
		if(gsr.length > 0){			
			$.post( 
				"php/addressbook.php?cmd=active_inactive&optr=inactive&ids="+gsr,
				function(data){
					isToggle = false;
					$("#addressbookDialog").html(data);
					$("#addressbookDialog").dialog("open");
					jQuery("#taddressbook_ds_list").trigger("reloadGrid");
				} 
			);		
		} else {			
			$("#addressbookDialog").html("Please Select Row");
			$("#addressbookDialog").dialog("open");
		}
});

jQuery("#chngroup").change(function(){ 
	var vl = $(this).val(); 
	if(vl) { 
		if(vl == "clear") { 
			jQuery("#taddressbook_ds_list").jqGrid('groupingRemove',true); 
		} else {
			jQuery("#taddressbook_ds_list").jqGrid('groupingGroupBy',vl); 
		}
	} 
}); 
function formatLink(cellVal, options, rowObject){
	//var ret = jQuery("#taddressbook_ds_list").jqGrid('getRowData', id);
	var status_mst = rowObject[1];
	var status_det = rowObject[2];	
	//var status_mst = rowObject.status_mst_id;
	//var status_det = rowObject.status_det_id;	
	if(cellVal !== null) {
		cellVal = "<a href='javascript:void(0);' onclick=\"javascript:show_details('"+cellVal+"','"+status_mst+"','"+status_det+"')\">" + cellVal + "</a>";
		return cellVal;
	}
	return '&nbsp;';
}

function viewRec(cellVal, options, rowObject){
	var id = rowObject[0];
	if(cellVal !== null) {
		cellVal = "<a style='color:red' href='javascript:void(0);' onclick=\"javascript:view_rec('View','"+id+"')\">" + cellVal + "</a>";
		return cellVal;
	}
	return '&nbsp;';
}
function viewDocs(cellVal, options, rowObject){
	var id = rowObject[0];
	if(cellVal !== null) {
		cellVal = "<a style='color:red' href='javascript:void(0);' onclick=\"javascript:view_docs('View','"+id+"')\">" + cellVal + "</a>";
		return cellVal;
	}
	return '&nbsp;';
}

var taddressbook_ds_form_huf_name = $("#taddressbook_ds_form_huf_name"),
taddressbook_ds_form_name_of_unit_h = $("#taddressbook_ds_form_name_of_unit_h"),
taddressbook_ds_form_name_of_unit_i = $("#taddressbook_ds_form_name_of_unit_i"),
taddressbook_ds_form_salute = $("#taddressbook_ds_form_salute"),
taddressbook_ds_form_first_name = $("#taddressbook_ds_form_first_name"),
taddressbook_ds_form_last_name = $("#taddressbook_ds_form_last_name"),
taddressbook_ds_form_father_spose_name = $("#taddressbook_ds_form_father_spose_name"),
taddressbook_ds_form_dob = $("#taddressbook_ds_form_dob"),
taddressbook_ds_form_anniversary = $("#taddressbook_ds_form_anniversary"),
taddressbook_ds_form_home_address_1 = $("#taddressbook_ds_form_home_address_1"),
taddressbook_ds_form_home_address_2 = $("#taddressbook_ds_form_home_address_2"),
taddressbook_ds_form_home_address_3 = $("#taddressbook_ds_form_home_address_3"),
taddressbook_ds_form_home_city = $("#taddressbook_ds_form_home_city"),
taddressbook_ds_form_home_pin = $("#taddressbook_ds_form_home_pin"),
taddressbook_ds_form_home_state = $("#taddressbook_ds_form_home_state"),
taddressbook_ds_form_home_country = $("#taddressbook_ds_form_home_country"),
taddressbook_ds_form_office_address_1 = $("#taddressbook_ds_form_office_address_1"),
taddressbook_ds_form_office_address_2 = $("#taddressbook_ds_form_office_address_2"),
taddressbook_ds_form_office_address_3 = $("#taddressbook_ds_form_office_address_3"),
taddressbook_ds_form_office_city = $("#taddressbook_ds_form_office_city"),
taddressbook_ds_form_office_pin = $("#taddressbook_ds_form_office_pin"),
taddressbook_ds_form_office_state = $("#taddressbook_ds_form_office_state"),
taddressbook_ds_form_office_country = $("#taddressbook_ds_form_office_country"),
taddressbook_ds_form_cin_number = $("#taddressbook_ds_form_cin_number"),
taddressbook_ds_form_email_address = $("#taddressbook_ds_form_email_address"),
taddressbook_ds_form_fax_number = $("#taddressbook_ds_form_fax_number"),
taddressbook_ds_form_website = $("#taddressbook_ds_form_website"),
taddressbook_ds_form_advocate_id = $("#taddressbook_ds_form_advocate_id"),
taddressbook_ds_form_accoutant_id = $("#taddressbook_ds_form_accoutant_id"),
taddressbook_ds_form_religion = $("#taddressbook_ds_form_religion"),
taddressbook_ds_form_pan_number = $("#taddressbook_ds_form_pan_number"),
taddressbook_ds_form_tan_number = $("#taddressbook_ds_form_tan_number"),
taddressbook_ds_form_service_tax_number = $("#taddressbook_ds_form_service_tax_number"),
taddressbook_ds_form_physical_file_number = $("#taddressbook_ds_form_physical_file_number"),
taddressbook_ds_form_file_location = $("#taddressbook_ds_form_file_location"),
taddressbook_ds_form_file_digital_path = $("#taddressbook_ds_form_file_digital_path"),
taddressbook_ds_form_status_mst_id = $("#taddressbook_ds_form_status_mst_id"),
taddressbook_ds_form_group_mst_id = $("#taddressbook_ds_form_group_mst_id"),
taddressbook_ds_form_category_mst_id = $("#taddressbook_ds_form_category_mst_id"),
taddressbook_ds_form_member_of_huf = $("#taddressbook_ds_form_member_of_huf"),
taddressbook_ds_form_company_name = $("#taddressbook_ds_form_company_name"),
taddressbook_ds_form_member_of_partner = $("#taddressbook_ds_form_member_of_partner"),
taddressbook_ds_form_date_of_incorporation_com = $("#taddressbook_ds_form_date_of_incorporation_com"),
taddressbook_ds_form_date_of_incorporation_huf = $("#taddressbook_ds_form_date_of_incorporation_huf"),
taddressbook_ds_form_service_mst_id = $("#taddressbook_ds_form_service_mst_id"),
taddressbook_ds_form_contact_no = $("#taddressbook_ds_form_contact_no"),
taddressbook_ds_form_contact_no2 = $("#taddressbook_ds_form_contact_no2"),
taddressbook_ds_form_contact_no3 = $("#taddressbook_ds_form_contact_no3"),
taddressbook_ds_form_contact_no4 = $("#taddressbook_ds_form_contact_no4"),
taddressbook_ds_form_con_person = $("#taddressbook_ds_form_con_person");
taddressbook_ds_form_con_person2 = $("#taddressbook_ds_form_con_person2");
taddressbook_ds_form_con_person3 = $("#taddressbook_ds_form_con_person3");
taddressbook_ds_form_con_person4 = $("#taddressbook_ds_form_con_person4");
taddressbook_ds_form_con_type = $("#taddressbook_ds_form_con_type");
taddressbook_ds_form_con_type2 = $("#taddressbook_ds_form_con_type2");
taddressbook_ds_form_con_type3 = $("#taddressbook_ds_form_con_type3");
taddressbook_ds_form_con_type4 = $("#taddressbook_ds_form_con_type4");
taddressbook_ds_form_ward = $("#taddressbook_ds_form_ward");
taddressbook_ds_form_comments = $("#taddressbook_ds_form_comments");

allFieldsAddressbook = $([]).add(taddressbook_ds_form_huf_name).add(taddressbook_ds_form_salute).add(taddressbook_ds_form_first_name).add(taddressbook_ds_form_last_name).add(taddressbook_ds_form_father_spose_name).add(taddressbook_ds_form_dob).add(taddressbook_ds_form_anniversary).add(taddressbook_ds_form_home_address_1).add(taddressbook_ds_form_home_address_2).add(taddressbook_ds_form_home_address_3).add(taddressbook_ds_form_home_city).add(taddressbook_ds_form_home_pin).add(taddressbook_ds_form_home_state).add(taddressbook_ds_form_home_country).add(taddressbook_ds_form_office_address_1).add(taddressbook_ds_form_office_address_2).add(taddressbook_ds_form_office_address_3).add(taddressbook_ds_form_office_city).add(taddressbook_ds_form_office_pin).add(taddressbook_ds_form_office_state).add(taddressbook_ds_form_office_country).add(taddressbook_ds_form_cin_number).add(taddressbook_ds_form_email_address).add(taddressbook_ds_form_contact_no).add(taddressbook_ds_form_contact_no2).add(taddressbook_ds_form_contact_no3).add(taddressbook_ds_form_contact_no4).add(taddressbook_ds_form_fax_number).add(taddressbook_ds_form_website).add(taddressbook_ds_form_advocate_id).add(taddressbook_ds_form_accoutant_id).add(taddressbook_ds_form_religion).add(taddressbook_ds_form_pan_number).add(taddressbook_ds_form_tan_number).add(taddressbook_ds_form_service_tax_number).add(taddressbook_ds_form_physical_file_number).add(taddressbook_ds_form_file_location).add(taddressbook_ds_form_file_digital_path).add(taddressbook_ds_form_status_mst_id).add(taddressbook_ds_form_group_mst_id).add(taddressbook_ds_form_category_mst_id).add(taddressbook_ds_form_member_of_huf).add(taddressbook_ds_form_company_name).add(taddressbook_ds_form_member_of_partner).add(taddressbook_ds_form_date_of_incorporation_com).add(taddressbook_ds_form_date_of_incorporation_huf).add(taddressbook_ds_form_service_mst_id).add(taddressbook_ds_form_con_person).add(taddressbook_ds_form_con_person2).add(taddressbook_ds_form_con_person3).add(taddressbook_ds_form_con_person4).add(taddressbook_ds_form_con_type).add(taddressbook_ds_form_con_type2).add(taddressbook_ds_form_con_type3).add(taddressbook_ds_form_con_type4).add(taddressbook_ds_form_ward).add(taddressbook_ds_form_type).add(taddressbook_ds_form_comments).add(taddressbook_ds_form_name_of_unit_h).add(taddressbook_ds_form_name_of_unit_i);

tips = $("#taddressbook_ds_error");

getComboByCategory(10, '#taddressbook_ds_form_accoutant_id', 'getComboByCategory');
getComboByCategory(9, '#taddressbook_ds_form_advocate_id', 'getComboByCategory');




<?php if(in_array('ADDRESSBOOK', $deleteLink)){ ?>
jQuery("#taddressbook_ds_list").jqGrid('navButtonAdd','#addressbook_pager',{caption:"Delete",
	onClickButton:function(){
		var gsr_del = jQuery("#taddressbook_ds_list").jqGrid('getGridParam','selarrrow');
		if(gsr_del.length > 0){
			if(gsr_del.length > 1){
				isToggle = false;
				$("#addressbookDialog").html("Please Select Only One Row");
				$("#addressbookDialog").dialog("open");
			}
			else{
				deleteID = gsr_del[0];
				$.post("php/addressbook.php",{cmd:"delete",id:deleteID},function(data){
					if(data.result == "true"){
						isToggle = false;
						jQuery("#taddressbook_ds_list").trigger("reloadGrid");
						$("#addressbookDialog").html(data.msg);
						$("#addressbookDialog").dialog("open");
					}else{
						$("#addressbookDialog").html(data.error);
						$("#addressbookDialog").dialog("open");
					}
				},"json");
			}
		} else {
			isToggle = false;
			$("#addressbookDialog").html("Please Select Row");
			$("#addressbookDialog").dialog("open");
		}	
	} 
});
<?php } ?>
<?php if(in_array('ADDRESSBOOK', $addLink)){ ?>
jQuery("#taddressbook_ds_list").jqGrid('navButtonAdd','#addressbook_pager',{caption:"Add",
	onClickButton:function(){
		resetFieldsAddr();
		$(".ui-layout-toggler").click();
		refreshIndividualClient();
		editID = "";		
		allFieldsAddressbook.val('').removeClass('ui-state-error');
		jQuery("#taddressbook_ds_error").html("* Fields are mendatory");
		jQuery("#addressbook_form_div").css("display","inline");
		jQuery("#addressbook_grid_div").css("display","none");		
		taddressbook_ds_form_status_mst_id.focus();	
			
	} 
});
<?php } ?>
<?php if(in_array('ADDRESSBOOK', $editLink)){ ?>
jQuery("#taddressbook_ds_list").jqGrid('navButtonAdd','#addressbook_pager',{caption:"Edit",
	onClickButton:function(){
		var gsr = jQuery("#taddressbook_ds_list").jqGrid('getGridParam','selarrrow');
		if(gsr.length > 0){
			if(gsr.length > 1){
				isToggle = false;
				$("#addressbookDialog").html("Please Select Only One Row");
				$("#addressbookDialog").dialog("open");
			}
			else{
				resetFieldsAddr();
				$(".ui-layout-toggler").click();
				
				editID = gsr[0];
				refreshIndividualClient();
				editAddressbook("addressbook");
				iTimeOut = setTimeout('loadStatus();',500);
				//alert($("#taddressbook_ds_form_id").val());
				jQuery("#addressbook_form_div").css("display","inline");
				jQuery("#addressbook_grid_div").css("display","none");
			}
		} else {
			isToggle = false;
			$("#addressbookDialog").html("Please Select Row");
			$("#addressbookDialog").dialog("open");
		}							
	} 
});
<?php } ?>
<?php if(in_array('ADDRESSBOOK', $exportLink)){ ?>
jQuery("#taddressbook_ds_list").jqGrid('navButtonAdd','#addressbook_pager',{caption:"Export",
	onClickButton:function(){
		exportExcel('taddressbook_ds_list','addressbook');
	} 
});
<?php } ?>
/*<?php if(in_array('ADDRESSBOOK', $editLink)){ ?>
jQuery("#taddressbook_ds_list").jqGrid("navButtonAdd","#addressbook_pager",{caption:"SMS",
		onClickButton:function(){
			var gsr = jQuery("#taddressbook_ds_list").jqGrid("getGridParam","selarrrow");
			 if(gsr.length > 0){
					contactsEditID = gsr;
					$.post("php/addressbook.php",{cmd:"getnumber",id:contactsEditID},function(result){
								data = JSON.parse(result);
								$("#contact_sms_contact").val(data.contact_no);	
								$("#contact_sms_contact").val(data.contact_no2);	
								jQuery("#contacts_frm_div_sms").css("display","inline");
								jQuery("#addressbook_grid_div").css("display","none");
								
								// add
								//$(".datetime").datetimepicker("setDate",new Date);
								//$(".datetime").focus();
								//$(".datetime").focusout();
					});
				}else
				{
					$("#addressbookDialog").html("Please Select Row");
					$("#addressbookDialog").dialog("open");
				}
					
			//$(".datetime").focusout();
		}
	});
<?php } ?>*/
jQuery("#addBtnAddressbook").click(function(){	
	//validation
	var bValid = true;
	allFieldsAddressbook.removeClass('ui-state-error');
	bValid = bValid && checkNull(taddressbook_ds_form_status_mst_id,"Status");	
	
	if(taddressbook_ds_form_status_mst_id.val() == 1){
		bValid = bValid && checkNull(taddressbook_ds_form_huf_name,"Name");	
	}
		
	if(taddressbook_ds_form_status_mst_id.val() == 2 || taddressbook_ds_form_status_mst_id.val() == 8){
		bValid = bValid && checkNull(taddressbook_ds_form_first_name,"First Name");	//check date for null value
//		bValid = bValid && checkNull(taddressbook_ds_form_middle_name,"Middle Name");	//check date for null value
		bValid = bValid && checkNull(taddressbook_ds_form_last_name,"Last Name");	//check date for null value
//		bValid = bValid && checkNull(taddressbook_ds_form_father_spose_name,"Father/Spose Name Name");	//check date for null value
	}
	
	if(taddressbook_ds_form_status_mst_id.val() == 3 || taddressbook_ds_form_status_mst_id.val() == 4 || taddressbook_ds_form_status_mst_id.val() == 5  || taddressbook_ds_form_status_mst_id.val() == 6  || taddressbook_ds_form_status_mst_id.val() == 7 || taddressbook_ds_form_status_mst_id.val() > 8 ){
		bValid = bValid && checkNull(taddressbook_ds_form_company_name,"Name");	//check date for null value
	}
	//bValid = bValid && checkNull(taddressbook_ds_form_accoutant_id,"Accoutant");	//check date for null value
	if(taddressbook_ds_form_email_address.val() != ""){
		var e_mail = taddressbook_ds_form_email_address.val().split(",");
		for(i=0; i<e_mail.length; i++){
			bValid = bValid && checkEmailMultiple(e_mail[i],taddressbook_ds_form_email_address);
		}
	}
	
	if (bValid) {
		if(editID == ""){
			addRecord("php/addressbook.php?cmd=insert","addressbook_grid_div", "addressbook_form_div", "taddressbook_ds_list","addressbookDialog","taddressbook_ds_error", allFieldsAddressbook);
		}else{
			editRecordAddressbook("php/addressbook.php?cmd=update","addressbook_grid_div", "addressbook_form_div", "taddressbook_ds_list","addressbookDialog","taddressbook_ds_error", allFieldsAddressbook);
		}
	}
});
jQuery("#sendSmscloseBtn").click(function(){
		jQuery("#taddressbook_ds_list").trigger("reloadGrid");
		jQuery("#addressbook_grid_div").css("display","inline");
		jQuery("#contacts_frm_div_sms").css("display","none");
		jQuery("#contact_sms_contact").val("");
		jQuery("#sms_content").val("");
		allFieldsAddressbook.val("").removeClass("ui-state-error");
		jQuery("#taddressbook_ds_error").html("* Fields are mendatory");
		jQuery("#taddressbook_ds_list").trigger("reloadGrid");
		contactsEditID = "";	
	})
jQuery("#cancelAddAddressbook").click(function(){
		editID = "";
		jQuery("#taddressbook_ds_list").trigger("reloadGrid");
		jQuery("#addressbook_grid_div").css("display","inline");
		jQuery("#addressbook_form_div").css("display","none");			
		allFieldsAddressbook.val('').removeClass('ui-state-error');
		jQuery("#taddressbook_ds_error").html("* Fields are mendatory");
		$(".ui-layout-toggler").click();
		$("#taddressbook_ds_form_add_filelist").attr("checked","");
		$("#taddressbook_ds_form_filelist_form").css("display","none");	
		$('#f_no').val('');
		$('#f_category').val('');
		$("#name_tr").css("display","");
		$("#father_tr").css("display","");
		$("#ca_tr").css("display","none");
		$("#huf_tr").css("display","none");
		$("#company_tr").css("display","none");
		$("#taddressbook_ds_form_home_state").html('<option value="">Please Select</option>');
		$("#taddressbook_ds_form_home_city").html('<option value="">Please Select</option>');
		$("#taddressbook_ds_form_office_state").html('<option value="">Please Select</option>');
		$("#taddressbook_ds_form_office_city").html('<option value="">Please Select</option>');
});

jQuery("#groupBtn").click(function(){
	var groupId = $("#taddressbook_ds_form_group_mst_id").val();
	if(groupId != ""){
		
		var sUrl = "php/general.php?cmd=select&table=group_mst&key=id&value=" + groupId;
		$.post(
			sUrl,
			function(msg){
				$.each(msg, function(key, value) { 
					try{		
						if(key=='home_country') gCountryHome = value;
						if(key=='home_city') gCityHome = value;
						if(key=='home_state') gStateHome = value;
						if(key=='office_country') gCountryOffice = value;
						if(key=='office_city') gCityOffice = value;
						if(key=='office_state') gStateOffice = value;
						if(key != 'id')
							$("#"+frmId+" #"+ frmPrifix + key).val(value);
					}
					catch(e)
					{
					}
				});
				setComboOption(gStateHome, '#taddressbook_ds_form_home_state', 'state_mst', 'state_name');
				setComboOption(gCityHome, '#taddressbook_ds_form_home_city', 'city_mst', 'city_name');
				setComboOption(gStateOffice, '#taddressbook_ds_form_office_state', 'state_mst', 'state_name');
				setComboOption(gCityOffice, '#taddressbook_ds_form_office_city', 'city_mst', 'city_name');
			},"json"
		);
	}
});


$("#addressbookDialog").dialog({
	autoOpen: false,
	height: 'auto',
	width: 'auto',
	draggable: false,
	resizable: false,
	modal: true,
	close : function(){	
		if(isToggle != false)
			$(".ui-layout-toggler").click();
		isToggle = true;
		$("#name_tr").css("display","");
		$("#father_tr").css("display","");
		$("#ca_tr").css("display","none");
		$("#huf_tr").css("display","none");
		$("#home_address_tr").css("display","");
		$("#home_city_tr").css("display","");
		$("#company_tr").css("display","none");	
		$("#company_tr").css("display","none");
		$("#taddressbook_ds_form_home_state").html('<option value="">Please Select</option>');
		$("#taddressbook_ds_form_home_city").html('<option value="">Please Select</option>');
		$("#taddressbook_ds_form_office_state").html('<option value="">Please Select</option>');
		$("#taddressbook_ds_form_office_city").html('<option value="">Please Select</option>');	
	}
});

});

function setComboOption(pValue, cCombo, tbl, fld){
	$.post("php/addressbook.php?cmd=getCityStateName&value="+pValue+"&tbl="+tbl+"&fld="+fld, function(data){
			$(cCombo).append($('<option selected="selected"></option>').val(pValue).html(data));
    });
}
function refreshIndividualClient(){
	$.post( 
        "php/addressbook.php?cmd=getIndividualClient", 
        function(data){
			$("#taddressbook_ds_form_addressbook_id_huf").html(data);
			//$("#taddressbook_ds_form_member_of_huf").html(data);
			$("#taddressbook_ds_form_addressbook_id_ca").html(data);
			//$("#taddressbook_ds_form_member_of_partner").html(data);
        } 
    );
}

function getComboByCategory(pValue, cCombo,strCmd){
	$.post( 
        "php/addressbook.php?cmd="+strCmd+"&value="+pValue, 
        function(data){
			$(cCombo).html(data);
        } 
    );
}
function loadStatus(){
	
	var status_id = $("#taddressbook_ds_form_status_mst_id").val();
	if(status_id != ""){
		displayStatusWS(status_id);
		
		loadStatusDetails(status_id);
		
	}
	else{
		iTimeOut = setTimeout('loadStatus();',500);
	}
}
function loadStatusDetails(status_id){
	
	if(status_id == 1){
		var tabName = 'huf';	
	}
	else if(status_id == 8){
		var tabName = 'ca';
	}
	else if(status_id == 2 || status_id == 3 || status_id == 4 || status_id == 5 || status_id == 6 || status_id == 7 || status_id > 8){
		var tabName = 'firm_company_llp_aop_trust';
	}else{
		return false;
	}
	var sDetId = $("#taddressbook_ds_form_status_det_id").val();
	var sUrl = "php/general.php?cmd=select&table="+tabName+"&key=id&value=" + sDetId;
	if(sDetId != ""){
		$.post(
			sUrl,
			function(msg){
				$.each(msg, function(key, value) { 
					try{	
						if(status_id == 1){
							if(key == 'addressbook_id'){
								key = 'addressbook_id_huf';
							}
							if(key == 'member_of_huf'){
								$.post( 
									phplib + "addressbook.php", {cmd: 'getHufMember', id: editID},
									function(data){
										for (var a =0; a<=(data.length-1); a++){
											$(".huf_data:last").val(data[a]);
											if(a!=data.length-1){
											addhufmember();
										}
										
									}
															
								},"json"
							);	
														
							}
							if(key == 'date_of_incorporation'){
								key = 'date_of_incorporation_huf';
							}
						}
						else if(status_id == 8){
							if(key == 'addressbook_id'){
								key = 'addressbook_id_ca';
							}
						}
						else if(status_id == 2 || status_id == 3 || status_id == 4 || status_id == 5 || status_id == 6 || status_id == 7 || status_id > 8){
							if(key == 'date_of_incorporation'){
								key = 'date_of_incorporation_com';
							}
							if(key == 'member_of_partner'){
								$.post( 
									phplib + "addressbook.php", {cmd: 'getCompanyMember', id: editID},
									function(data){
										for (var a =0; a<=(data.length-1); a++){
											$(".cp_data:last").val(data[a]);
											if(a!=data.length-1){
											addcompanymember();
										}
										
									}
															
								},"json"
							);							
							}
						}
						
						if(key != 'id')
							$("#"+frmId+" #"+ frmPrifix + key).val(value);
					}
					catch(e)
					{
					}
				});
				$(".date").each(
				function(){
					if($(this).val() != ""){
						if(this.id == 'taddressbook_ds_form_date_of_incorporation_com' || this.id == 'taddressbook_ds_form_date_of_incorporation_huf'){
							var myDate = parse_date($(this).val());
							$(this).val(myDate.format('d.m.Y'));
						}
					}
				});
			},"json"
		);
	}
}
$("#taddressbook_ds_form_add_filelist").click(function(){
	var val = ($(this).attr("checked"));
	if(val == true)
		$("#taddressbook_ds_form_filelist_form").css("display","table-cell");
	else
		$("#taddressbook_ds_form_filelist_form").css("display","none");

});
function getLocationno(value,rand,file_hide_id){
	if(value != ""){
		var file_hide_id = $(file_hide_id).val();
		$.post("php/addressbook.php?cmd=number_data&hidden_id="+file_hide_id+"&id="+editID+"&option="+value,$(".jobaddLoc_add").serialize(),function(data){		
			$(rand).val(data) ;
		});
	}else{
		$(rand).val(null) ;
	}	 
}
var count_no = 0;
function addfilelist(){
	count_no++;
	$("#f_table > tbody").append("<tr><td valign='top'><select name='f_category[]' onchange = 'getLocationno(this.value,f_no_"+count_no+")' class='jobaddLoc_add select ui-widget-content ui-corner-all'><?php echo $category_name; ?></select></td><td><input name='f_no[]' id='f_no_"+count_no+"' type='text' class='jobaddLoc_add text ui-widget-content ui-corner-all'></td></tr>");
}
function deletefilelist(){
	var totalfilelist = $("#f_table > tbody > tr").length;
	if(totalfilelist > 2){
		$('#f_table tr:last').remove();
	}
}
function deleteAllfilelist(){
	var totalfilelist = $("#f_table > tbody > tr").length;
	for(i=0; i<totalfilelist-2; i++){
		$('#f_table tr:last').remove();
	}
}
function addhufmember(){
	count_no++;
	$("#huf_table > tbody").append("<tr><td> Member of HUF</td><td><select name='member_of_huf[]' id='taddressbook_ds_form_member_of_huf'  class='huf_data select ui-widget-content ui-corner-all'><?php echo $client_huf_comp; ?></select></td></tr>");
}
function deletehufmember(){
	var deleteallhuf = $("#huf_table > tbody > tr").length;
	if(deleteallhuf > 1){
		$('#huf_table tr:last').remove();
	}
}
function deleteAllhufmember(){
	var totalhufmember = $("#huf_table > tbody > tr").length;
	for(i=0; i<totalhufmember-1; i++){
		$('#huf_table tr:last').remove();
	}
}

function addcompanymember(){
	$("#company_table > tbody").append("<tr><td> Pratners/Directors/Trustee</td><td><select name='member_of_partner[]' id='taddressbook_ds_form_member_of_partner'  class='cp_data select ui-widget-content ui-corner-all'><?php echo $client_huf_comp; ?></select></td></tr>");
}
function deletecompanymember(){
	var deleteallhuf = $("#company_table > tbody > tr").length;
	if(deleteallhuf > 1){
		$('#company_table tr:last').remove();
	}
}
function deleteAllcompanymember(){
	var totalcompanymember = $("#company_table > tbody > tr").length;
	for(i=0; i<totalcompanymember-1; i++){
		$('#company_table tr:last').remove();
	}
}


function displayStatusWS(val){
	if(val == 1){
		$("#huf_tr").css("display","");
		$("#ca_tr").css("display","none");
		$("#company_tr").css("display","none");
		$("#name_tr").css("display","none");
		$("#father_tr").css("display","none");
		$("#home_address_tr").hide();
		$("#home_city_tr").hide();
	}
	else if(val == 8){
		$("#name_tr").css("display","");
		$("#father_tr").css("display","");
		$("#home_address_tr").show();
		$("#home_city_tr").show();
		$("#ca_tr").css("display","");
		$("#huf_tr").css("display","none");
		$("#company_tr").css("display","none");
	}
	else if(val == 3 || val == 4 || val == 5 || val == 6 || val == 7 || val > 8){
		$("#company_tr").css("display","");
		$("#name_tr").css("display","none");
		$("#father_tr").css("display","none");
		$("#home_address_tr").hide();
		$("#home_city_tr").hide();
		$("#ca_tr").css("display","none");
		$("#huf_tr").css("display","none");
		var lable = $("#taddressbook_ds_form_status_mst_id option[value='"+val+"']").text();
		$("#com_lable").html(lable+" Name <font color='red'>*</font>");
	}else{
		$("#name_tr").css("display","");
		$("#father_tr").css("display","");
		$("#home_address_tr").show();
		$("#home_city_tr").show();
		$("#ca_tr").css("display","none");
		$("#huf_tr").css("display","none");
		$("#company_tr").css("display","none");
	}
	
}
function editAddressbook(table){
	$("#divAjaxIndex").dialog("open");
	var sUrl = "php/general.php?cmd=select&table=" + table + "&key=id&value=" + editID;
	$("#"+frmPrifix+"id").val(editID);
	$.post(
		sUrl,
		function(msg){
			$.each(msg, function(key, value) { 
				try
				{
					if($("#"+frmPrifix + key).attr("type") == 'checkbox'){
						$("#"+ frmPrifix + key).click(function(){
							if($(this).attr("checked") == true){
								$(this).val(1);
							}else{
								$(this).val(0);
							}
						});
						if(value == 1){
							$("#"+ frmPrifix + key).attr("checked","checked");
						}else{
							$("#"+ frmPrifix + key).attr("checked","");
						}
					}
					
					
					if(key=='home_country') gCountryHome = value;
					if(key=='home_city') gCityHome = value;
					if(key=='home_state') gStateHome = value;
					if(key=='office_country') gCountryOffice = value;
					if(key=='office_city') gCityOffice = value;
					if(key=='office_state') gStateOffice = value;
					if(key == 'status_mst_id'){
						$("#taddressbook_ds_form_old_status").val(value);
						if(value == 2){
							$("#taddressbook_ds_form_name_of_unit_h").val('');
						}
						if(value == 1){
							$("#taddressbook_ds_form_name_of_unit_i").val('');
						}
					}
					
					$.post( 
						phplib + "addressbook.php", {"cmd":"GetFileList", "value":editID},
						function(data){
							if(data.filelist == 'true'){						
								
								$("#taddressbook_ds_form_add_filelist").attr("checked","checked");
								$("#taddressbook_ds_form_filelist_form").css("display","");	
								$.post( 
									   phplib + "addressbook.php", {cmd: 'getfileNO', file_id: editID},
									   function(data){
											$('#f_table').html(data);
									}
								);		
							}
						} ,"json"
					);
					if(key == 'name_of_unit'){
						$(".name_of_unit").val(value);
						key = "";
					}
					$("#"+frmId+" #"+ frmPrifix + key).val(value);
				}
				catch(e)
				{
				}
			});
			$(".date").each(
				function(){
					if($(this).val()!=""){
						var myDate = parse_date($(this).val());
						$(this).val(myDate.format('d.m.Y'));
					}
				});
			
			setComboOption(gStateHome, '#taddressbook_ds_form_home_state', 'state_mst', 'state_name');
			setComboOption(gCityHome, '#taddressbook_ds_form_home_city', 'city_mst', 'city_name');
			setComboOption(gStateOffice, '#taddressbook_ds_form_office_state', 'state_mst', 'state_name');
			setComboOption(gCityOffice, '#taddressbook_ds_form_office_city', 'city_mst', 'city_name');
			
			$("#divAjaxIndex").dialog("close");
		},"json"
	);	
}
function listbox_moveacross(sourceID, destID) {
	var src = document.getElementById(sourceID);
	var dest = document.getElementById(destID);
	for(var count=0; count < src.options.length; count++) {

		if(src.options[count].selected == true) {
				var option = src.options[count];

				var newOption = document.createElement("option");
				newOption.value = option.value;
				newOption.text = option.text;
				newOption.selected = true;
				try {
						 dest.add(newOption, null); //Standard
						 src.remove(count, null);
				 }catch(error) {
						 dest.add(newOption); // IE only
						 src.remove(count);
				 }
				count--;
		}
	}
}
function show_details(label, mst, det){
	
	$("#tabs").tabs("add", "status_det.php?mst="+mst+"&det="+det, label);
}
function view_rec(label, id){	
	//$("#tabs").tabs("add", "addr_view.php?id="+id, label);
	viewAddr("php/addressbook.php?cmd=view&id="+id);
	viewId = id;
	$('#view').css('display','');
	$('#addressbook_grid_div').css('display','none');
}
function view_docs(label, id){	
	$("#tabs").tabs("add", "physical_docs.php?client="+id, 'Docs');
}
function viewAddr(sUrl){
	$.post(
		sUrl,
		function(msg){
			$.each(msg, function(key, value) { 
				try
				{		
					if(key == 'id'){
						$("#adr_" + key).val(value);
						viewId = value;	
					}
					$("#adr_" + key).html(value);
				}
				catch(e)
				{
				}
			});
						
		},"json"
	);
}
function next(){
	viewAddr("php/addressbook.php?cmd=view&rec=next&id="+$('#adr_id').val());
	
}
function previous(){
	viewAddr("php/addressbook.php?cmd=view&rec=previous&id="+$('#adr_id').val());
}
function back2List(){
	viewId = ''
	viewEdit = false;
	$('#view').css('display','none');
	$('#addressbook_grid_div').css('display','');
}

function resetFieldsAddr(){
	$("#taddressbook_ds_form_allow_to_send_event_trigger_sms").attr("checked","");	
	$("#taddressbook_ds_form_allow_to_send_birthday_sms").attr("checked","");	
	$("#taddressbook_ds_form_allow_to_send_annivesary_sms").attr("checked","");	
	$("#taddressbook_ds_form_allow_to_send_pre_scheduled_sms").attr("checked","");
	$("#taddressbook_ds_form_allow_to_send_con_one_sms").attr("checked","");
	$("#taddressbook_ds_form_allow_to_send_con_two_sms").attr("checked","");
	$("#taddressbook_ds_form_allow_to_send_con_three_sms").attr("checked","");
	$("#taddressbook_ds_form_allow_to_send_con_four_sms").attr("checked","");
	$("#taddressbook_ds_form_add_filelist").attr("checked","");
	$("#f_category").val("");
	$("#f_no").val("");
	deleteAllfilelist();
	deleteAllcompanymember();
	deleteAllhufmember();
}
function editRecordAddressbook(url, grid_div, form_div, grid, dialog, errorMsgP, all_Fields){
    $("#divAjaxIndex").dialog("open");
	$.post( 
        url, 
        $("#"+frmId).serialize(), 
        function(data){
			$("#divAjaxIndex").dialog("close");
			if(data.result == "true"){
				editID = "";
				jQuery("#"+grid).trigger("reloadGrid");
				jQuery("#"+form_div).css("display","none");	
				if(viewEdit){
					jQuery("#view").css("display","");
					viewAddr("php/addressbook.php?cmd=view&id="+viewId);
				}else{
					jQuery("#"+grid_div).css("display","inline");
				}
				all_Fields.val('').removeClass('ui-state-error');
				jQuery("#"+errorMsgP).html("* Fields are mendatory");	
				$("#"+dialog).html(data.msg);
				$("#"+dialog).dialog("open");
			}
			else{
				updateTips(data.error);
				all_Fields.removeClass('ui-state-error');
				if(data.eid){					
					$("#" + frmPrifix+data.eid).focus();				
					$("#" + frmPrifix+data.eid).addClass('ui-state-error');
				}	
			}
        }, "json");
	
}
function editFromView(){
	resetFieldsAddr();
	$(".ui-layout-toggler").click();
	$("#taddressbook_ds_form_service_det_id").html('');
	editID = viewId;
	refreshIndividualClient();
	editAddressbook("addressbook");
	iTimeOut = setTimeout('loadStatus();',500);
	jQuery("#addressbook_form_div").css("display","inline");
	jQuery("#addressbook_grid_div").css("display","none");
	jQuery("#view").css("display","none");	
	viewEdit = true;
}
function displayServices(){
	if($('#services_tr').css('display') == "none"){
		$('#services_tr').css('display', '');
	}else{
		$('#services_tr').css('display', 'none');
	}
}
</script>

<div id="addressbookDialog" style="display:none">
</div>
<div id="addressbook_form_div" style="display:none"><!--  -->
<form method="post" name="frmAdd" id="taddressbook_ds_frm" action="" title='' style="width:100%;margin:0px;">	
		<p id="taddressbook_ds_error" class="addTips">* Fields are mendatory</p>
        <input type="hidden" id="taddressbook_ds_form_id" name="id"/>
		<input type="hidden" name="allow_to_send_event_trigger_sms" value="0" />
		<input type="hidden" name="allow_to_send_birthday_sms" value="0" />
		<input type="hidden" name="allow_to_send_annivesary_sms" value="0" />
		<input type="hidden" name="allow_to_send_pre_scheduled_sms" value="0" />
		<input type="hidden" name="allow_to_send_con_one_sms" value="0" />
		<input type="hidden" name="allow_to_send_con_two_sms" value="0" />
		<input type="hidden" name="allow_to_send_con_three_sms" value="0" />
		<input type="hidden" name="allow_to_send_con_four_sms" value="0" />
		<input type="hidden" id="taddressbook_ds_form_status_det_id" name="status_det_id"/>
		<input type="hidden" id="taddressbook_ds_form_old_status" name="old_status"/>
		<table width="100%" align="center" class="formtable">
			<tbody>
				
				<tr>
					<td width="10%"> Status <font color="red">*</font></td>
					<td width="20%"><select id="taddressbook_ds_form_status_mst_id" name="status_mst_id" class="select ui-widget-content ui-corner-all" onChange="displayStatusWS(this.value)"><?php echo $status;?></select></td>					
					<td width="10%"> Group</td>
					<td width="20%"><table width="100%"><tr><td width="75%"><select id="taddressbook_ds_form_group_mst_id" name="group_mst_id" class="select ui-widget-content ui-corner-all"><?php echo $group;?></select></td><td><input id="groupBtn" type="button" value="Set"></td></tr></table></td>
					<td width="10%"> Category</td>
					<td width="20%"><select id="taddressbook_ds_form_category_mst_id" name="category_mst_id" class="select ui-widget-content ui-corner-all"><?php echo $category;?></select></td>					
				</tr>
				<tr>
					
				</tr>
				
				<tr id="name_tr">
					<td colspan="6">
						<table width="100%">
							<tr>
								<td> Salute</td>
								<td><select name="salute" style="width:100px;" id="taddressbook_ds_form_salute" class="select ui-widget-content ui-corner-all" ><option value="MR.">MR.</option><option value="Mrs.">MRS.</option><option value="MISS.">MISS.</option><option value="SHRI.">SHRI.</option><option value="SMT.">SMT.</option></select></td>
								<td> First Name <font color="red">*</font></td>
								<td><input type="text" name="first_name" id="taddressbook_ds_form_first_name" class="text ui-widget-content ui-corner-all"/></td>
					
								<td> Last Name <font color="red">*</font></td>
								<td><input type="text" name="last_name" id="taddressbook_ds_form_last_name" class="text ui-widget-content ui-corner-all"/></td>
								<td> Name of Unit</td>
								<td><input type="text" name="name_of_unit_i" id="taddressbook_ds_form_name_of_unit_i" class="name_of_unit text ui-widget-content ui-corner-all"/></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr id="huf_tr" style="display:none;">
					<td colspan="6">
					<table width="100%">
						<tr>
							<td colspan="2" width="50%">
								<table width="100%"><tr>
									<td width="10%"> HUF Name </td>
									<td width="20%"><input type="text" id="taddressbook_ds_form_huf_name" name="huf_name" class="text ui-widget-content ui-corner-all"><?php echo $individual;?></select></td></tr>
									<tr><td>Name of Unit </td>
									<td><input type="text" name="name_of_unit_h" id="taddressbook_ds_form_name_of_unit_h" class="name_of_unit text ui-widget-content ui-corner-all"/></td>
									</tr>
								</table>
							</td>
							
							<td> Date of Incorporation</td>
							<td><input type="text" name="date_of_incorporation_huf" id="taddressbook_ds_form_date_of_incorporation_huf" class="date text ui-widget-content ui-corner-all"/></td>
						</tr>
						<tr>
						<td colspan ="4"><!--  -->
							<table border="0" width="69%">					
								<tr>
									<td>
										<table id="huf_table" width="100%">
											<tr>
												<td> Member of HUF</td>	
												<td><select id="taddressbook_ds_form_member_of_huf"name="member_of_huf[]" class="huf_data select ui-widget-content ui-corner-all"><?php echo $client_huf_comp;?></select></td>
											</tr>
										</table>
									</td>
									<td>
										<input type="button" id = "addhufmember_id" value="Add Row" onClick="addhufmember()">&nbsp;&nbsp;<input type="button" value="Delete" onClick="deletehufmember()">
									</td>
								</tr>
							</table>
						</td>
						</tr>
					</table>
					</td>
				</tr>
				<tr id="ca_tr" style="display:none;">
					<td> Client Name</td>
					<td><select id="taddressbook_ds_form_addressbook_id_ca" name="addressbook_id_ca" class="select ui-widget-content ui-corner-all"><?php echo $individual;?></select></td>
					<td> Membership Number</td>
					<td><input type="text" name="membership_number" id="taddressbook_ds_form_membership_number" class="text ui-widget-content ui-corner-all"/></td>
					<td> Firm Registration Number</td>
					<td><input type="text" name="firm_registration_number" id="taddressbook_ds_form_firm_registration_number" class="text ui-widget-content ui-corner-all"/></td>
				</tr>
				<!--tr id="company_tr" style="display:none;">
					<td> <span id="com_lable"></span></td>
					<td><input type="text" id="taddressbook_ds_form_company_name" name="company_name" class="text ui-widget-content ui-corner-all"></td>
					<td colspan="2">
						
					 </td>
					<td> Date of Incorporation</td>
					<td><input type="text" name="date_of_incorporation_com" id="taddressbook_ds_form_date_of_incorporation_com" class="date text ui-widget-content ui-corner-all"/></td>
				</tr---->
				<tr id="company_tr" style="display:none;">
					<td colspan="6">
					<table width="100%">
						<tr>
							<td colspan="2" width="50%">
								<table width="100%"><tr>
									<td> <span id="com_lable"></span></td>
									<td><input type="text" id="taddressbook_ds_form_company_name" name="company_name" class="text ui-widget-content ui-corner-all"></td>
									</tr>
								</table>
							</td>
							
							<td> Date of Incorporation</td>
							<td><input type="text" name="date_of_incorporation_com" id="taddressbook_ds_form_date_of_incorporation_com" class="date text ui-widget-content ui-corner-all"/></td>
						</tr>
						<tr>
						<td colspan ="4"><!--  -->
							<table border="0" width="69%">					
								<tr>
									<td>
										<table id="company_table" width="95%">
											<tr>
												<td>Pratners/Directors/Trustee</td>	
												<td><select id="taddressbook_ds_form_member_of_partner"name="member_of_partner[]" class=" cp_data select ui-widget-content ui-corner-all"><?php echo $client_huf_comp;?></select></td>
											</tr>
										</table>
									</td>
									<td>
										<input type="button" id = "addhufcompany_id" value="Add Row" onClick="addcompanymember()">&nbsp;&nbsp;<input type="button" value="Delete" onClick="deletecompanymember()">
									</td>
								</tr>
							</table>
						</td>
						</tr>
					</table>
					</td>
				</tr>
				<tr id="father_tr">
					<td> Father/Spose Name</td>
					<td><input type="text" name="father_spose_name" id="taddressbook_ds_form_father_spose_name" class="text ui-widget-content ui-corner-all"/></td>				
					<td> Birth Date</td>
					<td><input type="text" name="dob" id="taddressbook_ds_form_dob" class="date text ui-widget-content ui-corner-all"/></td>
					<td> Anniversary</td>
					<td><input type="text" name="anniversary" id="taddressbook_ds_form_anniversary" class="date text ui-widget-content ui-corner-all"/></td>
				</tr>
				<tr id="home_address_tr">
					<td>Home Address</td>
					<td><textarea name="home_address_1" id="taddressbook_ds_form_home_address_1" class="textarea ui-widget-content ui-corner-all"  /></textarea></td>
					<td>Country</td>
					<td><select id="taddressbook_ds_form_home_country" name="home_country" class="select ui-widget-content ui-corner-all" onChange="getChildCombo(this.value,'#taddressbook_ds_form_home_state', 'getState','city.php')"><?php echo $country;?></select></td>
					<td>State</td>
					<td><select id="taddressbook_ds_form_home_state" name="home_state" class="select ui-widget-content ui-corner-all" onChange="getChildCombo(this.value,'#taddressbook_ds_form_home_city', 'getCity','city.php')"><option value="">Please Select</option></select></td>
				</tr>
				<tr id="home_city_tr">					
					<td>City</td>
					<td><select id="taddressbook_ds_form_home_city" name="home_city" class="select ui-widget-content ui-corner-all"><option value="">Please Select</option></select></td>
					<td>PIN</td>
					<td><input type="text" name="home_pin" id="taddressbook_ds_form_home_pin" class="text ui-widget-content ui-corner-all"/></td>
                    <td> Religion</td>
					<td><select id="taddressbook_ds_form_religion" name="religion" class="select ui-widget-content ui-corner-all"><?php echo $religion; ?></select></td>
				</tr>
				<tr>
					<td>Office Address</td>
					<td><textarea name="office_address_1" id="taddressbook_ds_form_office_address_1" class="textarea ui-widget-content ui-corner-all"  /></textarea></td>
					<td>Country</td>
					<td><select id="taddressbook_ds_form_office_country" name="office_country" class="select ui-widget-content ui-corner-all" onChange="getChildCombo(this.value,'#taddressbook_ds_form_office_state', 'getState','city.php')"><?php echo $country;?></select></td>
					<td>State</td>
					<td><select id="taddressbook_ds_form_office_state" name="office_state" class="select ui-widget-content ui-corner-all" onChange="getChildCombo(this.value,'#taddressbook_ds_form_office_city', 'getCity','city.php')"><option value="">Please Select</option></select></td>	
				</tr>
				<tr>
					<td>City</td>
					<td><select id="taddressbook_ds_form_office_city" name="office_city" class="select ui-widget-content ui-corner-all"><option value="">Please Select</option></select></td>				
					<td> Email Address</td>
					<td><input type="text" name="email_address" id="taddressbook_ds_form_email_address" class="text ui-widget-content ui-corner-all"/></td>
					<td> Website</td>
					<td><input type="text" name="website" id="taddressbook_ds_form_website" class="text ui-widget-content ui-corner-all"/></td>
				</tr>				
				<tr>					
					<td>CIN</td>
					<td><input type="text" name="cin_number" id="taddressbook_ds_form_cin_number" class="text ui-widget-content ui-corner-all"/></td>
					<td> Fax Number</td>
					<td><input type="text" name="fax_number" id="taddressbook_ds_form_fax_number" class="text ui-widget-content ui-corner-all"/></td>
					<td> Ward</td>
					<td><input type="text" name="ward" id="taddressbook_ds_form_ward" class="text ui-widget-content ui-corner-all"/></td>
				</tr>
				
					<tr>					
						<td> Contact Person 1</td>
						<td><input type="text" name="con_person" id="taddressbook_ds_form_con_person" class="text ui-widget-content ui-corner-all"/></td>
						<td> Contact Type</td>
						<td><select name="con_type" id="taddressbook_ds_form_con_type" class="select ui-widget-content ui-corner-all"><?php echo $contact_type; ?></select></td>
						<td> Contact No</td>
						<td><input type="text" name="contact_no" id="taddressbook_ds_form_contact_no" class="text ui-widget-content ui-corner-all"/></td>
					</tr>
					<tr>
						<td colspan="6"><table width="100%"><tr>					
							<td width="30%"> Allow to send sms to contact person1</td>
							<td width="20%"><input type="checkbox" name="allow_to_send_con_one_sms" id="taddressbook_ds_form_allow_to_send_con_one_sms" style="width:10px;" class="text ui-widget-content ui-corner-all" value="1" /></td><td width="50%"></td>
						</tr></table></td>
					</tr>
					<tr>					
						<td> Contact Person 2</td>
						<td><input type="text" name="con_person2" id="taddressbook_ds_form_con_person2" class="text ui-widget-content ui-corner-all"/></td>
						<td> Contact Type</td>
						<td><select name="con_type2" id="taddressbook_ds_form_con_type2" class="select ui-widget-content ui-corner-all"><?php echo $contact_type; ?></select></td>
						<td> Contact No</td>
						<td><input type="text" name="contact_no2" id="taddressbook_ds_form_contact_no2" class="text ui-widget-content ui-corner-all"/></td>
					</tr>
					<tr>
						<td colspan="6"><table width="100%"><tr>					
							<td width="30%"> Allow to send sms to contact person2</td>
							<td width="20%"><input type="checkbox" name="allow_to_send_con_two_sms" id="taddressbook_ds_form_allow_to_send_con_two_sms" style="width:10px;" class="text ui-widget-content ui-corner-all" value="1" /></td><td width="50%"></td>
						</tr></table></td>
					</tr>
					<tr>					
						<td> Contact Person 3</td>
						<td><input type="text" name="con_person3" id="taddressbook_ds_form_con_person3" class="text ui-widget-content ui-corner-all"/></td>
						<td> Contact Type</td>
						<td><select name="con_type3" id="taddressbook_ds_form_con_type3" class="select ui-widget-content ui-corner-all"><?php echo $contact_type; ?></select></td>
						<td> Contact No</td>
						<td><input type="text" name="contact_no3" id="taddressbook_ds_form_contact_no3" class="text ui-widget-content ui-corner-all"/></td>
					</tr>
					<tr>
						<td colspan="6"><table width="100%"><tr>					
							<td width="30%"> Allow to send sms to contact person3</td>
							<td width="20%"><input type="checkbox" name="allow_to_send_con_three_sms" id="taddressbook_ds_form_allow_to_send_con_three_sms" style="width:10px;" class="text ui-widget-content ui-corner-all" value="1" /></td><td width="50%"></td>
						</tr></table></td>
					</tr>
					<tr>					
						<td> Contact Person 4</td>
						<td><input type="text" name="con_person4" id="taddressbook_ds_form_con_person4" class="text ui-widget-content ui-corner-all"/></td>
						<td> Contact Type</td>
						<td><select name="con_type4" id="taddressbook_ds_form_con_type4" class="select ui-widget-content ui-corner-all"><?php echo $contact_type; ?></select></td>
						<td> Contact No</td>
						<td><input type="text" name="contact_no4" id="taddressbook_ds_form_contact_no4" class="text ui-widget-content ui-corner-all"/></td>
					</tr>
					<tr>
						<td colspan="6"><table width="100%"><tr>					
							<td width="30%"> Allow to send sms to contact person4</td>
							<td width="20%"><input type="checkbox" name="allow_to_send_con_four_sms" id="taddressbook_ds_form_allow_to_send_con_four_sms" style="width:10px;" class="text ui-widget-content ui-corner-all" value="1" /></td><td width="50%"></td>
						</tr></table></td>
					</tr>
				<tr>
					<td> Pan Number</td>
					<td><input type="text" name="pan_number" id="taddressbook_ds_form_pan_number" class="text ui-widget-content ui-corner-all"/></td>
					<td> Advocate</td>
					<td><select id="taddressbook_ds_form_advocate_id" name="advocate_id" class="select ui-widget-content ui-corner-all"></select></td>
					<td> Accoutant</td>
					<td><select id="taddressbook_ds_form_accoutant_id" name="accoutant_id" class="select ui-widget-content ui-corner-all"></select></td>
				</tr>		
				<tr>
					<td> Tan Number</td>
					<td><input type="text" name="tan_number" id="taddressbook_ds_form_tan_number" class="text ui-widget-content ui-corner-all"/></td>				
					<td> Service Tax Number</td>
					<td><input type="text" name="service_tax_number" id="taddressbook_ds_form_service_tax_number" class="text ui-widget-content ui-corner-all"/></td>
					
					<td> Type </td>
					<td><select id="taddressbook_ds_form_type" name="type" class="select ui-widget-content ui-corner-all">
						<option value="A">A</option>
						<option value="B">B</option>
						<option value="C">C</option>
					</select></td>
				</tr>
				<tr>
					<td colspan="6">
					<table width="100%">
						<tr>
							<td width="8%" valign="top">File List</td><td width="19%"><input type="checkbox" style="width:10px;" name="filelist" id="taddressbook_ds_form_add_filelist" /></td>
						</tr>
					</table>
					</td>	
				</tr>
				<tr>
				<td colspan="3" id="taddressbook_ds_form_filelist_form" style="display:none;"><!--  -->
				<table border="0" width="100%">					
					<tr>
						<td colspan="3">
							<table id="f_table" width="100%">
								<tr>
									<td valign="top">File List Category</td>
									<td valign="top">No</td>
								</tr>
								<tr>
									<td valign="top" width="50%">
									<select name="f_category[]" id="f_category" class=" jobaddLoc_add select ui-widget-content ui-corner-all"><?php echo $category_name; ?></select></td>
									<td  width="25%"><input name="f_no[]" id="f_no" type="text" class="jobaddLoc_add text ui-widget-content ui-corner-all"></td>
									<td width="50%">
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td colspan="3">
						<input type="button" id = "addfilelistbtn" value="Add Row" onClick="addfilelist(1)">&nbsp;&nbsp;<input type="button" value="Delete" onClick="deletefilelist()">
						</td>
					</tr>
					</table>
				 </td>
				</tr>
				<tr>	
					<td colspan="6"><table width="100%"><tr>				
						<td width="30%"> Allow to send event trigger sms</td>
						<td width="20%"><input type="checkbox" name="allow_to_send_event_trigger_sms" id="taddressbook_ds_form_allow_to_send_event_trigger_sms" style="width:10px;" class="text ui-widget-content ui-corner-all" value="1" /></td>
						<td width="30%"> Allow to send birthday sms</td>
						<td width="20%"><input type="checkbox" name="allow_to_send_birthday_sms" id="taddressbook_ds_form_allow_to_send_birthday_sms" style="width:10px;" class="text ui-widget-content ui-corner-all" value="1" /></td>
					</tr></table></td>
				</tr>	
				<tr>
					<td colspan="6"><table width="100%"><tr>					
						<td width="30%"> Allow to send annivesary sms</td>
						<td width="20%"><input type="checkbox" name="allow_to_send_annivesary_sms" id="taddressbook_ds_form_allow_to_send_annivesary_sms" style="width:10px;" class="text ui-widget-content ui-corner-all" value="1" /></td>
						<td width="30%"> Allow to send pre scheduled sms</td>
						<td width="20%"><input type="checkbox" name="allow_to_send_pre_scheduled_sms" id="taddressbook_ds_form_allow_to_send_pre_scheduled_sms" style="width:10px;" class="text ui-widget-content ui-corner-all" value="1" /></td>
					</tr></table></td>
				</tr>
				<tr>
					<td valign="top"> Comment</td>				
					<td colspan="5" ><textarea name="comments" id="taddressbook_ds_form_comments" class="textarea ui-widget-content ui-corner-all"  /></textarea></td>
				</tr>
				<tr>
					<td colspan="6" align="center"><input type="button" id="addBtnAddressbook" value="Save" />					
					&nbsp;&nbsp;<input type="button" id="cancelAddAddressbook" value="Cancel" /></td>
				</tr>
			</tbody>
		</table>
	</fieldset>
</form>
</div>
<style type="text/css">
#view th {
	font-weifht:bold;
	text-align:left;
	vertical-align:top;
	border-bottom:#3399CC solid 1px;
}
#view td { vertical-align:top; height:25px; border-bottom:#3399CC solid 1px; }

</style>
<div id="view" style="display:none">
	<input type="hidden" id="adr_id" />
<table width="100%">
	<tr>
		<td align="left"><input type="button" onClick="back2List()" value="Back to List" /> &nbsp;&nbsp;</td><td><input type="button" onClick="editFromView()" value="Edit" /> &nbsp;&nbsp;</td>
		<td colspan="2" align="right"><input type="button" onClick="previous()" value="Previous" /> &nbsp;&nbsp;<input type="button" onClick="next()" value="Next" /></td>
	</tr>
	<tr>
		<th width="20%">Status :</th>
		<td width="30%" id="adr_status_name"></td>
		<th width="20%">HUF/Company/Trust :</th>
		<td width="30%" id="adr_com_huf"></td>
	</tr>
	<tr>
		<th width="20%">Group :</th>
		<td width="30%" id="adr_group_name"></td>
		<th width="20%">Category :</th>
		<td width="30%" id="adr_category_name"></td>
	</tr>
	<tr>
		<th width="20%">Advocate :</th>
		<td width="30%" id="adr_advocate_id"></td>
		<th width="20%">Accoutant :</th>
		<td width="30%" id="adr_accoutant_id"></td>
	</tr>
	<tr>	
		<th width="20%">Services :</th>
		<td width="30%" id="adr_sub_service"></td>
		<th width="20%">Full Name :</th>
		<td width="30%" id="adr_first_name"></td>
	</tr>
	<tr>
		
		<th width="20%">Father/Spose Name :</th>
		<td width="30%" id="adr_father_spose_name"></td>
		<th width="20%">Birth Date :</th>
		<td width="30%" id="adr_dob"></td>
		
	</tr>
	<tr>
		<th width="20%">Anniversary :</th>
		<td width="30%" id="adr_anniversary"></td>
		<th width="20%">Home Address :</th>
		<td width="30%" id="adr_home_address_1"></td>
		
	</tr>
	<tr>
		<th width="20%">City :</th>
		<td width="30%" id="adr_home_city"></td>
		<th width="20%">Pin :</th>
		<td width="30%" id="adr_home_pin"></td>

	</tr>
	<tr>
		
		<th width="20%">State :</th>
		<td width="30%" id="adr_home_state"></td>
		<th width="20%">Country :</th>
		<td width="30%" id="adr_home_country"></td>
	</tr>
	<tr>
		<th width="20%">Office Address :</th>
		<td width="30%" id="adr_office_address_1"></td>
		<th width="20%">City :</th>
		<td width="30%" id="adr_office_city"></td>
	</tr>
	<tr>
		<th width="20%">Pin :</th>
		<td width="30%" id="adr_office_pin"></td>
		<th width="20%">State :</th>
		<td width="30%" id="adr_office_state"></td>
	</tr>
	<tr>
		<th width="20%">Country :</th>
		<td width="30%" id="adr_office_country"></td>
		<th width="20%">CIN Number :</th>
		<td width="30%" id="adr_cin_number"></td>
	</tr>
	<tr>
		<th width="20%">Email Address :</th>
		<td width="30%" id="adr_email_address"></td>
		<th width="20%">Contact Person :</th>
		<td width="30%" id="adr_con_person"></td>
	</tr>
	<tr>
		<th width="20%">Contact No :</th>
		<td width="30%" id="adr_contact_no"></td>
		<th width="20%">Allow to Send Sms :</th>
		<td width="30%" id="adr_contact_one_sms"></td>
		
	</tr>
	<tr>
		<th width="20%">Contact Type :</th>
		<td width="30%" id="adr_con_type"></td>
		
		<th width="20%">Contact Person2:</th>
		<td width="30%" id="adr_con_person2"></td>

	</tr>
	<tr>
		<th width="20%">Contact No2 :</th>
		<td width="30%" id="adr_contact_no2"></td>
		
		<th width="20%">Allow to Send Sms :</th>
		<td width="30%" id="adr_contact_two_sms"></td>
		
	</tr>
	<tr>
		<th width="20%">Contact Type2 :</th>
		<td width="30%" id="adr_con_type2"></td>
		<th width="20%">Contact Person3:</th>
		<td width="30%" id="adr_con_person3"></td>
	</tr>
	<tr>
		<th width="20%">Contact No3 :</th>
		<td width="30%" id="adr_contact_no3"></td>
		<th width="20%">Allow to Send Sms :</th>
		<td width="30%" id="adr_contact_three_sms"></td>
	</tr>
	<tr>
		<th width="20%">Contact Type3 :</th>
		<td width="30%" id="adr_con_type3"></td>
		
		<th width="20%">Contact Person4:</th>
		<td width="30%" id="adr_con_person4"></td>
	</tr>
	<tr>
		<th width="20%">Contact No4 :</th>
		<td width="30%" id="adr_contact_no4"></td>
		
		<th width="20%">Allow to Send Sms :</th>
		<td width="30%" id="adr_contact_four_sms"></td>
	</tr>
	<tr>
		<th width="20%">Contact Type4 :</th>
		<td width="30%" id="adr_con_type4"></td>
		
		<th width="20%">Website :</th>
		<td width="30%" id="adr_website"></td>
	</tr>	
	<tr>
		<th width="20%">PAN Number :</th>
		<td width="30%" id="adr_pan_number"></td>

		<th width="20%">TAN Number :</th>
		<td width="30%" id="adr_tan_number"></td>
	</tr>
	<tr>
		<th width="20%">Service Tax Number :</th>
		<td width="30%" id="adr_service_tax_number"></td>
		<th width="20%">Religion :</th>
		<td width="30%" id="adr_religion_name"></td>
	</tr>
	<tr>
		<th width="20%">Ward :</th>
		<td width="30%" id="adr_ward"></td>
		<th width="20%">Fax Number :</th>
		<td width="30%" id="adr_fax_number"></td>
	</tr>
	<tr>
		<th width="20%">Event Trigger Sms :</th>
		<td width="30%" id="adr_trigger_sms"></td>

		<th width="20%">Birthday Sms :</th>
		<td width="30%" id="adr_birthday_sms"></td>
	</tr>
	<tr>
		<th width="20%">Annivesary Sms :</th>
		<td width="30%" id="adr_annivesary_sms"></td>
		<th width="20%">Scheduled Sms :</th>
		<td width="30%" id="adr_scheduled_sms"></td>
	</tr>
	<tr>
		<th width="20%">Type :</th>
		<td width="30%" id="adr_type"></td>
		<th width="20%">Comments :</th>
		<td width="30%" id="adr_comments"></td>
	</tr>
</table>
</div>
<div id="contacts_frm_div_sms" style="display:none">
 <p id="tsend_sms_ds_error" class="addTips">* Fields are mendatory</p>
   <div id="demo">
        <form method="post" name="frmAdd" id="update_sms_email_frm" action="" title='' style="width:100%;margin:0px;">
    
	    <label for="sheets">Contact</label><br />
        <input type="text" style="width:500px; height: 30px;" name="contact_sms_contact" id="contact_sms_contact" class="text ui-widget-content ui-corner-all" readonly/>
        <br /><br />
	
        <label for="sheets">SMS Content</label><br />
       <textarea rows="8" cols="100" id="sms_content" name="sms_content" ></textarea>
        <br /><br />
    
        
	<input type="button" value="Send" id="sendSmsBtn">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="Cancle" id="sendSmscloseBtn">
	</form>
   </div>
</div>
<script type="text/javascript">$("#divAjaxIndex").dialog("close");</script>
</body>
</html>
