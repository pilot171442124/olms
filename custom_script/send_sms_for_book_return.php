<?php

$BOOK_RETURN_ALERT_DAY = 3;



ini_set('max_execution_time', 36000);
 
$conn = mysqli_connect('127.0.0.1', 'cityolms_usermain', 'rHKD12Otklfygc', 'cityolms_dbmain');
// Check connection
if ($conn === false) {
	die("ERROR: Could not connect. " . mysqli_connect_error());
}
mysqli_set_charset($conn, "utf8");


 $sql = "SELECT a.RequestId, a.UserId, b.name UserName, a.BookId, c.BookName, b.phone, a.IssueDate, DATEDIFF(NOW(),a.IssueDate) IssuedDay
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
		send_sms($tmpUserPhone, $tmpUserName, $tmpBooks);
		$tmpBooks = '';
		
	}
	
	$RequestId = $row['RequestId'];
	$BookId = $row['BookId'];

	$tmpUserId = $row['UserId'];
	$tmpUserName = $row['UserName'];
	$tmpUserPhone = $row['phone'];
	
	if($tmpBooks == ""){
		$tmpBooks = $row['BookName'];
	}else{
		$tmpBooks .= ", ".$row['BookName'];
	}
	

	//sms log
	$Days=$BOOK_RETURN_ALERT_DAY;
	$curDateTime = date ( 'Y-m-d' );
	// $Status='ReturnRequest';
	// $SMSCount=1;
	// $FineAmount=0;
	$sql = "update t_bookrequest set RetSMSDate='$curDateTime', FirstSMSDays=$Days where RequestId=$RequestId;";
	$result = mysqli_query($conn,$sql);


// $table->date('RetSMSDate')->nullable();
// $table->integer('FirstSMSDays')->length(10)->unsigned()->nullable();
// $table->date('FineFirstSMSDate')->nullable();
// $table->integer('FineSMSCount')->length(10)->unsigned()->nullable();
// $table->integer('FineAmount')->length(10)->unsigned()->nullable();

$idx++;
	
}

if($tmpUserId>0){
	send_sms($tmpUserPhone, $tmpUserName, $tmpBooks);
}

echo "Total $idx SMS sent";






function send_sms($number, $userName, $books){
	//POST Method example
	$url = "http://66.45.237.70/api.php";
	// $number="88017,88018,88019";
	// $number="01689763654";// we can multiple number using coma seperator
	// $message="Hello Bangladesh";
	$message="Hello $userName, Please return $books book timely";
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
