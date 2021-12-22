<?php

include ("databaseconnection.php"); /* * *Connection information** */
$conn = mysqli_connect(HOSTNAME, DBUSER, DBPWD, DBNAME) or die('Could not connect to database');
mysqli_query($conn,'SET CHARACTER SET utf8');
include_once("xlsxwriter/xlsxwriter.class.php");

$header = array(
  'Sl'=>'0',//integer
  'User Name'=>'@',
  'ID'=>'@',
  'Phone No'=>'@',
  'Email'=>'@',
  'Role'=>'@',
  'Access'=>'@'
);

$writer = new XLSXWriter();
$sheetName = "Data";
$reportHeaders = array('Online Library Management System','User List');

$writer->writeSheetHeader(
			$sheetName, 
			$header, 
			array(
				'widths'=>array(8,15,25,25,15,15,12),
				'font-style'=>'bold',
				'font-size'=>11,
				'fill'=>'#b4c6e7',
				'border'=>'left,right,top,bottom',
				// 'border'=>'left,left,left,right,right,right,left',
				'border-style'=>'thin',
				// 'border-style'=>'',
				'halign'=>'left',
				'report_headers'=>$reportHeaders
			)
		);

$rowStyle = array( 'border'=>'left,right,top,bottom','border-style'=>'thin');

 $sql = "SELECT a.*
FROM `users` a 
ORDER BY name asc;";

$result = mysqli_query($conn, $sql);
$i = 1;

while ($val = mysqli_fetch_array($result)) {
	$writer->writeSheetRow($sheetName, array($i++, $val['name'],$val["usercode"],
	$val['phone'],$val['email'],$val['userrole'],$val['activestatus']),$rowStyle );

}

//Report header merge
if(count($reportHeaders)>0){
	$writer->markMergedCell($sheetName, $start_row=0, $start_col=0, $end_row=0, $end_col=6);
	$writer->markMergedCell($sheetName, $start_row=1, $start_col=0, $end_row=1, $end_col=6);
} 


$exportFileName="user_list_".date("Y_m_d_H_i_s").".xlsx";
$writer->writeToFile("media/".$exportFileName);
header('Location:./media/'.$exportFileName); //File open location	









