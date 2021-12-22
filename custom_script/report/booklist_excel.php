<?php

include ("databaseconnection.php"); /* * *Connection information** */
$conn = mysqli_connect(HOSTNAME, DBUSER, DBPWD, DBNAME) or die('Could not connect to database');
mysqli_query($conn,'SET CHARACTER SET utf8');
include_once("xlsxwriter/xlsxwriter.class.php");

$fDepartmentId = $_GET['fDepartmentId']; 

$header = array(
  'Sl'=>'0',//integer
  'Department'=>'@',
  'Book Name'=>'@',
  'Author Name'=>'@',
  'Total Copy'=>'0',
  'BookType'=>'@',
  'Access'=>'@'
);
// $writer->writeSheetRow($sheetName, array($i++, $val['Department'],$val["BookName"],
	// $val['AuthorName'],$val['TotalCopy'],$val['BookType'],$val['BookAccessType']),$rowStyle );
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
$reportHeaders = array('Online Library Management System','Book List');

$writer->writeSheetHeader(
			$sheetName, 
			$header, 
			array(
				'widths'=>array(8,15,25,20,20,15,12),
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

 $sql = "SELECT a.*,BookType,BookType,Department,BookAccessType
FROM `t_books` a 
INNER JOIN t_booktypes b ON a.BookTypeId=b.BookTypeId
INNER JOIN t_bookaccesstype c ON a.BookAccessTypeId=c.BookAccessTypeId
INNER JOIN t_department d ON a.DepartmentId=d.DepartmentId
where (a.DepartmentId=$fDepartmentId OR $fDepartmentId=0)
ORDER BY Department asc, BookName asc;";

$result = mysqli_query($conn, $sql);
$i = 1;

while ($val = mysqli_fetch_array($result)) {
	$writer->writeSheetRow($sheetName, array($i++, $val['Department'],$val["BookName"],
	$val['AuthorName'],$val['TotalCopy'],$val['BookType'],$val['BookAccessType']),$rowStyle );

}

//Report header merge
if(count($reportHeaders)>0){
	$writer->markMergedCell($sheetName, $start_row=0, $start_col=0, $end_row=0, $end_col=6);
	$writer->markMergedCell($sheetName, $start_row=1, $start_col=0, $end_row=1, $end_col=6);
} 


$exportFileName="book_list_".date("Y_m_d_H_i_s").".xlsx";
$writer->writeToFile("media/".$exportFileName);
header('Location:./media/'.$exportFileName); //File open location	









