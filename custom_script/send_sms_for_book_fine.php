<?php

$BOOK_RETURN_ALERT_DAY = 0;



ini_set('max_execution_time', 36000);

$conn = mysqli_connect('127.0.0.1', 'cityolms_usermain', 'rHKD12Otklfygc', 'cityolms_dbmain');
// Check connection
if ($conn === false) {
	die("ERROR: Could not connect. " . mysqli_connect_error());
}
mysqli_set_charset($conn, "utf8");




// ******************************************************************************
// ********************************First fine SMS*****************************
// *****************************************************************************
$sql = "SELECT a.RequestId, a.UserId, b.name UserName, a.BookId, c.BookName, 
 b.phone, a.IssueDate, DATEDIFF(NOW(),a.IssueDate) IssuedDay, 
 IFNULL(`FineSMSCount`,0) FineSMSCount, IFNULL(`FineAmount`,0) FineAmount
FROM t_bookrequest a
INNER JOIN `users` b ON a.UserId=b.id
INNER JOIN `t_books` c ON a.BookId=c.BookId
WHERE a.`Status`='Issued'
HAVING IssuedDay=$BOOK_RETURN_ALERT_DAY
ORDER BY a.UserId;";
// exit;
$result = mysqli_query($conn,$sql);

$idx = 0;
$tmpUserId = 0;
$tmpUserPhone = '';
$tmpUserName = '';
$tmpBooks = '';
while ($row = mysqli_fetch_array($result)) {
	$UserId = $row['UserId'];
	
	if(($idx > 0) && ($tmpUserId != $UserId)){
		send_sms($tmpUserPhone, $tmpUserName, $tmpBooks, 1);
		$tmpBooks = '';
		
	}
	
	$RequestId = $row['RequestId'];
	$tmpUserId = $row['UserId'];
	$tmpUserName = $row['UserName'];
	$tmpUserPhone = $row['phone'];
	
	if($tmpBooks == ""){
		$tmpBooks = $row['BookName'];
	}else{
		$tmpBooks .= ", ".$row['BookName'];
	}
	

	//sms log
	$curDateTime = date ( 'Y-m-d' );
	// $FineSMSCount = $row['FineSMSCount'];
	// $FineAmount = $row['FineAmount'];
	
	//Increment fine as different date.(first week 200),(second week 100),(third week 50).
	$SMSCount=1;
	$FineAmount=200;
	$sql1 = "update t_bookrequest set FineFirstSMSDate='$curDateTime', FineSMSCount=$SMSCount, FineAmount=$FineAmount 
	where RequestId=$RequestId;";
	$result1 = mysqli_query($conn,$sql1);
	
	$idx++;
}

if($tmpUserId>0){
	send_sms($tmpUserPhone, $tmpUserName, $tmpBooks, 1);
}

echo "First Fine $idx SMS sent";






// ******************************************************************************
// ********************************Second fine SMS*****************************
// *****************************************************************************
$sql = "SELECT a.RequestId, a.UserId, b.name UserName, a.BookId, c.BookName, 
 b.phone, a.IssueDate, DATEDIFF(NOW(),a.IssueDate) IssuedDay, 
 IFNULL(`FineSMSCount`,0) FineSMSCount, IFNULL(`FineAmount`,0) FineAmount
FROM t_bookrequest a
INNER JOIN `users` b ON a.UserId=b.id
INNER JOIN `t_books` c ON a.BookId=c.BookId
WHERE a.`Status`='Issued'
HAVING IssuedDay=$BOOK_RETURN_ALERT_DAY + 7
ORDER BY a.UserId;";
// exit;
$result = mysqli_query($conn,$sql);

$idx = 0;
$tmpUserId = 0;
$tmpUserPhone = '';
$tmpUserName = '';
$tmpBooks = '';
while ($row = mysqli_fetch_array($result)) {
	$UserId = $row['UserId'];
	
	if(($idx > 0) && ($tmpUserId != $UserId)){
		send_sms($tmpUserPhone, $tmpUserName, $tmpBooks, 2);
		$tmpBooks = '';
		
	}
	
	$RequestId = $row['RequestId'];
	$tmpUserId = $row['UserId'];
	$tmpUserName = $row['UserName'];
	$tmpUserPhone = $row['phone'];
	
	if($tmpBooks == ""){
		$tmpBooks = $row['BookName'];
	}else{
		$tmpBooks .= ", ".$row['BookName'];
	}
	

	//sms log
	
	//Increment fine as different date.(first week 200),(second week 100),(third week 50).
	$SMSCount=2;
	$FineAmount=300;
	$sql1 = "update t_bookrequest set FineSMSCount=$SMSCount, FineAmount=$FineAmount where RequestId=$RequestId;";
	$result1 = mysqli_query($conn,$sql1);
	$idx++;
}

if($tmpUserId>0){
	send_sms($tmpUserPhone, $tmpUserName, $tmpBooks, 2);
}

echo "Second Fine $idx SMS sent";


// ******************************************************************************
// ********************************Second fine SMS*****************************
// *****************************************************************************
$sql = "SELECT a.RequestId, a.UserId, b.name UserName, a.BookId, c.BookName, 
 b.phone, a.IssueDate, DATEDIFF(NOW(),a.IssueDate) IssuedDay, 
 IFNULL(`FineSMSCount`,0) FineSMSCount, IFNULL(`FineAmount`,0) FineAmount
FROM t_bookrequest a
INNER JOIN `users` b ON a.UserId=b.id
INNER JOIN `t_books` c ON a.BookId=c.BookId
WHERE a.`Status`='Issued'
HAVING IssuedDay=$BOOK_RETURN_ALERT_DAY + 14
ORDER BY a.UserId;";
// exit;
$result = mysqli_query($conn,$sql);

$idx = 0;
$tmpUserId = 0;
$tmpUserPhone = '';
$tmpUserName = '';
$tmpBooks = '';
while ($row = mysqli_fetch_array($result)) {
	$UserId = $row['UserId'];
	
	if(($idx > 0) && ($tmpUserId != $UserId)){
		send_sms($tmpUserPhone, $tmpUserName, $tmpBooks, 3);
		$tmpBooks = '';
		
	}
	
	$RequestId = $row['RequestId'];
	$tmpUserId = $row['UserId'];
	$tmpUserName = $row['UserName'];
	$tmpUserPhone = $row['phone'];
	
	if($tmpBooks == ""){
		$tmpBooks = $row['BookName'];
	}else{
		$tmpBooks .= ", ".$row['BookName'];
	}
	

	//sms log
	
	//Increment fine as different date.(first week 200),(second week 100),(third week 50).
	$SMSCount=3;
	$FineAmount=350;
	$sql1 = "update t_bookrequest set FineSMSCount=$SMSCount, FineAmount=$FineAmount where RequestId=$RequestId;";
	$result1 = mysqli_query($conn,$sql1);
	$idx++;
}

if($tmpUserId>0){
	send_sms($tmpUserPhone, $tmpUserName, $tmpBooks, 3);
}

echo "Third Fine $idx SMS sent";




















function send_sms($number, $userName, $books, $sn){
	//POST Method example
	$url = "http://66.45.237.70/api.php";
	// $number="88017,88018,88019";
	// $number="01689763654";// we can multiple number using coma seperator
	// $message="Hello Bangladesh";
	
	if($sn == 1){
		$message="Hello $userName, You can not return $books book timely. As fine 200 TK every book.";
	}
	else if($sn == 2){
		$message="Hello $userName, You can not return $books book timely. As fine 300 TK every book.";
	}
	else if($sn == 3){
		$message="Hello $userName, You can not return $books book timely. As fine 350 TK every book.";
	}
	
	$data= array(
		'username'=>"pilot",
		'password'=>"Z2PE7AY3",
		'number'=>"$number",
		'message'=>"$message"
	);
	
	$ch = curl_init(); // Initialize cURL
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$smsresult = curl_exec($ch);
	$p = explode("|",$smsresult);
	$sendstatus = $p[0];

	//Send SMS  from your database using php
	/* $query = mysql_query("SELECT * FROM smslog WHERE `status`='Pending' LIMIT 500");
	$row = mysql_num_rows($query );
	$x = '';
	while($val = mysql_fetch_array($mysql_query))
	{	
		$smsid= $val['id'];
		$number = $val['number'];
		$x = $x.$number.","; //number separated by comma
		$text=$val['message']; 
		mysql_query("UPDATE smslog SET status`='DELIVRD' WHERE id`='$smsid'");
	}
	$url = "http://66.45.237.70/api.php";
	$data= array(
		'username'=>"YourID",
		'password'=>"YourPasswd",
		'number'=>"$x",
		'message'=>"$text"
	);
	$ch = curl_init(); // Initialize cURL
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$smsresult = curl_exec($ch);
	$p = explode("|",$smsresult);
	$sendstatus = $p[0]; */
}
