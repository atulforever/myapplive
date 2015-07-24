<?php include("php/db.php"); ?>
<?php include("function.php"); ?>
<?php
putenv("TZ=Asia/Calcutta");
//echo date("h:i:s");
$mobArr = array();

/*$tSql = "select job.*, service.service_name, sbm.sub_service_name, sbm.alert_days_interval, sms.sms_text from job_mst job
	LEFT JOIN service_mst service ON service.id = job.service
	LEFT JOIN sub_service_mst sbm ON sbm.id = job.sub_service
	LEFT JOIN sms_format sms ON sms.id = sbm.re_ccurring_sms_format_id
where date_format(job.due_date,'%Y-%m-%d %H:%i') > '".date(DATE_TIME)."' AND date_format(job.add_date,'%Y-%m-%d %H:%i') < '".date(DATE_TIME)."' AND job.date_of_complition is null AND job.del_date is null AND job.status = 1 order by job.id desc";

$tRs = mysql_query($tSql);
while($tRow = mysql_fetch_array($tRs)){
	
	if($tRow['alert_days_interval'] != "" || $tRow['alert_days_interval'] != 0){
		
		$min_1 = $tRow['alert_days_interval'] * 24 * 60;	//convert in minutes
		if($min_1 == 0 || $min_1 == ''){
			continue;
		}
		$minutes = round(abs(strtotime(date('Y-m-d H:i:s')) - strtotime($tRow['add_date'])) / 60,2);
		//$minutes = round(abs(mktime(0,0,15,1,1,2011) - mktime(0,0,15,1,13,2011)) / 60,2);	 // testing
		$d = floor ($minutes / 1440);
		$h = floor (($minutes - $d * 1440) / 60);
		$m = floor($minutes - ($d * 1440) - ($h * 60));
		
		$min_2 = ($d * 24 * 60) + ($h * 60) + $m;		//calculate minutes between current datetime and add date time
		
		$intrval = intval($min_2) / intval($min_1);
		//echo $intrval."<br>";
		
		if(is_int($intrval) == 1){				
			
			$sms_format	= make_sms_string($tRow['sms_text'], $tRow['client_id'], $tRow['sub_service']);
			
			$selMob = "SELECT * FROM addressbook WHERE id =".$tRow['client_id'];
			$resMob = mysql_query($selMob) or generateMSG('',$selMob . mysql_error(),false);
			$rowMob = mysql_fetch_array($resMob);
			$sms_number = $tRow['sms_number'];
			
			$sms_number = explode(",",$sms_number);
			for($i=0; $i<count($sms_number); $i++){				
				
				$insertSms="insert into smsout (MobNo, Message, SMSInterface, Status_inner, datetime) values('".$sms_number[$i]."', '".$sms_format."', 'GSMModem', 'Pending', '$datetime')";
				mysql_query($insertSms);
			}			
		}
	}
}*/

$today = date('Y-m-d');
$tSql = "select jd.add_date, ad.sms_number, sms.sms_text, jd.client_id, jd.sub_service, stage.stage_name from job_details jd LEFT JOIN sms_format sms ON sms.id = jd.sms_id LEFT JOIN users ad ON ad.id = jd.assigned_id LEFT JOIN stage ON stage.id = jd.stage_id where date(jd.due_date) > '$today' and jd.job_status = 'Pending' and jd.del_date is null and jd.status = 1 and jd.sms_id is not null and ad.sms_number is not null";

$tRs = mysql_query($tSql);
$smsArr = array();
while($tRow = mysql_fetch_array($tRs)){
	
	$minutes = round(abs(strtotime('Y-m-d H:i') - strtotime(date('Y-m-d H:i', strtotime($tRow['add_date'])))) / 60,2);
	
	$sms_number = $tRow['sms_number'];
	
	$diff = intval($minutes) / intval(1440);
	
	if(is_int($diff) == 1){	
		$sms_format	= make_sms_string($tRow['sms_text'], $tRow['client_id'], $tRow['sub_service']);	
							
		$sms_format	= "Reminder: ".$sms_format;
			
		$sms_number = explode(",",$sms_number);
		for($i=0; $i<count($sms_number); $i++){				
			
			$smsArr[] = $sms_number[$i];
			
		}	
	}
}

$smsArr = array_unique($smsArr);

for($j=0; $j<count($smsArr); $j++){				
	
	$sql = "select * from users where sms_number = '".$smsArr[$j]."'";
	$res = mysql_query($sql) or generateMSG(false,mysql_error());
	$row = mysql_fetch_array($res);
	$pattern[1]		= "/\[user\]/";
	$replace[1]	= $row['first_name'];
	$sms_text = preg_replace($pattern,$replace,strtolower($sms_format));
				
	$insertSms="insert into smsout (MobNo, Message, SMSInterface, Status_inner, datetime) values('".$smsArr[$j]."', '".$sms_text."', 'GSMModem', 'Pending', '$datetime')";
	mysql_query($insertSms);
}
?>