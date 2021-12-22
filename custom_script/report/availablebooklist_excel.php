<?php

include ("databaseconnection.php"); /* * *Connection information** */
$conn = mysqli_connect(HOSTNAME, DBUSER, DBPWD, DBNAME) or die('Could not connect to database');
mysqli_query($conn,'SET CHARACTER SET utf8');
include_once("xlsxwriter/xlsxwriter.class.php");

// $YearId = $_GET['YearId'];
// $SemesterId = $_GET['SemesterId'];
// $SubjectId = $_GET['SubjectId'];
// $YearText = $_GET['YearText'];
// $SemesterText = $_GET['SemesterText'];
// $SubjectText = $_GET['SubjectText'];

$header = array(
  'Sl'=>'0',//integer
  'Book Name'=>'@',
  'Author Name'=>'@',
  'Total Copy'=>'0',
  'Available Copy'=>'0'
);

/* 
$header = array(
  'Sl'=>'0',//integer
  'Province'=>'@',//text
  'BCZ'=>'@',//text
  'Facility'=>'@',//text
  'Product Group'=>'@',//text
  'Product Name'=>'@',//text
  'OP Stock'=>'integer',
  'Receive'=>'integer',
  'Dispense'=>'integer',
  'Adj Stock'=>'integer',
  'CL Stock'=>'integer',
  'AMC'=>'integer',
  'MOS'=>'integer'//,
  // 'c4-integer'=>'0',
  // 'c5-price'=>'price',
  // 'c6-price'=>'#,##0.00',//custom
  // 'c7-date'=>'date',
  // 'c8-date'=>'YYYY-MM-DD',
); */


$writer = new XLSXWriter();
$sheetName = "Data";
$reportHeaders = array('Online Library Management System','Available Book List');

$writer->writeSheetHeader(
			$sheetName, 
			$header, 
			array(
				'widths'=>array(8,18,30,18,18),
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

	
$sql = "SELECT a.*,BookAccessType,
(select count(*) from t_bookrequest p where a.BookId=p.BookId and p.Status='Issued') IssuedCopy
FROM `t_books` a 
INNER JOIN t_bookaccesstype b ON a.BookAccessTypeId=b.BookAccessTypeId
where BookTypeId=1
ORDER BY BookName;";

$result = mysqli_query($conn, $sql);
$i = 1;

while ($val = mysqli_fetch_array($result)) {
	$AvailableCopy = $val['TotalCopy']-$val['IssuedCopy'];
	$writer->writeSheetRow($sheetName, array($i++, $val['BookName'],$val["AuthorName"],$val['TotalCopy'],$AvailableCopy),$rowStyle );

}

//Report header merge
if(count($reportHeaders)>0){
	$writer->markMergedCell($sheetName, $start_row=0, $start_col=0, $end_row=0, $end_col=4);
	$writer->markMergedCell($sheetName, $start_row=1, $start_col=0, $end_row=1, $end_col=4);
} 


$exportFileName="available_booklist_".date("Y_m_d_H_i_s").".xlsx";
$writer->writeToFile("media/".$exportFileName);
header('Location:./media/'.$exportFileName); //File open location	









